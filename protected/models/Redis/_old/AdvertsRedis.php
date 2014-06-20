<?php

class AdvertsRedis extends RedisActiveRecord
{

    public $views;
    public $clicks;
    public $ordered;
    public $balance;
    public $image;
    public $site;
    protected $className = __CLASS__;
    protected $preffix = 'advert_';

    public function fillAdvertInfo($info)
    {
        foreach ($info as $key => $value) {
            $this->$key = $value;
        }
    }

    public function registerAdvertAdditionalInfo($data)
    {

        $this->views = new ARedisCounter($this->preffix . $data['id'] . '_views');
        $this->clicks = new ARedisCounter($this->preffix . $data['id'] . '_clicks');

        $this->views = $this->views->getValue();
        $this->clicks = $this->clicks->getValue();

        foreach ($data as $key => $value)
            $this->$key = $value;
    }


    public function fillData($array)
    {
        foreach ($array as $key => $value)
            $this->$key = $value;
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function IncrementViews($id)
    {
        $views = new ARedisCounter($this->preffix . $id . '_views');
        $views->increment();
    }

    public function IncrementClicks($id)
    {
        $clicks = new ARedisCounter($this->preffix . $id . '_clicks');
        $clicks->increment();
    }


    public function subtractBalanceOnView($id, $pay_type, $position)
    {
        $record = AdvertsRedis::model()->findByPk($id);

        switch ($pay_type) {
            case Adverts::PAY_TYPE_VIEWS:
                $position == Adverts::POSITION_HEAD ? $count = $record->balance / 25 * 1000 : $count = $record->balance / 15 * 1000;
                break;
        }

        $count--;

        switch ($pay_type) {
            case Adverts::PAY_TYPE_VIEWS:
                $position == Adverts::POSITION_HEAD ? $balance = $count * 25 / 1000 : $balance = $count * 15 / 1000;
                break;
        }

        $record->balance = $balance;
        $record->save($id);
    }

    public function subtractBalanceOnClick($id, $pay_type, $position)
    {
        $record = AdvertsRedis::model()->findByPk($id);

        switch ($pay_type) {
            case Adverts::PAY_TYPE_CLICKS:
                $position == Adverts::POSITION_HEAD ? $count = $record->balance / 5 : $count = $record->balance / 1;
                break;
        }

        $count--;

        switch ($pay_type) {
            case Adverts::PAY_TYPE_CLICKS:
                $position == Adverts::POSITION_HEAD ? $balance = $count * 5 : $balance = $count * 1;
                break;
        }

        $record->balance = $balance;
        $record->save($id);
    }


    public function DecrementBalance($id)
    {
        $balance = new ARedisCounter($this->preffix . $id . '_balance');
        $balance->decrement();
        if ($balance->getValue() == 0) {
            $advert = Adverts::model()->findByPk($id);
            $advert->active = Adverts::ADVERT_BALANCE_EXHAUSTED;
            $advert->save();
        }
    }


}