<?php

/**
 * This is the model class for table "guilds".
 *
 * The followings are the available columns in table 'guilds':
 * @property string $pid
 * @property string $name
 * @property string $motd
 * @property string $register_date
 * @property float $rating
 * @property integer $members
 *
 * The followings are the available model relations:
 * @property Projects $p
 */
class Guilds extends CActiveRecord
{

    public $rating;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'guilds';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pid, name, motd', 'required'),
            array('pid', 'length', 'max' => 10),
            array('name, motd', 'length', 'max' => 255),
            array('register_date', 'safe'),
            // The following rule is used by search().
            array('pid, name, motd, register_date, members', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pid' => 'Pid',
            'name' => Yii::t('translations', 'Название гильдии'),
            'motd' => Yii::t('translations', 'Сообщение дня'),
            'register_date' => Yii::t('translations', 'Дата регистрации'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('motd', $this->motd, true);
        $criteria->compare('register_date', $this->register_date, true);
        $criteria->compare('members', $this->members, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Guilds the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->register_date = new CDbExpression('NOW()');
            $this->members = 1;
            $this->rating = 1;
        }

        return parent::beforeSave();
    }

    public function afterSave()
    {
        if ($this->isNewRecord) {
            $founder = new GuildsMembers();
            $founder->pid = $this->pid;
            $founder->uid = Yii::app()->user->id;
            $founder->roles_weight = 2;
            $founder->save();
            $this->register_date = HUtils::getCurrentTimestamp();
            $this->members++;
            $this->rating = 1;
        }
        return parent::afterSave();
    }

    public function afterFind()
    {
        return parent::afterFind();
    }

    public function checkUserRights($user, $action)
    {

        $action = Actions::getActionIdByName($action);

        if (is_null($user_role = GuildsRoles::getUserRoleInGuild($user, $this->pid)))
            //throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Роль'))));
            return;

        $roles = GuildsRoles::getGuildRolesOrderedByWeight();

        $user_role = $user_role->roles_weight;

        foreach ($roles as $role) {

            if ($role->weight <= $user_role) {
                $user_role -= $role->weight;
                if (in_array($action, HUtils::Parse($role->actions)))
                    return true;
            }

        }

        return false;
    }

    public function recountGuildScore($type)
    {

        if ($type == 'leave')
            $this->members--;
        else
            $this->members++;

        $days_after_creation = (round(time() - strtotime($this->register_date)) / (60 * 60 * 24));
        $days_after_creation = (($days_after_creation) > 0 and ($days_after_creation) < 1) ? 1 : $days_after_creation;

        if ($this->members / $days_after_creation < 1 and $this->members / $days_after_creation > 0)
            $this->rating = 1;
        else
            $this->rating = $this->members / $days_after_creation;

        $this->save();
    }


}
