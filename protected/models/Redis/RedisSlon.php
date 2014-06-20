<?php

    class RedisSlon extends _RedisHashAR
    {

        public $module;
        public $time;
        public $user;
        public $description;

        protected $_values_to_save = 'flags';

        public function __construct()
        {
            $this->db = Yii::app()->slon->getClient();
        }

        public function beforeSave()
        {

        }

        public function save()
        {

        }
    }