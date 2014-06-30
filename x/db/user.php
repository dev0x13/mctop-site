<?php

	class User extends _db {

		function __construct($db)
		{
			$this->db = $db;
		}

		function get_user($id)
		{
			if(DEBUG)
				echo 'Getting user with id:'.$id.'<br>';

			$sth = $this->db->prepare('select * from users where id = '.$id);
			$sth->execute()
            or
                self::abort($sth);

			$result = $sth->fetch(PDO::FETCH_ASSOC);

			return $result;
		}

	}