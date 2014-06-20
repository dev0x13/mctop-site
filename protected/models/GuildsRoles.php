<?php

/**
 * This is the model class for table "guilds_roles".
 *
 * The followings are the available columns in table 'guilds_roles':
 * @property integer $id
 * @property string $name
 * @property integer $weight
 */
class GuildsRoles extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'guilds_roles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, weight', 'required'),
            array('weight', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            array('id, name, weight, actions', 'safe', 'on' => 'search'),
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
        $criteria->compare('weight', $this->weight);
        $criteria->compare('actions', $this->actions);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GuildsRoles the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public static function getGuildRolesOrderedByWeight()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'weight desc';
        return GuildsRoles::model()->findAll($criteria);
    }

    public static function getUserRoleInGuild($user, $guild)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'uid=:user and pid=:project';
        $criteria->params = array(':user' => $user, ':project' => $guild);
        return GuildsMembers::model()->find($criteria);
    }

    public static function getRolesInString($weight)
    {
        $roles = GuildsRoles::getGuildRolesOrderedByWeight();
        $users_roles = "";
        $i = 0;
        foreach ($roles as $role) {
            if ($role->weight <= $weight) {
                if ($i != 0) {
                    $users_roles .= ", ";
                }
                $users_roles .= Yii::t('translations', $role->name);
                $weight -= $role->weight;
                $i++;
            }
        }

        return $users_roles;
    }

    public static function getGuildMembersByRoles($guild)
    {
        $roles = GuildsMembers::getGuildRoles($guild);
        $members = [];
        foreach ($roles as $key => $role) {
            $members[] = Users::model()->findByPk($role->user);
            $members[$key]->user_role = $role->role;
        }

        return $members;
    }

    public static function getRolesForForm()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'weight <> :weight';
        $criteria->params = array(':weight' => 2);
        $criteria->order = 'weight desc';
        return GuildsRoles::model()->findAll($criteria);
    }

}
