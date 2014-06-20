<?php

	class Api
	
	{
		
		public function __construct()
		{
			//echo 'API initialized';
		}
		
		public function getProject($id)
		{
			echo 'getting project '.$id;
		}
		
		public function switchHandle()
		{
			$action = $_GET['action'];
			$entity = leo::getRegister()[Router::getModule()];
			
			if(method_exists($entity,$_GET['action']))
				$entity->$action();
			
		}
	
	}