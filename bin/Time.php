<?php

class Time {

    private static $_instance = null;

    private function __construct() {
        // приватный конструктор ограничивает реализацию getInstance ()
    }

    protected function __clone() {
        // ограничивает клонирование объекта
    }

    static public function getInstance() {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function now()
    {
        return date('Y-m-d H:i:s', time());
    }

}