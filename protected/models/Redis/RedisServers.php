<?php

class RedisServers extends _RedisHashAR
{

    private $project_id;
    private $ip;
    private $port;
    private $protocol_version;
    private $players_online;
    private $players_month; // sum of players for all queries
    private $queries_count;
    private $queries_count_success;
    private $last_query_time;

    protected $_values_to_save = 'project_id:ip:port:protocol_version';

    public function __construct()
    {
        $this->key_preffix = 'server:';
        $this->db = Yii::app()->servers->getClient();
    }

    public function set_project_id($project_id)
    {
        $this->project_id = $project_id;
    }

    public function set_ip($ip)
    {
        $this->ip = $ip;
    }

    public function set_port($port)
    {
        $this->port = $port;
    }

    public function set_protocol_version($protocol_version)
    {
        $this->protocol_version = $protocol_version;
    }

    public function get_project_id()
    {
        return $this->project_id;
    }

    public function get_ip()
    {
        return $this->ip;
    }

    public function get_port()
    {
        return $this->port;
    }

    public function get_protocol_version()
    {
        return $this->protocol_version;
    }

    public function get_players_online()
    {
        return $this->players_online;
    }

    public function set_players_online($value)
    {
        $this->players_online = $value;
    }

    public function set_slots($value)
    {
        $this->slots = $value;
    }

    public function get_slots()
    {
        return $this->slots;
    }

    public function set_players_month($value)
    {
        $this->players_month = $value;
    }

    public function get_players_month()
    {
        return $this->players_month;
    }

    public function set_queries_count($value)
    {
        $this->queries_count = $value;
    }

    public function get_queries_count()
    {
        return $this->queries_count;
    }

    public function set_queries_count_success($value)
    {
        $this->queries_count_success = $value;
    }

    public function get_queries_count_success()
    {
        return $this->queries_count_success;
    }

    public function set_last_query_time($value)
    {
        $this->last_query_time = $value;
    }

    public function get_last_query_time()
    {
        return $this->last_query_time;
    }

}