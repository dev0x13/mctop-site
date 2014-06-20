<?php

	class Db {
		
		private $connection;
					
		public function __construct()
		{
				
			try {  
				$CONF['host'] = 'localhost';
				$CONF['database'] = 'mctopv2';
				$CONF['username'] = 'mctop_user';
				$CONF['password'] = '9J4P:Es72Y';
				$CONF['prefix'] = 'rtt';
				$this->connection = new PDO('mysql:host='.$CONF['host'].';dbname='.$CONF['database'].'', $CONF['username'], $CONF['password']);
				$this->connection->query("SET NAMES utf8");  				
			}  
			catch(PDOException $e) {  
				echo $e->getMessage();  
			}
		}
		
		public function getConnection()
		{
			return $this->connection;
		}
		
	}