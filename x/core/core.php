<?php
	
	class Core {

		public $db;
		public $router;
		public $user;
		public $user_session;

		function __construct()
		{
            require_once('settings.php');

            $this->db = new PDO('mysql:host='.$settings->db['mysql']['server_address'].';dbname='.$settings->db['mysql']['database_name'], $settings->db['mysql']['user_name'], $settings->db['mysql']['password'], array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')) or die('');


			$this->handleQuery();
		}

		function handleQuery()
		{
			if(!isset($_GET['module']))
				die('Not correct request');
			else
			{
				$module = $_GET['module'];
				require_once('modules_dictionary.php');	
				$dictionary = new modules_dictionary();
				if($dictionary->in_dictionary($module))
					{
                        if(DEBUG)
    						echo '<b>XCoreQueryHanlder:</b> initializng of '.$module. ' module<br>';

                        require_once('modules/'.$module.'/index.php');
					}
				else
					throw new Exception('test');
			}

		}

	}