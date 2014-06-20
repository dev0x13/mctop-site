<?php
	
	class Router {
	
		private static $_MODULE;
	
		public function __construct()
		{
			if(!empty($_GET['module']))
				self::$_MODULE = ucfirst($_GET['module']);
			else
				die('Module has not recognized');
		}
		
		public function AutomaticHandle()
		{
			if(!isset($_GET['a']) or !isset($_GET['module']) or !isset($_GET['action']))
				die('What, sorry?');
				
			if(isset($_GET['a']))
			{
			
				if($_GET['a'] == 'api')
				{
				
				
					if(isset(self::$_MODULE))
					{
					
						if(file_exists('models/'.$_GET['module'].'.php'))
						{
							require_once('models/'.$_GET['module'].'.php');
							leo::getInstance()->registerModel(new self::$_MODULE());
							$api = leo::getApi();
							$api->switchHandle();
						}
						
						else
							echo 'what, sorry?';		
					}
				}
				

			}

		}
		
		public function getModule()
		{
			return self::$_MODULE;
		}
	
	}

