<?php

/**
 * This is the model class for table "mdb".
 *
 * The followings are the available columns in table 'mdb':
 * @property string $id
 * @property integer $type
 * @property string $name
 * @property string $description
 * @property string $commands
 */
class Mdb extends CActiveRecord
{

    const TYPE_PLUGIN = 0;
    const TYPE_MOD = 1;
    public $english_record;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mdb';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, name, description', 'required'),
            array('type', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            array('id, type, name, description', 'safe', 'on' => 'search'),
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
            'type' => '; 0 - plugin; 1 - mdb',
            'name' => 'Name',
            'description' => 'Description',
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
        $criteria->compare('type', $this->type);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Mdb the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getMod($id)
    {
        return Mdb::model()->find('type=:type and id=:id', array(':type' => self::TYPE_MOD, ':id' => $id));
    }

    public function getPlugin($id)
    {
        return Mdb::model()->find('type=:type and id=:id', array(':type' => self::TYPE_PLUGIN, ':id' => $id));
    }

    public function getDescription()
    {
        if (Yii::app()->language == 'en')
            $this->description = $this->english_record->description;

        return $this->description;
    }


    public function getCommands()
    {
        if (Yii::app()->language == 'en')
            $commands = EnglishMdbCommands::model()->findAll('mdb_entity = :id', array(':id' => $this->id));
        else
            $commands = MdbCommands::model()->findAll('mdb_entity = :id', array(':id' => $this->id));
        return $commands;
    }

    public function getHowtoInstall()
    {
        if (Yii::app()->language == 'en')
            $this->description = $this->english_record->description;

        return $this->description;
    }

    public function getLast_version()
    {
        if (!empty(json_decode($this->description)->last_version))
            return json_decode($this->description)->last_version;
    }

    public function getHome_page()
    {
        if (!empty(json_decode($this->description)->home_page))
            return json_decode($this->description)->home_page;
    }

    public function getDownload_url()
    {
        if (!empty(json_decode($this->description)->download_url))
            return json_decode($this->description)->download_url;
    }

    public function registerEnglishRecord($record)
    {
        $this->english_record = $record;
    }
}
