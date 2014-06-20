<?php

class HTor
{
    private $redis;

    public function __construct()
    {
        $this->redis = Yii::app()->redis->getClient();
    }

    public function getTorList()
    {
        $ch = curl_init();
        $url = "http://top.dev/tor.txt";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');
        $result = curl_exec($ch);
        curl_close($ch);
        preg_match_all("/\b\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\b/", $result, $tor_ips);
        $this->redis->del('tor_servers');
        foreach ($tor_ips[0] as $key => $serv)
            $this->redis->sadd('tor_servers', $serv);
    }

    public function isTorServer($ip)
    {
        return $this->redis->sismember('tor_servers', $ip);
    }

}
