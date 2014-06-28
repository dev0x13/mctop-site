<?php
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'MCTop.im - Minecraft International Portal',
    'language' => 'ru',
    'defaultController' => 'Rating',

    'preload' => array('log'),

    'import' => array(
        'application.models.*',
        'application.models.forms.*',
        'application.models.Redis.*',
        'application.components.*',
        'application.helpers.*',
        'application.views.widgets.*',
        'ext.YiiRedis.*',
        'ext.hoauth.models.*',
    ),

    'modules' => array(
        'social',
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1',
            'ipFilters' => array('93.92.202.81', '127.0.0.1', '::1'),
        ),

    ),

    'components' => array(

        'user' => array(
            'allowAutoLogin' => true,
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => true,
            'rules' => array(
                'u<id:\d>'=>'users/profile',
                'auth_admin'=>'site/auth_admin',     
                's/<action:\w+>' => 'site/<action>',
                's/restorepassword/<hash:\w+>' => 'site/restorepassword',

                'wiki' => 'mdb',
                'wiki/<action:\w+>' => 'mdb/<action>',
                'wiki/mods/list' => 'mdb/type/mods',
                'wiki/mods/<id:\d+>' => 'mdb/mod',
                'cabinet/manual/group/<id:\d+>' => 'cabinet/ManualGroup',
                'wiki/plugins/list' => 'mdb/type/plugins',
                'wiki/plugins/<id:\d+>' => 'mdb/plugin',
                'cabinet/projects' => 'projects',
                'oauth/provider/<provider:.*?>' => 'site/oauth',
                'images/addtogallery/<id:\d+>/forserver.<server:\d+>' => 'images/addtogallery',
                'images/useasbanner/<id:\d+>/forproject.<project:\d+>' => 'images/useasbanner',
                'rating/server/<id:\d+>/gallery' => 'rating/servergallery',
                'rating/server/<id:\d+>/favoriteit' => 'rating/favoriteit',
                'rating/server/<id:\d+>/unfavoriteit' => 'rating/unfavoriteit',
                'news/tag/<tag:.*?>' => 'news/withtag',
                'advert/create/<type:\w+>' => 'advert/create',
                'advert/create/<type:\w+>/<id:\w+>' => 'advert/create',
                'projects/guild/leave/<id:\w+>' => 'guilds/leave',
                'projects/guild/join/<id:\w+>' => 'guilds/join',
                'projects/guild/create/<id:\w+>' => 'projects/CreateGuild',
                'projects/guild/edit/<id:\w+>' => 'projects/EditGuild',
                'projects/guild/<id:\w+>' => 'guilds/show',
                'projects/guild/<id:\w+>/<action:\w+>' => 'guilds/<action>',
                'projects/guild/<id:\w+>/news/<action:\w+>/' => 'guilds/News<action>',
                'projects/guild/<pid:\w+>/news/<action:\w+>/<id:\w+>' => 'guilds/News<action>',
                'projects/guild/<pid:\w+>/news_with_tag/<tag:.*?>' => 'guilds/NewsWithTag',
                'guilds/<pid:\w+>/news&post=<id:\w+>' => 'guilds/post',
                'guilds/leave/<id:\w+>' => 'guilds/leave',
                'guilds/join/<id:\w+>' => 'guilds/join',
                'guilds/create/<id:\w+>' => 'projects/CreateGuild',
                'guilds/edit/<id:\w+>' => 'projects/EditGuild',
                'guilds/<id:\w+>' => 'guilds/show',
                'guilds/<id:\w+>/<action:\w+>' => 'guilds/<action>',
                'guilds/<id:\w+>/news/<action:\w+>/' => 'guilds/News<action>',
                'guilds/<pid:\w+>/news/<action:\w+>/<id:\w+>' => 'guilds/News<action>',
                'guilds/<pid:\w+>/news_with_tag/<tag:.*?>' => 'guilds/NewsWithTag',
                'guilds/<pid:\w+>/news&post=<id:\w+>' => 'guilds/post',
                'site/restorepassword/<hash:.*?>' => 'site/restorepassword',
                'lang/<language:.*?>' => 'site/lang',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                'cabinet/projects/<action:\w+>' => 'projects/<action>',
                'cabinet/projects/<action:\w+>/<id:\w+>' => 'projects/<action>',

            ),
        ),

        'db' => array(
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'connectionString' => 'mysql:host=127.0.0.1;dbname=admin_top',
            'username' => 'mctop_user',
            'password' => '9J4P:Es72Y',
            'enableProfiling' => true,
        ),

        'mctopv2' => array(
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'connectionString' => 'mysql:host=127.0.0.1;dbname=admin_top',
            'username' => 'mctop_user',
            'password' => '9J4P:Es72Y',
            'enableProfiling' => true,
        ),

        'redis' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 10,
            "prefix" => ""
        ),

        'servers' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 1,
            "prefix" => ""
        ),

        'adverts' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 2,
            "prefix" => ""
        ),

        'projects' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 3,
            "prefix" => ""
        ),

        'votes' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 4,
            "prefix" => ""
        ),

        'svl' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 5,
            "prefix" => ""
        ),

        'slon' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 6,
            "prefix" => ""
        ),

        'bank' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 7,
            "prefix" => ""
        ),

        'social_network' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 8,
            "prefix" => ""
        ),

        'rating' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 9,
            "prefix" => ""
        ),

        'SxGeo' => array(
            'class' => 'application.components.SxGeo.SxGeo'
        ),

        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array('93.92.202.81'),
                ),
            ),
        ),
        'clientScript' => array(
            'scriptMap' => array(),
        ),
    ),

    'params' => array(
        'site_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/',
        'admin_site_url' => 'http://office.mctop.im/',
        'images' => array(
            'maxBannerWeight' => 1024 * 150
        )
    ),
);
