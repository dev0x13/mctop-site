<?php

/**
 * This is the model class for table "english_mdb_commands".
 *
 * The followings are the available columns in table 'english_mdb_commands':
 * @property integer $id
 * @property string $name
 * @property string $parameter
 * @property string $rights
 * @property string $description
 * @property integer $mdb_entity
 */
class EnglishMdbCommands extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'english_mdb_commands';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, parameter, rights, description, mdb_entity', 'required'),
            array('mdb_entity', 'numerical', 'integerOnly' => true),
            array('name, parameter, rights, description', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, parameter, rights, description, mdb_entity', 'safe', 'on' => 'search'),
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
            'parameter' => 'Parameter',
            'rights' => 'Rights',
            'description' => 'Description',
            'mdb_entity' => 'Mdb Entity',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('parameter', $this->parameter, true);
        $criteria->compare('rights', $this->rights, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('mdb_entity', $this->mdb_entity);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EnglishMdbCommands the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
