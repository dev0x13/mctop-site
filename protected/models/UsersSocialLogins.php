<?php

/**
 * This is the model class for table "users_social_logins".
 *
 * The followings are the available columns in table 'users_social_logins':
 * @property string $user
 * @property integer $system
 * @property string $id_in_system
 * @property string $social_avatar
 *
 * The followings are the available model relations:
 * @property Users $user0
 * @property Socials $system0
 */
class UsersSocialLogins extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_social_logins';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user, system, id_in_system', 'required'),
            array('system', 'numerical', 'integerOnly' => true),
            array('user, id_in_system', 'length', 'max' => 10),
            // The following rule is used by search().
            array('user, system, id_in_system', 'safe', 'on' => 'search'),
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
            'user0' => array(self::BELONGS_TO, 'Users', 'user'),
            'system0' => array(self::BELONGS_TO, 'Socials', 'system'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user' => 'User',
            'system' => 'System',
            'id_in_system' => 'Id In System',
            'social_avatar' => 'Avatar',
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

        $criteria->compare('user', $this->user, true);
        $criteria->compare('system', $this->system);
        $criteria->compare('id_in_system', $this->id_in_system, true);
        $criteria->compare('social_avatar', $this->social_avatar, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UsersSocialLogins the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getUserSocialsAccounts($user)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'user=:user';
        $criteria->params = array(':user' => $user);
        return UsersSocialLogins::model()->findAll($criteria);
    }

    public function findUser($system_id, $user_id)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'user=:user and system=:system';
        $criteria->params = array(
            ':user' => $user_id,
            ':system' => $system_id,
        );
        return UsersSocialLogins::model()->find($criteria);
    }
}
