<?php

/**
 * This is the model class for table "tickets_messages".
 *
 * The followings are the available columns in table 'tickets_messages':
 * @property string $id
 * @property string $author
 * @property string $message
 * @property string $ticket
 * @property string $time
 *
 * The followings are the available model relations:
 * @property TicketsTopics $ticket0
 * @property Users $author0
 */
class TicketsMessages extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tickets_messages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('author, message, ticket', 'required'),
            array('author, ticket', 'length', 'max' => 10),
            array('message', 'length', 'max' => 255),
            array('time', 'safe'),
            // The following rule is used by search().
            array('id, author, message, ticket, time', 'safe', 'on' => 'search'),
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
            'ticket0' => array(self::BELONGS_TO, 'TicketsTopics', 'ticket'),
            'author0' => array(self::BELONGS_TO, 'Users', 'author'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'author' => 'Author',
            'message' => 'Message',
            'ticket' => 'Ticket',
            'time' => 'Time',
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
        $criteria->compare('author', $this->author, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('ticket', $this->ticket, true);
        $criteria->compare('time', $this->time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TicketsMessages the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
