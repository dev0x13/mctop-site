<?php

    class RedisSVL extends _RedisHashAR
    {

        public $multivote;
        public $useragent;
        public $interval;
        public $avatar;
        public $day_overflow;
        public $auditory_overflow;

        protected $_values_to_save = 'multivote:useragent:interval:avatar:day_overflow:auditory_overflow';

        public function __construct()
        {
            $this->db = Yii::app()->svl->getClient();
        }

        public function save()
        {
            $this->beforeSave();

            foreach ($this->get_data_in_array() as $key => $value)
                $this->db->hset($this->key, $key, $value);
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

        public function beforeSave()
        {
            if(!isset($this->id))
                throw new CHttpException(502,'Не задан id голоса');

            $this->key = 'vote:'.$this->id.':flags';
        }

        public function get_multivote()
        {
            return $this->multivote;
        }

        public function get_useragent()
        {
            return $this->useragent;
        }

        public function get_interval()
        {
            return $this->interval;
        }

        public function get_avatar()
        {
            return $this->avatar;
        }

        public function get_day_overflow()
        {
            return $this->day_overflow;
        }

        public function get_auditory_overflow()
        {
            return $this->auditory_overflow;
        }

    }