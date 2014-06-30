<?php

    class Server extends _db
    {

        function __construct($db)
        {
            $this->db = $db;
        }

        function get_server($id)
        {
            if(DEBUG)
                echo 'Getting server with id:'.$id.'<br>';

            $sth = $this->db->prepare('select * from servers where id = '.$id);
            $sth->execute()
            or
            self::abort($sth);

            $result = $sth->fetch(PDO::FETCH_ASSOC);

            return $result;
        }

    }