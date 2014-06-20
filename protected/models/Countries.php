<?php

/**
 * This is the model class for table "countries".
 *
 * The followings are the available columns in table 'countries':
 * @property integer $id
 * @property string $code
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Projects[] $projects
 */
class Countries extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'countries';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, name', 'required'),
            array('code', 'length', 'max' => 2),
            array('name', 'length', 'max' => 64),
            // The following rule is used by search().
            array('id, code, name', 'safe', 'on' => 'search'),
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
            'projects' => array(self::HAS_MANY, 'Projects', 'country'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Countries the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getAllCountriesToSearchResults()
    {
        $countries = Countries::model()->findAll('', array('order' => 'id asc'));

        foreach ($countries as $key => $country)
            $countries[$key] = $country->code;

        return $countries;
    }
}
