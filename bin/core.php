<?php

class PNix
{
    public function __construct()
    {
        $this->init_yii_framework();
    }

    private function init_yii_framework()
    {
        require_once('Time.php');

        if($_SERVER['HTTP_X_REAL_IP']=='93.92.202.81')
        {
            defined('YII_DEBUG') or define('YII_DEBUG', true);
            defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
        }


        $yii = root . '/framework/yii.php';
        $config = root . '/protected/config/main.php';

        require_once($yii);
        Yii::createWebApplication($config)->run();
    }
}

function puts($argument)
{
    CVarDumper::dump($argument, 10, true);
}

function is_not_null($variable)
{
    return !is_null($variable)? true : false;
}

function abort($message)
{
    puts($message);
    die();
}

