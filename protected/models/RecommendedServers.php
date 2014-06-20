<?php

/**
 * Created by PhpStorm.This is the model class for table "recommended_servers".
 * User: root
 * Date: 05.05.14The followings are the available columns in table 'recommended_servers':
 * Time: 5:15@property string $sid
 * @property string $till
 * @property string $registered
 *
 * The followings are the available model relations:
 * @property Servers $s
 */
class RecommendedServers extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'recommended_servers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('registered', 'required'),
            array('sid', 'length', 'max' => 10),
            array('till', 'safe'),
            array('sid, till, registered', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            's' => array(self::BELONGS_TO, 'Servers', 'sid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'sid' => 'Sid',
            'till' => 'Till',
            'registered' => 'Registered',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('sid', $this->sid, true);
        $criteria->compare('till', $this->till, true);
        $criteria->compare('registered', $this->registered, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RecommendedServers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if (isset($_POST['option_period']))
            $period = $_POST['option_period'];

        $this->registered = HUtils::getCurrentTimestamp();

        if (isset($period))
            switch ($period) {
                case 'one_day':
                    $this->till = date('Y-m-d H:i:s', time() + 3600 * 24);
                    break;
                case 'one_week':
                    $this->till = date('Y-m-d H:i:s', time() + 3600 * 24 * 7);
                    break;
                case 'one_month':
                    $this->till = date('Y-m-d H:i:s', time() + 3600 * 24 * 30);
                    break;
            }

        return parent::beforeSave();
    }

    public function getServers()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'registered desc';
        $criteria->condition = 'approved = 1 and payed = 1 and till>NOW()';
        return $criteria;
    }

    public function getRecommendedServer($id)
    {
        $record = RecommendedServers::model()->findByPk($id);

        if (!is_null($record)) {
            if (time() > strtotime($record->till)) {
                $record->payed = 0;
                $record->approved = 0;
            }
            return $record;
        } else {
            $record = new RecommendedServers();
            $record->sid = $id;
            return $record;
        }
    }

    public function isServerApproved()
    {
        if ($this->approved)
            return true;
    }

    public function isServerPayed()
    {
        if ($this->payed)
            return true;
    }

    public function calculateCost()
    {
        $days = round((strtotime($this->till) - strtotime($this->registered)) / 3600 / 24);

        switch ($days) {
            case 30:
                return 5000;
            case 7:
                return 1000;
            case 1:
                return 100;
        }
    }
}
