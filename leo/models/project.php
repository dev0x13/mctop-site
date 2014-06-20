<?php

	class Project {
		
		public $id;
		public $title;
		public $description;
		public $url;
		public $register_date;
		
		public function get($id)
		{
		
			require('server.php');
			$CONF['host'] = 'localhost';
			$CONF['database'] = 'mctop_maindb';
			$CONF['username'] = 'mctop_mainu';
			$CONF['password'] = 'DiLJ18Bchg';
			$CONF['prefix'] = 'rtt';
			$conn = mysql_connect($CONF['host'],$CONF['username'],$CONF['password']);
			mysql_select_db($CONF['database']);
			
			$query = 'SELECT * from rtt_servers where id = '.$id;
			$result = mysql_fetch_assoc(mysql_query($query));
			foreach(get_class_vars(__CLASS__) as $key => $value)
				$this->$key = $result[$key];

			$this->getAllProjectServers($result['id']);


			unset($result['description']);
			unset($result['det_description']);
			unset($result['status_er']);
			unset($result['vip']);
			echo $this->json_encode_cyr($this);
		}
		
		
		public function getAllProjectServers($pid)
		{
			$all_project_servers = "SELECT * from rtt_servers_real where uid = '".$pid."'";
			mysql_query("SET NAMES utf8");
			$result = mysql_query($all_project_servers);
			while ($row = mysql_fetch_assoc($result)) {
				$server = new Server();

				foreach($server as $key => $value)
					$server->$key = $this->json_encode_cyr($row[$key]);
					
				$server->address = $row['ip'];
				if($row['port'] != 25565)
					$server->address .= $row['port'];
					
				$server->type = $row['server_type']; //todo скорелировать типы с MCTop.Leo
				$this->servers[] = $server;
				//echo '<hr>';
			}
			
		}
		
		function json_encode_cyr($str) {
			$arr_replace_utf = array('\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
			'\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
			'\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
			'\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
			'\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
			'\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
			'\u0448','\u0429','\u0449','\u042a','\u044a','\u042b','\u044b','\u042c','\u044c',
			'\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');
			
			$arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
			'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
			'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
			'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');
			
			$str1 = json_encode($str);
			$str2 = str_replace($arr_replace_utf,$arr_replace_cyr,$str1);
			return $str2;
		}
		
		public function findProjectByUsernameAndPassword()
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
				$this->register_date = $row['join_date'];
			}

			return $this;
		}
		
		public function registerWithPassword()
		{
			require('server.php');
			require('user.php');
			$project = $this->findProjectByUsernameAndPassword();
			
			$servers = $this->getProjectServers($project->id);
			
			$user = new User('generateNewForRegistration');

			$exporting = [];
			$exporting['project'] = $project;
			$exporting['servers'] = $servers;
			$exporting['user'] = $user;
			
			echo $this->json_encode_cyr($exporting);
			
		}
		
		public function getProjectServers($project)
		{

			$query = "SELECT * from rtt_servers_real where uid=$project";
			$STH = Leo::getDb()->getConnection()->query($query);  
			
			if(is_null($STH))
				return array();
				die();
			$STH->setFetchMode(PDO::FETCH_ASSOC);  
			
			
			$variables = get_class_vars('Server');
			$servers = [];
			
			while($row = $STH->fetch()) { 
							
				$server = new Server();
				foreach($row as $key=>$value)
				{
					if(array_key_exists($key, $variables))
						$server->$key = $value;
				}
				
				$server->type = $row['server_type'];
				/*
					types:
						0 - unknown
						2| 1 - Industrial
						6| 2 - Creative
						1| 3 - Survival
				*/
				$server->address = $row['ip'];
				if($row['port']!=25565)
					$server->address .= ':'.$row['port'];
				
				$servers[] = $server;

			}
			
			return $servers;
		}
	}

?>