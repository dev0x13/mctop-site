<?php

class RedisProjects extends _RedisHashAR
{
    protected $_values_to_save = '';
    private $set_of_servers_ids;
    private $set_of_votes_ids;
    private $set_of_slon_reports;

    //todo: Сброс раз в месяц
    private $array_servers_id;
    private $countries_voters;
    private $countries_hosts;
    private $countries_viewers;
    private $countries_new_users_for_month;

    public function __construct($args_array = null)
    {
        $this->key_preffix = 'project:';
        $this->db = Yii::app()->projects->getClient();
        if(is_not_null($args_array))
        {

            if(isset($args_array['set_of_servers_id']))
                $this->set_of_servers_ids = $args_array['set_of_servers_id'];

            if(isset($args_array['id']))
            {
                $this->id = $args_array['id'];
                $this->key = $this->key_preffix.$this->id;

                if(isset($args_array['set_of_servers_id']))
                    throw new CHttpException(502, 'Список значений серверов уже был задан в массиве аргументов. Возможна перезапись');
                else
                    $this->set_of_servers_ids = $this->db->sMembers($this->key.':servers_ids');

            }

        }
    }

    public function get($id)
    {
        return new RedisProjects(array(
            'id'=>$id
        ));
    }

    public function save()
    {
        if(isset($this->set_of_servers_ids))
            foreach($this->set_of_servers_ids as $key => $server_id)
            {
                if(!$this->db->sIsMember($this->get_key().':servers_ids', $server_id))
                    $this->db->sAdd($this->get_key().':servers_ids', $server_id);
            }
        return 1;//todo не всегда может быть единица.
    }

    public function delete()
    {
        if(isset($this->set_of_servers_ids))
            foreach($this->set_of_servers_ids as $key => $server_id)
            {
                if($this->db->sIsMember($this->get_key().':servers_ids', $server_id))
                    $this->db->sRem($this->get_key().':servers_ids', $server_id);
            }
    }

    public function set_score($score)
    {
        return $this->db->set('project:'.$this->id.':score',$score);
    }

    public function get_score(){
        return $this->db->get('project:'.$this->id.':score');
    }

    public function get_servers_ids()
    {
        return $this->set_of_servers_ids;
    }

    public function get_votes_ids()
    {
        return $this->set_of_votes_ids;
    }

    public function get_slon_reports_ids()
    {
        return $this->set_of_slon_reports;
    }

    public function set_servers_ids($list)
    {

    }

    public function set_votes_ids($list)
    {

    }

    public function set_slon_reports_ids($list)
    {

    }

    public function delete_server_from_set($id)
    {

    }

    public function increment_countries_voters($country)
    {
        $user_country = Yii::app()->SxGeo->getCountry($_SERVER['REMOTE_ADDR']);
        $stats = $this->db->get('project:'.$this->id.':countries:voters:'.$user_country);
        if(!$stats)
            $this->db->set('project:'.$this->id.':countries:voters:'.$user_country,1);
        else
            $this->db->set('project:'.$this->id.':countries:voters:'.$user_country,$stats+1);
    }

    public function increment_countries_hosts($country)
    {
        $user_country = Yii::app()->SxGeo->getCountry($_SERVER['REMOTE_ADDR']);
        $stats = $this->db->get('project:'.$this->id.':countries:hosts:'.$user_country);
        if(!$stats)
            $this->db->set('project:'.$this->id.':countries:hosts:'.$user_country,1);
        else
            $this->db->set('project:'.$this->id.':countries:hosts:'.$user_country,$stats+1);
    }

    public function increment_countries_viewers($country = null)
    {
        $user_country = Yii::app()->SxGeo->getCountry($_SERVER['REMOTE_ADDR']);
        $stats = $this->db->get('project:'.$this->id.':countries:viewers:'.$user_country);
        if(!$stats)
            $this->db->set('project:'.$this->id.':countries:viewers:'.$user_country,1);
        else
            $this->db->set('project:'.$this->id.':countries:viewers:'.$user_country,$stats+1);
    }

    public function increment_votes_month()
    {
        $stats = $this->db->get('project:'.$this->id.':votes:count:month');
        if(!$stats)
            $this->db->set('project:'.$this->id.':votes:count:month',1);
        else
            $this->db->set('project:'.$this->id.':votes:count:month',$stats+1);
    }

    public function increment_votes_all()
    {
        $stats = $this->db->get('project:'.$this->id.':votes:count:all');
        if(!$stats)
            $this->db->set('project:'.$this->id.':votes:count:all',1);
        else
            $this->db->set('project:'.$this->id.':votes:count:all',$stats+1);
    }

    public function increment_votes_today()
    {
        //todo Сброс раз в день
        $stats = $this->db->get('project:'.$this->id.':votes:count:today');
        if(!$stats)
            $this->db->set('project:'.$this->id.':votes:count:today',1);
        else
            $this->db->set('project:'.$this->id.':votes:count:today',$stats+1);
    }

    public function add_user_to_new_users_for_month($user_id)
    {

    }

    public function get_count_of_project_votes_for_month()
    {

        $stats = $this->db->get('project:'.$this->id.':votes:count:month');

        if(!$stats)
            return 0;
        else
            return $this->db->get('project:'.$this->id.':votes:count:month');
    }

    public function get_count_of_project_votes_today()
    {

        $stats = $this->db->get('project:'.$this->id.':votes:count:today');

        if(!$stats)
            return 0;
        else
            return $this->db->get('project:'.$this->id.':votes:count:today');
    }

    public function get_count_of_project_votes_all()
    {

        $stats = $this->db->get('project:'.$this->id.':votes:count:all');

        if(!$stats)
            return 0;
        else
            return $this->db->get('project:'.$this->id.':votes:count:all');
    }



}