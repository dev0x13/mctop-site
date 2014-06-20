<?php

class _RedisHashAR
{

    /* @var $db php_redis */

    protected $db;
    protected $_values_to_save;

    protected $key_preffix;
    protected $key;

    protected $id;

    public static function model()
    {
        $class_name = get_called_class();
        return new $class_name();
    }

    public function save()
    {
        $this->beforeSave();
        $this->key = $this->get_key();

        foreach ($this->get_data_in_array() as $key => $value)
            $this->db->hset($this->get_key(), $key, $value);
    }

    public function beforeSave()
    {
        if(!isset($this->id))
            $this->id = $this->db->dbSize()+1;
    }

    public function get($id)
    {
        $this->id = $id;
        foreach($this->db->hGetAll($this->get_key()) as $key => $value)
        {
            $setter = 'set_' . $key;
            call_user_func(get_called_class() . '::' . $setter, $value);
        }

        return $this;
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

    protected function get_key()
    {
        return $this->key_preffix . $this->id;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function get_id()
    {
        return $this->id;
    }

}