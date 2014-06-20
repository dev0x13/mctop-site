<?php

/**
 * This is the model class for table "admin_site_rights".
 *
 * The followings are the available columns in table 'admin_site_rights':
 * @property string $id
 * @property string $user
 * @property integer $role
 *
 * The followings are the available model relations:
 * @property Users $user0
 */
class AdminSiteRights extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'admin_site_rights';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user, role', 'required'),
            array('role', 'numerical', 'integerOnly' => true),
            array('user', 'length', 'max' => 10),
            // The following rule is used by search().
            array('id, user, role', 'safe', 'on' => 'search'),
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
            'role' => 'Role',
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
        $criteria->compare('user', $this->user, true);
        $criteria->compare('role', $this->role);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AdminSiteRights the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
