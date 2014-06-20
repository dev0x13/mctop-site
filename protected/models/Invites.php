<?php

/**
 * This is the model class for table "invites".
 *
 * The followings are the available columns in table 'invites':
 * @property string $key
 * @property string $activated
 * @property integer $user
 */
class Invites extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'invites';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('key, activated, user', 'required'),
            array('user', 'numerical', 'integerOnly' => true),
            array('key', 'length', 'max' => 255),
            array('key, activated, user', 'safe', 'on' => 'search'),
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
            'key' => 'Key',
            'activated' => 'Activated',
            'user' => 'User',
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

        $criteria->compare('key', $this->key, true);
        $criteria->compare('activated', $this->activated, true);
        $criteria->compare('user', $this->user);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Invites the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function isCorrectInvite($hash)
    {
        $record = Invites::model()->findByPk($hash);

        if (!is_null($record)) {
            if ($record->user == 0)
                return 1;
        }

        return 0;
    }

    public function getByHash($hash)
    {
        if ($this->isCorrectInvite($hash))
            return Invites::model()->findByPk($hash);
        else
            throw new CHttpException(403, 'Not a valid invite.');
    }
}
