<?php

/**
 * This is the model class for table "roles".
 *
 * The followings are the available columns in table 'roles':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $weight
 * @property string $actions
 */
class Roles extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'roles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, weight, actions', 'required'),
            array('weight', 'numerical', 'integerOnly' => true),
            array('name, actions', 'length', 'max' => 255),
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
     * @return Roles the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getRolesOrderedByWeight()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'weight desc';
        return Roles::model()->findAll($criteria);
    }

    public static function getRolesForForm()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'weight <> :weight';
        $criteria->params = array(':weight' => 2);
        $criteria->order = 'weight desc';
        return Roles::model()->findAll($criteria);
    }

    public static function getRole($weight)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'weight = :weight';
        $criteria->params = array(':weight' => $weight);
        return Roles::model()->find($criteria);
    }

    public static function getGeneralRole($weight)
    {
        $roles = Roles::getRolesOrderedByWeight();
        $users_roles = array();
        foreach ($roles as $role) {
            if ($role->weight <= $weight) {
                $users_roles[] = $role;
                $weight -= $role->weight;
            }
        }

        return $users_roles[sizeof($users_roles) - 1];
    }

    public static function getRolesInString($weight)
    {
        $roles = Roles::getRolesOrderedByWeight();
        $users_roles = "";
        $i = 0;
        foreach ($roles as $role) {
            if ($role->weight <= $weight) {
                if ($i != 0) {
                    $users_roles .= ", ";
                }
                $users_roles .= Yii::t('translations', $role->title);
                $weight -= $role->weight;
                $i++;
            }
        }

        return $users_roles;
    }
}
