<?php

	class modules_dictionary 
	{
		function __construct()
		{
			$this->modules = array(
				'news' => 'Новостной модуль',	
			);
		}

		function in_dictionary($name)
		{
			if(isset($this->modules[$name]))
				return 1;
			else
				return 0;
		}
	}