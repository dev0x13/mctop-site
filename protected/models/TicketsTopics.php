<?php

/**
 * This is the model class for table "tickets_topics".
 *
 * The followings are the available columns in table 'tickets_topics':
 * @property string $id
 * @property integer $user
 * @property string $name
 * @property string $time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TicketsMessages[] $ticketsMessages
 */
class TicketsTopics extends CActiveRecord
{

    const STATUS_CLOSED = 0;
    const STATUS_OPENED = 1;
    const STATUS_AGENT_ANSWERED = 2;
    const STATUS_USER_ANSWERED = 3;
    const STATUS_CLOSED_BY_SUPPORT = 4;


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tickets_topics';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user, name, status', 'required'),
            array('user, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('time', 'safe'),
            // The following rule is used by search().
            array('id, user, name, time, status', 'safe', 'on' => 'search'),
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
            'ticketsMessages' => array(self::HAS_MANY, 'TicketsMessages', 'ticket'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user' => 'User',
            'name' => 'Name',
            'time' => 'Time',
            'status' => 'Status',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user', $this->user);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TicketsTopics the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getUserTickets($user)
    {
        $ret = array();

        $criteria = new CDbCriteria();
        $criteria->condition = 'user=:user';
        $criteria->params = array(':user' => $user);
        $criteria->order = 'id desc';

        $pages = new CPagination(TicketsTopics::model()->count($criteria));
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $ret['pages'] = $pages;
        $ret['tickets'] = TicketsTopics::model()->findAll($criteria);
        return $ret;
    }

    public static function getTicketInfo($ticket)
    {
        $ret = array();

        $criteria = new CDbCriteria();
        $criteria->condition = 'ticket=:ticket';
        $criteria->params = array(':ticket' => $ticket);
        $criteria->order = 'id desc';

        $pages = new CPagination(TicketsMessages::model()->count($criteria));
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $ret['pages'] = $pages;
        $ret['messages'] = TicketsMessages::model()->findAll($criteria);
        return $ret;
    }
}
