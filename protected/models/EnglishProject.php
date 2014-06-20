<?php

/**
 * This is the model class for table "english_project".
 *
 * The followings are the available columns in table 'english_project':
 * @property string $project
 * @property string $description
 * @property string $title
 *
 * The followings are the available model relations:
 * @property Projects $project0
 */
class EnglishProject extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'english_project';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('project', 'required'),
            array('project', 'length', 'max' => 11),
            array('title', 'length', 'max' => 255),
            array('project, description, title', 'safe', 'on' => 'search'),
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
            'project0' => array(self::BELONGS_TO, 'Projects', 'project'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'project' => 'Project',
            'description' => 'Description',
            'title' => 'Title',
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

        $criteria->compare('project', $this->project, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EnglishProject the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getProject($id)
    {
        if (!is_null($project = EnglishProject::model()->findByPk($id)))
            return $project;
        else
            return new EnglishProject();
    }
}
