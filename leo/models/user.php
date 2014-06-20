<?php

class User
{

	 public $id;
	 public $login;
	 public $email;
	 public $registered;
	 public $language;
	 public $pwd;
	 public $can_change_login;
	 public $show_all_projects;
	 
	 public function __construct($mode = null)
	 {
		if($mode == 'generateNewForRegistration')
			$this->generateNewForRegistration();
	 }
	 
	 public function generateNewForRegistration()
	 {
		$username = $_GET['username'];			
		$password = $_GET['password'];
		$query = "SELECT * from rtt_servers where username='$username' and password='".md5($password)."'";
		$STH = Leo::getDb()->getConnection()->query($query);  
		$STH->setFetchMode(PDO::FETCH_ASSOC);  
		
		$variables = get_class_vars(__CLASS__);
		
		while($row = $STH->fetch()) { 
			foreach($row as $key=>$value)
				if(array_key_exists($key, $variables))
					$this->$key = $value;
			$this->login = $row['username'];
			$this->registered = $row['join_date'];
			$this->pwd = $row['password'];
			$this->language = 'ru';
			$this->can_change_login = true;
			$this->show_all_projects = true;
		}
				
		return $this;
	 }

}
