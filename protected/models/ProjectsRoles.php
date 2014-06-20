<?php

/**
 * This is the model class for table "projects_roles".
 *
 * The followings are the available columns in table 'projects_roles':
 * @property string $id
 * @property string $user
 * @property string $project
 * @property integer $role
 *
 * The followings are the available model relations:
 * @property Projects $project0
 * @property Users $user0
 */
class ProjectsRoles extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'projects_roles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user, role', 'required'),
            array('role', 'numerical', 'integerOnly' => true),
            array('user, project', 'length', 'max' => 10),
            // The following rule is used by search().
            array('id, user, project, role', 'safe', 'on' => 'search'),
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
            'user0' => array(self::BELONGS_TO, 'Users', 'user'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user' => 'User',
            'project' => 'Project',
            'role' => 'Role',
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
        $criteria->compare('user', $this->user, true);
        $criteria->compare('project', $this->project, true);
        $criteria->compare('role', $this->role);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProjectsRoles the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function afterValidate()
    {
        $user = Users::model()->findByPk($this->user);
        if (is_null($user))
            $this->addError('user', Yii::t('translations', 'Пользователь с указанным UID не найден')); /*User with that UID does not exists*/

        if (ProjectsRoles::getUserRoleInProject($user->id, $this->project) != null)
            if (Roles::getGeneralRole(ProjectsRoles::getUserRoleInProject($user->id, $this->project)->role)->weight == 2)
                $this->addError('user', Yii::t('translations', 'Вы не можете устанавливать роли выбранному пользователю')); /*You can not set the role for selected user*/
    }


    public static function getUserRoles($user)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'user = :user';
        $criteria->params = array(':user' => $user);
        return ProjectsRoles::model()->findAll($criteria);
    }

    /**
     * @param $user
     * @param $project
     * @return ProjectsRoles
     */
    public static function getUserRoleInProject($user, $project)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'user=:user and project=:project';
        $criteria->params = array(':user' => $user, ':project' => $project);
        return ProjectsRoles::model()->find($criteria);
    }

    public static function checkExistingInProject($user, $project)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'user=:user and project=:project';
        $criteria->params = array(':user' => $user, ':project' => $project);
        $role = ProjectsRoles::model()->find($criteria);

        if (is_null($role))
            $role = new ProjectsRoles();

        return $role;
    }

    public function preliminaryFilterRolesInProject($users, $project)
    {

        $dontHaveRolesInProject = [];

        foreach ($users as $key => $user) {

            $user_id = Users::model()->findByAttributes(array('login' => $user))->id;
            $criteria = new CDbCriteria();
            $criteria->condition = 'user=:user and project=:project';
            $criteria->params = array(':user' => $user_id, ':project' => $project);
            $role = ProjectsRoles::model()->find($criteria);

            if (is_null($role))
                $dontHaveRolesInProject[] = $user;
        }

        return $dontHaveRolesInProject;
    }

    public static function getAllUserRolesInProject($user, $project, $only_weight = false)
    {
        $roles = Roles::getRolesOrderedByWeight();
        $user_role = ProjectsRoles::getUserRoleInProject($user, $project);
        $user_role = $user_role->role;
        $users_roles = array();

        foreach ($roles as $role) {

            if ($role->weight <= $user_role) {
                if ($only_weight) {
                    $users_roles[] = $role->weight;
                } else {
                    $users_roles[] = $role;
                }
                $user_role -= $role->weight;
            }

        }

        return $users_roles;

    }

    public static function roleExists($weight)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'weight=:weight';
        $criteria->params = array(':weight' => $weight);
        return Roles::model()->exists($criteria);
    }

    public static function getProjectRoles($project)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'project=:project';
        $criteria->params = array(':project' => $project);
        return ProjectsRoles::model()->findAll($criteria);
    }

}
