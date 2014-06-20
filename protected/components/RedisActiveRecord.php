<?php

class RedisActiveRecord extends CActiveRecord
{

    public $_attributes = array();
    protected $className;
    protected $preffix;

    public function __construct()
    {
    }

    public function setAttribute()
    {
    }

    public function save($id)
    {

        $fieldCount = 0;
        $fieldSaved = 0;

        foreach (get_class_vars($this->className) as $key => $value)
            if ($key <> 'className' && $key <> 'db' && $key <> '_attributes')
                $fieldCount++;

        foreach (get_class_vars($this->className) as $key => $value)
            if ($key <> 'className' && $key <> 'db' && $key <> '_attributes') {
                Yii::app()->redis->getClient()->set($this->preffix . $id . '_' . $key, $this->$key);
                $fieldSaved++;
            }

        return $fieldCount == $fieldSaved ? 1 : 0;
    }

    public function findByPk($pk, $preffix = null)
    {
        $object = new $this->className;

        foreach (get_class_vars($this->className) as $key => $value)
            if ($key <> 'className' && $key <> 'db' && $key <> '_attributes' && $key <> 'preffix')
                $object->$key = Yii::app()->redis->getClient()->get($this->preffix . $pk . '_' . $key);

        return $object;
    }

    public function getPrimaryKey()
    {

    }

    public function getMetaData()
    {

    }

    public function getAttributes()
    {

    }

    public function getModelValuesInArray()
    {
        $values = array();
        foreach (get_class_vars($this->className) as $key => $value)
            if ($key <> 'className' && $key <> 'db' && $key <> '_attributes' && $key <> 'preffix' && $key <> 'object')
                $values[$key] = $this->$key;
        return $values;
    }

}