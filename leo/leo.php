<?php

	class Leo {
	
		private static $_API;
		private static $_ROUTER;
		private static $_REGISTER;
		private static $_DB;
		private static $_instance = null;
				
		private function __construct() {
			// приватный конструктор ограничивает реализацию getInstance ()
		}
		
		protected function __clone() {
			// ограничивает клонирование объекта
		}
		
		static public function getInstance() {
			require_once('db.php');
			require_once('router.php');
			if(is_null(self::$_instance))
			{
				self::$_instance = new self();
				self::$_REGISTER = array();
				self::$_DB = new Db();
				self::$_ROUTER = new Router();
				self::$_ROUTER->AutomaticHandle();
			}
	
			return self::$_instance;
		}
		
		public function registerModel($model)
		{
			self::$_REGISTER[get_class($model)] = $model;
		}
		
		public function getRegister()
		{
			return self::$_REGISTER;
		}
		
		public function getDb()
		{
			return self::$_DB;
		}
		
		public static function initApi()
		{
			require_once('api.php');
			self::$_API = new Api();
		}
		
		public static function getApi()
		{
			if(is_null(self::$_API))
			{
				self::initApi();
			}
			return self::$_API;
		}
		
		public static function End()
		{
			die();
		}

	}

