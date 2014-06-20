<?php

class ServersRedis extends RedisActiveRecord
{

    public $id;
    public $address;

    public $players_online;
    public $slots;

    public $status;
    public $ping;

    public $success;
    public $attempts;

    public $active;

    private $_value;

    public $report;
    protected $className = __CLASS__;
    protected $preffix = 'server_';

    public function fillData($array)
    {
        foreach ($array as $key => $value)
            $this->$key = $value;
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function setValue($value)
    {
        $data = explode('|', $value);
        $i = 0;
        foreach (get_class_vars($this->className) as $key => $value) {

            if ($key <> 'className' && $key <> 'db' && $key <> '_attributes' && $key <> 'report' && $key <> 'preffix' && $key <> '_value') {
                $this->$key = $data[$i];
                $i++;
            }

        }

        $this->_value = $value;
    }

    public function delete()
    {
        return Yii::app()->servers_bd->getClient()->del($this->id);
    }

    public function save()
    {
        $string = '';

        foreach (get_class_vars($this->className) as $key => $value) {
            $id = 'server_' . $this->id;
            if ($key <> 'className' && $key <> 'db' && $key <> '_attributes' && $key <> 'report' && $key <> 'preffix' && $key <> '_value') {
                $string .= $this->$key . '|';
            }
        }

        $string = substr($string, 0, strlen($string) - 1);
        return Yii::app()->servers_bd->getClient()->set($id, $string);
    }

    public function getValue()
    {
        return $this->_value;
    }

    public function findByPk($pk)
    {
        $string = Yii::app()->servers_bd->getClient()->get($this->preffix . $pk);
        $data = explode('|', $string);
        $i = 0;
        foreach (get_class_vars($this->className) as $key => $value) {

            if ($key <> 'className' && $key <> 'db' && $key <> '_attributes' && $key <> 'report' && $key <> 'preffix' && $key <> '_value') {
                $this->$key = $data[$i];
                $i++;
            }

        }
        return $this;
    }
}
