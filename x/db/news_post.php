<?php

    class News_post extends _db {

        function __construct($db)
        {
            $this->db = $db;
        }

        function get_news_post($id)
        {
            if(DEBUG)
                echo 'Getting news post with id:'.$id.'<br>';

            $sth = $this->db->prepare('select * from news where id = '.$id);
            $sth->execute()
            or
                self::abort($sth);

            $result = $sth->fetch(PDO::FETCH_ASSOC);

            return $result;
        }

    }