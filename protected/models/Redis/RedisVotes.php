<?php

class RedisVotes extends _RedisHashAR
{
    public $time;
    public $is_having_flags;
    public $country;
    public $ip;
    public $referrer;
    public $nick;
    public $useragent;

    private $project_id;

    protected $_values_to_save = 'time:is_having_flags:country:ip:referrer:nick:useragent';

    public function __construct($args_array = null)
    {
        if(isset($_GET['id']))
            $this->project_id = (int) $_GET['id'];
        $this->id = 0;
        $this->db = Yii::app()->votes->getClient();
    }

    public function save($svl = null, $vote_id = null)
    {

        $this->beforeSave();

        if(!is_null($svl))
        {
            if($this->is_having_flags)
            {
                $svl_record = new RedisSVL();
                $svl_record->id = $vote_id;
                foreach($svl->flags as $key => $flag)
                    $svl_record->$key = $flag;
                $svl_record->save();
            }

            $this->key = 'project:' . $this->project_id . ':user_id:' . Yii::app()->user->id;

            foreach ($this->get_data_in_array() as $key => $value)
                $this->db->hset($this->key, $key, $value);
        }

        $project = Projects::model()->findByPk($this->project_id);
        $project->redisRecord->increment_votes_month();
        $project->redisRecord->increment_votes_all();
        $project->redisRecord->increment_votes_today();
        $project->recountScoreOnVote();
        $project->save();
    }

    private function get_data_in_array()
    {
        $keys = explode(':', $this->_values_to_save);
        foreach ($keys as $key) {
            $getter = 'get_' . $key;
            $data[$key] = call_user_func(get_called_class() . '::' . $getter);
        }
        return $data;
    }

    public function set_time($timestampt)
    {
        $this->time = $timestampt;
    }

    public function get_time()
    {
        return $this->time;
    }

    public function set_is_having_flags($value)
    {
        $this->is_having_flags = $value;
    }

    public function get_is_having_flags()
    {
        return $this->is_having_flags;
    }

    public function set_country()
    {
        if($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
            $_SERVER['REMOTE_ADDR'] = '85.113.195.213';

        $this->country = Yii::app()->SxGeo->getCountry($_SERVER['REMOTE_ADDR']);
    }

    public function get_country()
    {
        return $this->country;
    }

    public function set_ip()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function get_ip()
    {
        return $this->ip;
    }

    public function set_nick($value)
    {
        $this->nick = $value;
    }

    public function get_nick()
    {
        return $this->nick;
    }

    public function set_hash($value)
    {
        $this->hash = $value;
    }

    public function get_hash()
    {
        return $this->hash;
    }

    public function set_useragent()
    {
        $this->useragent = $_SERVER['HTTP_USER_AGENT'];
    }

    public function get_useragent()
    {
        return $this->useragent;
    }

    public function set_referrer()
    {
        $this->referrer = $_SERVER['HTTP_REFERER'];
    }

    public function get_referrer()
    {
        return $this->referrer;
    }

    public function add_to_project_votes_set()
    {

    }

    public function is_user_can_vote()
    {

        $UserSocials = UserOAuth::model()->findAll('user_id=:user', array(
            ':user' => Yii::app()->user->id
        ));

        if (sizeof($UserSocials) == 0)
            return false;
        else
            return true;
    }

    public function is_user_have_voted_today($project_id)
    {
        $vote = $this->get_current_user_vote_in_project($project_id);
        if(sizeof($vote)>0)
            return 1;
        else
            return 0;
    }

    public function get_current_user_vote_in_project($project_id)
    {
        return $this->db->hGetAll('project:'.$project_id.':user_id:'.Yii::app()->user->id);
    }

    public function get_time_to_next_day()
    {
        $rd_one = new DateTime('now');
        $rd_two = new DateTime('tomorrow');
        return $rd_one->diff($rd_two);
    }

    public function register_in_queue(Projects $project)
    {
        if ($project->give_bonuses) {
            $nickname = trim(CHtml::encode($_POST['nickname']));
            if (isset($nickname)) {
                $mq = new MQClient();
                $token = md5($nickname.$project->secret_key);
                $mq->sendMessage("{$project->script_url}|$nickname|{$token}|" . $_SERVER['REMOTE_ADDR']);
            }
        }
    }

}