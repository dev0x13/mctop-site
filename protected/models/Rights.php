<?php

/**
 * This is the model class for table "rights".
 *
 * The followings are the available columns in table 'rights':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $weight
 * @property string $actions
 */
class Rights extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'rights';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, title, weight, actions', 'required'),
            array('weight', 'numerical', 'integerOnly' => true),
            array('name, title, actions', 'length', 'max' => 255),
            // The following rule is used by search().
            array('id, name, title, weight, actions', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
            'weight' => 'Weight',
            'actions' => 'Actions',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('weight', $this->weight);
        $criteria->compare('actions', $this->actions, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Rights the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
