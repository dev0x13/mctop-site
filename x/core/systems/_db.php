<?php

    class _db
    {
        static $instance;

        static function instance()
        {
            // under construction
            echo 'db is here';
        }

        static function abort($sth)
        {
            if(DEBUG)
                die(print_r('<b>XdbSystem</b>: '.$sth->errorInfo()[2].'<br>'));
        }
    }
