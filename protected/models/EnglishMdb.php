<?php

/**
 * This is the model class for table "english_mdb".
 *
 * The followings are the available columns in table 'english_mdb':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $commands
 *
 * The followings are the available model relations:
 * @property Mdb $id0
 */
class EnglishMdb extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'english_mdb';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id', 'required'),
            array('id', 'length', 'max' => 10),
            array('name', 'length', 'max' => 255),
            array('description, commands', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, description, commands', 'safe', 'on' => 'search'),
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
            'id0' => array(self::BELONGS_TO, 'Mdb', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'commands' => 'Commands',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('commands', $this->commands, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EnglishMdb the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getMod($id)
    {
        return Mdb::model()->find('id=:id', array(':id' => $id));
    }

    public function getPlugin($id)
    {
        return Mdb::model()->find('id=:id', array(':id' => $id));
    }

    public function findByPk($pk, $condition = '', $params = array())
    {
        Yii::trace(get_class($this) . '.findByPk()', 'system.db.ar.CActiveRecord');
        $prefix = $this->getTableAlias(true) . '.';
        $criteria = $this->getCommandBuilder()->createPkCriteria($this->getTableSchema(), $pk, $condition, $params, $prefix);
        $result = $this->query($criteria);
        if (is_null($result))
            return new EnglishMdb();
        else
            return $result;
    }
}
