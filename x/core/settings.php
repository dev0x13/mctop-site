<?php

    class Settings
    {

        public function __construct()
        {

            $settings = array(

                'databases' => array(

                    'db' => array(

                        'mysql' => array(
                            'type' => 'mysql',
                            'password' => '9J4P:Es72Y',
                            'database_name' => 'admin_top',
                            'user_name' => 'mctop_user',
                            'server_address' => 'localhost',
                        ),

                        'redis' => array(
                            'server_address' => 'localhost',
                            'using_password' => false,
                            'user_name' => 'root',
                            'redis_server_port' => 6379,
                            'databases' => array(
                                0 => array(
                                    'virtual_database_name' => 'hello_world_database',
                                ))
                        )

                    ),

                ),

                'modules' => array(
                    'new'
                )

            );

            $this->db = $settings['databases']['db'];

        }
    }

    $settings = new Settings();


