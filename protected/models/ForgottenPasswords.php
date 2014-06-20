<?php

/**
 * This is the model class for table "forgotten_passwords".
 *
 * The followings are the available columns in table 'forgotten_passwords':
 * @property integer $uid
 * @property string $hash
 * @property string $time
 */
class ForgottenPasswords extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'forgotten_passwords';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid, hash', 'required'),
            array('uid', 'numerical', 'integerOnly' => true),
            array('hash', 'length', 'max' => 255),
            array('time', 'safe'),
            array('uid, hash, time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'uid' => 'Uid',
            'hash' => 'Hash',
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

        $criteria->compare('uid', $this->uid);
        $criteria->compare('hash', $this->hash, true);
        $criteria->compare('time', $this->time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ForgottenPasswords the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getUserHash($user)
    {
        return is_null($record = ForgottenPasswords::model()->findByPk($user)) ? new ForgottenPasswords() : $record;
    }
}
