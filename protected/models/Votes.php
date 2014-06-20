<?php

class Votes extends RedisActiveRecord
{
    public $nick;
    public $useragent;
    public $hash;
    public $ip;
    public $danger;
    public $time;
    public $project;
    public $country;
    protected $className = __CLASS__;
    protected $preffix = 'vote_';

    public function fillData($array)
    {
        foreach ($array as $key => $value)
            $this->$key = $value;
    }

    /**
     * @param string $className
     * @return Votes
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function RegisterVote()
    {
        /**
         * @var $redis Redis
         */

        $voter_country = 'GG';
        $project = Projects::model()->findByPk($this->project);

        $redis = Yii::app()->redis->getClient();
        //$last_vote_interval = $redis->lrange('project:votes:lastusers' . $this->project, 8, 9);
        // todo: lIndex here
        $last_vote_interval = $redis->lrange('project:votes:lastusers' . $this->project, 8, 9);
        $redis->hmset("vote:project:" . $this->project . ":user:" . Yii::app()->user->id, array(
            "time" => time(),
            "nick" => $this->nick,
            "useragent" => $_SERVER['HTTP_USER_AGENT'],
            "ip" => $_SERVER['REMOTE_ADDR'],
            "project" => $this->project,
            "country" => $voter_country
        ));

        $project->redisRecord->stats->project = $this->project;
        $project->redisRecord->stats->votes_month++;
        $project->redisRecord->stats->votes_all_period++;
        $project->redisRecord->stats->votes_today++;
        $project->recountScoreOnVote();
        $project->redisRecord->stats->save();
        $project->save() or die(print_r($project->getErrors()));

        $redis->set("_global_votes_count", Votes::model()->getVotesCount() + 1);

        if ($project->redisRecord->stats->votes_all_period > 10) {

            if (sizeof($last_vote_interval) > 0) {
                $new_interval = time() - $last_vote_interval['time'];
                $interval = $redis->hget("project:intervals:" . $this->project, "interval");
                $interval = $interval == FALSE ? 0 : $interval;
            } else {
                $new_interval = time();
                $interval = $redis->hget("project:intervals:" . $this->project, "interval");
                $interval = $interval == FALSE ? 0 : $interval;
            }

            $interval = ($interval * $project->redisRecord->stats->votes_all_period + $new_interval) / ($project->redisRecord->stats->votes_all_period + 1);
            $redis->hset("project:intervals:" . $this->project, "interval", $interval);
        }
        $redis->rPush('project:votes:lastusers:' . $this->project, $_SERVER['REMOTE_ADDR'] . '%' . $_SERVER['HTTP_USER_AGENT'] . '%' . time());
        $redis->lTrim('project:votes:lastusers:' . $this->project, 1, 10);


    }

    public function registerInQueue(Projects $project)
    {
        if ($project->give_bonuses) {
            $nickname = CHtml::encode($_POST['nickname']);
            if (isset($nickname)) {
                $mq = new MQClient();
                $token = md5($nickname.$project->secret_key);
                $mq->sendMessage("{$project->script_url}|$nickname|{$token}|" . $_SERVER['REMOTE_ADDR']);
            }
        }
    }

    public function Delete($project)
    {
        /**
         * @var $redis Redis
         */
        $redis = Yii::app()->redis->getClient();
        $vote = $redis->hgetall("vote:project:" . $project . ":user:" . Yii::app()->user->id);

        if (sizeof($vote) > 0)
            foreach ($vote as $key => $value)
                $redis->hdel("vote:project:" . $project . ":user:" . Yii::app()->user->id, $key);

    }

    public function isVoteExists($project)
    {
        $vote = Yii::app()->redis->getClient()->hgetall("vote:project:" . $project . ":user:" . Yii::app()->user->id);
        return $this->isTodayVote($vote);
    }

    public function isRepeatingUserAgent($project)
    {
        $lastusers = Yii::app()->redis->getClient()->lrange('project:votes:lastusers:' . $project, 0, 10);
        foreach ($lastusers as $key => $lastuser) {
            $info = explode('%', $lastuser);
            if ($info[0] == $_SERVER['REMOTE_ADDR'] ||
                $info[1] == $_SERVER['HTTP_USER_AGENT']
            )
                return true;
        }
        return false;
    }

    public function isWrongInterval($project)
    {
        $last_votes = Yii::app()->redis->getClient()->lrange('project:votes:lastusers:' . $project, 9, 9);
        if (is_array($last_votes)) {
            if (sizeof($last_votes) != 0) {
                $first_vote = explode('%', $last_votes[0]);
                $second_vote_time = time();
                $delta = $second_vote_time - $first_vote[2];
                $project_interval = Yii::app()->redis->getClient()->hget("project:intervals:" . $project, "interval");
                return $delta < $project_interval ? true : false;
            } else {
                return 'project_dont_have_votes';
            }
        }
    }

    public function isTodayVote($vote)
    {
        if (empty($vote))
            return false;

        return date("d/m/Y", time()) == date("d/m/Y", $vote['time']) ? true : false;
    }

    public static function getUserVote($project)
    {
        $vote = new Votes();

        $vote_info = Yii::app()->redis->getClient()->hgetall("vote:project:" . $project . ":user:" . Yii::app()->user->id);
        if (sizeof($vote_info) == 0)
            return null;

        foreach (get_class_vars('Votes') as $key => $value)
            if ($key <> 'db' & $key <> 'className' & $key <> 'preffix' & $key <> '_attributes')
                $vote->$key = $vote_info[$key];

        return $vote;
    }

    public function getVotesCount()
    {
        $count = Yii::app()->redis->getClient()->get("_global_votes_count");
        return $count == false ? 0 : $count;
    }
}
