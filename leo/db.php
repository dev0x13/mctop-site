<?php

	class Db {
		
		private $connection;
					
		public function __construct()
		{
				
			try {  
				$CONF['host'] = 'localhost';
				$CONF['database'] = 'mctop_old';
				$CONF['username'] = 'mctop_importer';
				$CONF['password'] = 'EV3><o^haJ';
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
