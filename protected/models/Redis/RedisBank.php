<?php

    class RedisBank extends _RedisHashAR
    {

        public $entity_type;    # "user" | "project"
        public $entity_id;      # id of user or project
        public $description;
        public $money_amount;   # float
        public $invoice_type;   # "in" | "out"
        public $time;           # timestampt ("dd/mm/yy H:M:S")

        public function __construct()
        {
            $this->key_preffix = 'bank:transaction:';
            $this->bank = Yii::app()->bank->getClient();
        }

    }