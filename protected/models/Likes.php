<?php

class Likes extends RedisActiveRecord
{
    public static function getUserWallRecordLikesCount($id)
    {
        $redis = Yii::app()->redis->getClient();

        $record = Yii::app()->redis->getClient()->get('likes:user:wall:post:1');

        if (is_null($record)) {
            Yii::app()->redis->getClient()->set('likes:user:wall:post:1', 1);
        }

        return Yii::app()->redis->getClient()->get('likes:user:wall:post:1');


    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}