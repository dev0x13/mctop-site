<?php

class HApi
{

    public static function getServer($server_id)
    {

        //todo Кешировать ответ.

        if (!is_null($server = Servers::model()->findByPk($server_id))) {

            $server_redis = RedisServers::model()->get($server_id);

            if(isset($server_redis))
            {

                $server->online = $server_redis->get_players_online();
                $server->slots = $server_redis->get_slots();

                    if($server_redis->get_queries_count_success() != 0)
                        $server->average_online_month = $server_redis->get_players_month()/$server_redis->get_queries_count_success();
                    else
                        $server->average_online_month = 'Counting...';

                $server->avg_online = round($server->average_online_month,0);
                $server->queries_count = $server_redis->get_queries_count();
                $server->queries_count_success = $server_redis->get_queries_count_success();
                $server->save();
            }
            else
            {
                $server->online = 'Updating...';
                $server->slots = 'Updating...';
                $server->average_online_month = 'Updating...';
            }

            $server->version = ServersVersions::model()->findByPk($server->version)->version;

            $types = '';
            foreach (HUtils::Parse($server->type) as $type)
                $types .= (Yii::t('translations', ServersTypes::model()->findByPk($type)->type)) . ', ';
            $types = substr($types, 0, strlen($types) - 2);
            $server->type = $types;

            $mods = '';
            if (strlen($server->mods) > 0) {
                foreach (HUtils::Parse($server->mods) as $mod)
                    $mods .= ServersMods::model()->findByPk($mod)->title . ', ';
                $mods = substr($mods, 0, strlen($mods) - 2);
                $server->mods = $mods;
            }

            $array_to_return = $server->attributes;
            $array_to_return['online'] = $server->online;
            $array_to_return['slots'] = $server->slots;
            $array_to_return['average_online_month'] = round($server->average_online_month,0);
            $array_to_return['uptime'] = 100*round(($server->queries_count_success/$server->queries_count),4);

            echo HUtils::json_encode_cyr($array_to_return);
        } else
            echo json_encode(array('answer' => 'null'));
    }

}