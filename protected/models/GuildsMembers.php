<?php

/**
 * This is the model class for table "guilds_members".
 *
 * The followings are the available columns in table 'guilds_members':
 * @property string $pid
 * @property string $uid
 * @property integer $roles_weight
 *
 * The followings are the available model relations:
 * @property Projects $p
 * @property Users $u
 */
class GuildsMembers extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'guilds_members';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pid, uid, roles_weight', 'required'),
            array('roles_weight', 'numerical', 'integerOnly' => true),
            array('pid, uid', 'length', 'max' => 10),
            array('pid, uid, roles_weight', 'safe', 'on' => 'search'),
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
            'p' => array(self::BELONGS_TO, 'Projects', 'pid'),
            'u' => array(self::BELONGS_TO, 'Users', 'uid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pid' => 'Pid',
            'uid' => 'Uid',
            'roles_weight' => 'Roles Weight',
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

        $criteria->compare('pid', $this->pid, true);
        $criteria->compare('uid', $this->uid, true);
        $criteria->compare('roles_weight', $this->roles_weight);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GuildsMembers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function afterValidate()
    {

        if (!$this->isNewRecord) {
            $user = Users::model()->findByPk($this->uid);
            if (is_null($user))
                $this->addError('user', Yii::t('translations', 'Пользователь с указанным UID не найден')); /*User with that UID does not exists*/

            if (GuildsMembers::getGeneralRole(GuildsRoles::getUserRoleInGuild($user->id, $this->pid)->roles_weight)->weight == 2)
                $this->addError('user', Yii::t('translations', 'Вы не можете устанавливать роли выбранному пользователю')); /*You can not set the role for selected user*/
        }
    }


    public static function checkExistingInGuild($user, $guild)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'uid=:user and pid=:guild';
        $criteria->params = array(':user' => $user, ':guild' => $guild);
        $role = GuildsMembers::model()->find('uid=:uid and pid=:pid', array(':uid' => $user, ':pid' => $guild));

        if (is_null($role))
            $role = new GuildsMembers();

        return $role;

    }

    public static function getGuildRoles($guild)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'pid=:project';
        $criteria->params = array(':project' => $guild);
        return GuildsMembers::model()->findAll($criteria);
    }

    public static function getGeneralRole($weight)
    {
        $roles = GuildsRoles::getGuildRolesOrderedByWeight();
        $users_roles = array();
        foreach ($roles as $role) {
            if ($role->weight <= $weight) {
                $users_roles[] = $role;
                $weight -= $role->weight;
            }
        }
        return $users_roles[sizeof($users_roles) - 1];
    }


}
