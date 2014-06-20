<?php

class DefaultController extends Controller
{
    public function actionMessageQueue()
    {
        $limit = 360;
        $time = time();
        $last_id = (int)$_GET['id'];
        set_time_limit($limit + 5);

        function escape($str)
        {
            return str_replace('"', '\"', $str);
        }


    }
}