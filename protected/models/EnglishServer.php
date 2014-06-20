<?php

/**
 * This is the model class for table "english_server".
 *
 * The followings are the available columns in table 'english_server':
 * @property string $server
 * @property string $title
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Servers $server0
 */
class EnglishServer extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'english_server';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('server, title, description', 'required'),
            array('server', 'length', 'max' => 10),
            array('title', 'length', 'max' => 255),
            array('server, title, description', 'safe', 'on' => 'search'),
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
            'server0' => array(self::BELONGS_TO, 'Servers', 'server'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'server' => 'Server',
            'title' => 'Title',
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

        $criteria->compare('server', $this->server, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EnglishServer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getServer($id)
    {
        if (!is_null($server = EnglishServer::model()->findByPk($id)))
            return $server;
        else
            return new EnglishServer();
    }
}
