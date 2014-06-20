<?php

/**
 * This is the model class for table "sponsors".
 *
 * The followings are the available columns in table 'sponsors':
 * @property string $date
 * @property string $name
 * @property double $summ
 */
class Sponsors extends CActiveRecord
{

    public $date;
    public $name;
    public $summ;

    public function tableName()
    {
        return 'sponsors';
    }

    public function rules()
    {
        return array(
            array('name, summ', 'required'),
            array('summ', 'numerical'),
            array('name', 'length', 'max' => 255),
            array('date', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'date' => 'Date',
            'name' => 'Name',
            'summ' => 'Summ',
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setName($string)
    {
        $this->name = $string;
    }

    public function setSumm($integer)
    {
        $this->summ = $integer;
    }


}
