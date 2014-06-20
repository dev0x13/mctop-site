<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property integer $parent
 * @property string $user
 * @property string $comment
 * @property integer $module
 * @property integer $entity_id
 * @property string $time
 *
 * The followings are the available model relations:
 * @property Users $author
 */
class Comments extends CActiveRecord
{

    const MODULE_GUILD_NEWS = 0;
    const MODULE_NEWS = 1;
    const MODULE_PROJECT = 2;
    const MODULE_SERVER = 3;
    const MODULE_SERVER_GALLERY = 4;
    const MODULE_MDB = 5;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('parent, user, comment, module, entity_id, time', 'required'),
            array('id, parent, module, entity_id', 'numerical', 'integerOnly' => true),
            array('user', 'length', 'max' => 6),
            // The following rule is used by search().
            array('id, parent, user, comment, module, entity_id, time', 'safe', 'on' => 'search'),
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
            'author' => array(self::BELONGS_TO, 'Users', 'user'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'parent' => 'Parent',
            'user' => 'User',
            'comment' => 'Comment',
            'module' => 'Module',
            'entity_id' => 'Entity',
            'time' => 'Time',
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
        $criteria->compare('parent', $this->parent);
        $criteria->compare('user', $this->user, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('module', $this->module);
        $criteria->compare('entity_id', $this->entity_id);
        $criteria->compare('time', $this->time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Comments the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->user = Yii::app()->user->id;
            $this->time = new CDbExpression('NOW()');
        }
        return parent::beforeValidate();
    }

    public function getComments($module, $entity_id)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'module=:module and entity_id=:entity_id';
        $criteria->order = 'time desc';
        $criteria->params = [
            ':module' => $module,
            ':entity_id' => $entity_id
        ];
        return Comments::model()->findAll($criteria);
    }
}
