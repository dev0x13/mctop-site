<?php

class MQClient
{
    private $connection;
    private $channel;
    private $exchange;

    public function __construct()
    {
        $this->connection = new AMQPConnection();
        $this->connection->connect();
        if (!$this->connection->isConnected())
            die('Connection error :(');
        $this->channel = new AMQPChannel($this->connection);
        $this->exchange = new AMQPExchange($this->channel);
        $this->exchange->setName('immediate');
        $this->exchange->setType(AMQP_EX_TYPE_DIRECT);
    }

    public function sendMessage($command)
    {
        $message = $this->exchange->publish($command, '');
        if (!$message)
            die('Message sending error :(');
    }
}

?>
