<?php

class RedisAdverts extends _RedisHashAR
{
    private $creator_id;
    private $balance;
    private $image;
    private $site;
    private $views;
    private $clicks;
    private $registered;

    private $set_of_users_viewers;

    protected $_values_to_save = 'creator_id:balance:image:site:views:clicks:registered';

    public function __construct()
    {
        $this->key_preffix = 'advert:';
        $this->db = Yii::app()->adverts->getClient();
    }

    public function set_creator_id($id)
    {
        $this->creator_id = $id;
    }

    public function get_creator_id()
    {
        return $this->creator_id;
    }

    public function set_balance($amount)
    {
        $this->balance = $amount;
    }

    public function get_balance()
    {
        return $this->balance;
    }

    public function set_image($value)
    {
        $this->image = $value;
    }

    public function get_site()
    {
        return $this->site;
    }


    public function set_site($value)
    {
        $this->site = $value;
    }

    public function get_image()
    {
        return $this->image;
    }

    public function set_views($amount)
    {
        $this->views = $amount;
    }

    public function get_views()
    {
        return $this->views;
    }

    public function set_clicks($amount)
    {
        $this->clicks = $amount;
    }

    public function get_clicks()
    {
        return $this->clicks;
    }

    public function set_registered($timestampt)
    {
        $this->registered = $timestampt;
    }

    public function get_registered()
    {
        return $this->registered;
    }

    public function get_ctr()
    {
        return round($this->get_views() != 0 ? $this->get_clicks() / $this->get_views() * 100 : Yii::t('translations', 'Еще не подсчитано'), 2);
    }

    public function increment_views()
    {
        $this->views++;
        $this->save();
    }

    public function increment_clicks()
    {
        $this->clicks++;
        $this->save();
    }

    public function subtract_balance_on_view($id, $pay_type, $position)
    {

        switch ($pay_type) {
            case Adverts::PAY_TYPE_VIEWS:
                $position == Adverts::POSITION_HEAD ? $count = $this->balance / 25 * 1000 : $count = $this->balance / 15 * 1000;
                break;
        }

        $count--;

        switch ($pay_type) {
            case Adverts::PAY_TYPE_VIEWS:
                $position == Adverts::POSITION_HEAD ? $balance = $count * 25 / 1000 : $balance = $count * 15 / 1000;
                break;
        }

        $this->balance = $balance;
        $this->save($id);
    }

}