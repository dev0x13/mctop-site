<?php

class ProjectRedis extends RedisActiveRecord
{

    public $id;
    public $stats;
    public $lastusers;
    protected $className = __CLASS__;

    public function __construct($isNewRecord = null)
    {
        if ($isNewRecord)
            $this->stats = new ProjectStats();
    }

    public function fillData($array)
    {
        foreach ($array as $key => $value)
            $this->$key = $value;
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function save()
    {
        $redis = Yii::app()->redis->getClient();
        $data = [];

        foreach (get_class_vars('ProjectRedis') as $key => $value)
            if ($key <> 'className' && $key <> 'db' && $key <> '_attributes' && $key <> 'preffix' && $key <> 'stats' && $key <> 'lastusers')
                $data[$key] = $this->$key;

        return ($redis->hmset("project:" . $this->id, $data));
    }

    public function findByPk($pk)
    {
        $redis = Yii::app()->redis->getClient();
        $this->id = (int)$pk;
        $this->stats = ProjectStats::model()->getProjectStats($pk);
        $this->stats->project = (int)$pk;
        return $this;
    }

    public function delete()
    {
        $redis = Yii::app()->redis->getClient();
        $redis->del('project:' . $this->id) == true ? true : false;
        return 1;
    }

}

class ProjectStats extends RedisActiveRecord
{
    public $project;
    public $votes_month;
    public $votes_all_period;
    public $votes_today;
    public $score;
    public $avg_online;
    public $avg_online_day;
    public $avg_online_week;
    public $avg_online_month;
    public $players_count;
    public $voters_countries;
    public $page_views_day;
    public $page_views_month;
    public $unique_hosts_day;
    public $unique_hosts_month;
    protected $className = __CLASS__;

    public function save()
    {
        $redis = Yii::app()->redis->getClient();
        $data = [];
        foreach (get_class_vars('ProjectStats') as $key => $value) {
            if ($key == 'voters_countries') {
                if (gettype($this->$key) == 'object')
                    $this->$key = (array)$this->$key;
                $data[$key] = json_encode($this->$key);
            }

            if ($key == 'page_views_month') {
                if (gettype($this->$key) == 'object')
                    $this->$key = (array)$this->$key;
                $data[$key] = json_encode($this->$key);
            }

            if ($key == 'unique_hosts_month') {
                if (gettype($this->$key) == 'object')
                    $this->$key = (array)$this->$key;

                $data[$key] = json_encode($this->$key);
            }

            if ($key <> 'unique_hosts_month' && $key <> 'voters_countries' && $key <> 'page_views_month' && $key <> 'className' && $key <> 'db' && $key <> '_attributes' && $key <> 'preffix')
                $data[$key] = $this->$key;
        }

        return ($redis->hmset("project:stats:" . $this->project, $data));
    }

    public function isVotersCountriesExists()
    {
        if ($this->voters_countries == 0)
            return false;
        else
            return true;
    }

    public function getProjectStats($pk)
    {
        $stats = new ProjectStats();
        $stats_hash = Yii::app()->redis->getClient()->hgetall('project:stats:' . $pk);
        if (is_null($stats_hash))
            $stats_hash = [];

        foreach (get_class_vars('ProjectStats') as $key => $value) {
            if (array_key_exists($key, $stats_hash))
                switch ($key) {
                    default:
                        $stats_hash[$key] == null ? $stats->$key = 0 : $stats->$key = $stats_hash[$key];
                        break;
                    case 'voters_countries':
                        if (!array_key_exists('voters_countries', $stats_hash))
                            $stats->voters_countries = 0;
                        else
                            $stats->voters_countries = json_decode($stats_hash['voters_countries']);
                        break;
                    case 'page_views_month':
                        $stats->page_views_month = json_decode($stats_hash[$key]);
                        break;
                    case 'unique_hosts_month':
                        $stats->unique_hosts_month = json_decode($stats_hash[$key]);
                        break;
                }
        }

        $stats->project = (int)$pk;
        return $stats;
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function incrementViewsMonth()
    {
        $user_country = Yii::app()->SxGeo->getCountry($_SERVER['REMOTE_ADDR'] = '85.113.195.213');
        $today_is = date('d', time());

        if ($this->page_views_month == 'null' or $this->page_views_month == '' or !isset($this->page_views_month->$today_is->$user_country)) {
            $views = [];
            $views[$today_is][$user_country] = 0;
        } else
            $views = $this->page_views_month;

        if (gettype($views) == 'array')
            $views[$today_is][$user_country]++;
        else
            $this->page_views_month->$today_is->$user_country++;


        if (!isset($this->page_views_month->$today_is->$user_country)) {
            if (!is_null($this->page_views_month)) {
                if (isset($this->page_views_month->$today_is))
                    $this->page_views_month->$today_is->$user_country++;
                else {
                    if (!is_object($this->page_views_month)) {
                        if ($this->page_views_month == 0) {
                            $this->page_views_month = array();
                            $this->page_views_month[$today_is] = array($user_country => 1);

                        } else
                            $this->page_views_month->$today_is = array($user_country => 1);
                    }
                }
            } else
                $this->page_views_month = $views;
        }

        if (!$this->save())
            die('Error on saving');
    }

    public function incrementHostsMonth()
    {
        $user_country = Yii::app()->SxGeo->getCountry($_SERVER['REMOTE_ADDR']);
        $today_is = date('d', time());

        if ($this->unique_hosts_month == 'null' or $this->unique_hosts_month == '' or !isset($this->unique_hosts_month->$today_is->$user_country)) {
            $hosts[$today_is][$user_country] = 0;
        } else
            $hosts = $this->unique_hosts_month;

        if (gettype($hosts) == 'array')
            $hosts[$today_is][$user_country]++;
        else
            $this->unique_hosts_month->$today_is->$user_country++;

        if (!isset($this->unique_hosts_month->$today_is->$user_country) and gettype($hosts) != 'array')
            $this->unique_hosts_month->$today_is->$user_country++;

        if (gettype($this->unique_hosts_month) == 'int')
            $this->unique_hosts_month = $hosts;
        else {
            if (gettype($hosts) == 'array') {
                if (!is_null($this->unique_hosts_month)) {
                    if (isset($this->unique_hosts_month->$today_is))
                        $this->unique_hosts_month->$today_is->$user_country++;
                    //$this->unique_hosts_month->$today_is->$user_country = $hosts[$today_is][$user_country];
                    else {

                        if (!is_object($this->unique_hosts_month)) {
                            if ($this->unique_hosts_month == 0) {
                                $this->unique_hosts_month = array();
                                $this->unique_hosts_month[$today_is] = array($user_country => 1);
                            } else {
                                $this->unique_hosts_month->$today_is->$user_country = $hosts[$today_is][$user_country];
                            }
                        }

                    }
                } else
                    $this->unique_hosts_month = $hosts;
            } else
                $this->unique_hosts_month->$today_is->$user_country = $hosts->$today_is->$user_country;
        }

        if (!$this->save())
            die('Error on saving');

    }
}

class ProjectLastUsers extends RedisActiveRecord
{
    protected $className = __CLASS__;

    public function __construct($last_users_hash)
    {
        foreach (get_class_vars('ProjectLastUsers') as $key => $value)
            $last_users_hash[$key] == null ? $this->$key = 0 : $this->$key = $last_users_hash[$key];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
