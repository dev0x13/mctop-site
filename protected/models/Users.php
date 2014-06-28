<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $login
 * @property string $email
 * @property string $pwd
 * @property string $registered
 * @property string $name
 * @property string $surname
 * @property integer $gender
 * @property string $birthday
 * @property string $last_update
 * @property string $language
 * @property string $avatar
 * @property integer $can_change_login
 * @property integer $show_all_projects
 * @property string $invite
 *
 * The followings are the available model relations:
 * @property AdminSiteRights[] $adminSiteRights
 * @property Adverts[] $adverts
 * @property BalanceUsers $balanceUsers
 * @property BankTransactions[] $bankTransactions
 * @property Projects[] $projects
 * @property GuildsNews[] $guildsNews
 * @property Images[] $images
 * @property News[] $news
 * @property ProjectsRoles[] $projectsRoles
 * @property TicketsMessages[] $ticketsMessages
 * @property TicketsTopics[] $ticketsTopics
 * @property UsersSocialLogins[] $usersSocialLogins
 */
class Users extends CActiveRecord
{

    public $user_role;
    public $invite;

    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, registered, name, surname, gender, birthday, last_update', 'required'),
            array('gender, show_all_projects', 'numerical', 'integerOnly' => true),
            array('login, name, surname', 'length', 'max' => 64),
            array('email, pwd', 'length', 'max' => 128),
            array('email, login', 'unique'),
            array('email', 'email'),
            array('email', 'filter', 'filter' => 'mb_strtolower'),
            //todo тут был охуенный паттерн, снял его 28/06/14
            // The following rule is used by search().
            array('id, login, email, pwd, registered, name, surname, gender, birthday, last_update, show_all_projects', 'safe', 'on' => 'search'),
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
            'projectsRoles' => array(self::HAS_MANY, 'ProjectsRoles', 'user'),
            'bankAccount' => [self::HAS_ONE, 'BankTransactions', 'id']
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'login' => Yii::t('translations', 'Логин'),
            'email' => 'Email',
            'pwd' => Yii::t('translations', 'Пароль'),
            'registered' => 'Registered',
            'name' => Yii::t('translations', 'Имя'),
            'surname' => Yii::t('translations', 'Фамилия'),
            'gender' => Yii::t('translations', 'Пол'),
            'birthday' => Yii::t('translations', 'День Рождения'),
            'last_update' => 'Last Update',
            'language' => Yii::t('translations', 'Язык интерфейса'),
            'show_all_projects' => Yii::t('translations', 'Проекты в рейтинге'),
            'invite' => Yii::t('translations', 'invite'),
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
        $criteria->compare('login', $this->login, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('pwd', $this->pwd, true);
        $criteria->compare('registered', $this->registered, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('surname', $this->surname, true);
        $criteria->compare('gender', $this->gender);
        $criteria->compare('birthday', $this->birthday, true);
        $criteria->compare('last_update', $this->last_update, true);
        $criteria->compare('language', $this->language, true);
        $criteria->compare('avatar', $this->avatar, true);
        $criteria->compare('can_change_login', $this->can_change_login);
        $criteria->compare('show_all_projects', $this->show_all_projects);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if (empty(Yii::app()->session['provider']) and Yii::app()->getController()->getAction()->id != 'register') {
                $this->defineUserGender();
                $this->registered = date('Y-m-d', time());
                $this->pwd = 'waiting';
                $this->login = md5($this->registered);
                $this->can_change_login = 1;
            }
            if (Yii::app()->getController()->getAction()->id == 'register') {
                $this->registered = date('Y-m-d', time());
                $this->pwd = crypt($this->pwd);
            }

        } else {
            if (isset($_POST['pwd']))
                $this->pwd = crypt($_POST['pwd']);
            if ($this->can_change_login and $this->login != md5($this->registered))
                if (Users::model()->exists('login=:login and id <> :id', array(':login' => $this->login, ':id' => $this->id)))
                    $this->addError('login', Yii::t('translations', 'Данный логин уже используется'));
                else
                    $this->can_change_login = 0;
        }

        return parent::beforeValidate();
    }

    public function validatePassword($password)
    {
        return crypt($password, $this->pwd) == $this->pwd ? true : false;
    }

    public function getGenderOptions()
    {
        return [
            self::GENDER_MALE => Yii::t('translations', 'Мужской'),
            self::GENDER_FEMALE => Yii::t('translations', 'Женский')
        ];
    }

    public function getLanguageOptions()
    {
        return [
            "ru" => "Русский",
            "lo" => "Leo",
            "en" => "English",
        ];
    }

    public function getShowAllProjectsOptions()
    {
        return [
            1 => Yii::t('translations', 'Отображать все проекты (включая иностранные)'),
            0 => Yii::t('translations', 'Отображать только русскоязычные проекты')
        ];
    }

    public function findByEmail($email)
    {
        return self::model()->findByAttributes(array('email' => $email));
    }

    public function defineUserGender()
    {
        switch ($this->gender) {
            case 'm':
                $this->gender = 0;
                break;
            case 'f':
                $this->gender = 1;
                break;
        }
    }

    public function findForgetfulUser($login, $email)
    {
        $user = Users::model()->findByEmail($email);
        if (!is_null($user))
            return $user;
        $user = Users::model()->find('login=:login', array(
            ':login' => $login
        ));
        if (!is_null($user))
            return $user;
        return null;
    }

    public function preliminarySearch($login)
    {
        $qtxt = "SELECT login FROM users WHERE login LIKE :login";
        $command = Yii::app()->db->createCommand($qtxt);
        $command->bindValue(":login", '%' . $_GET['term'] . '%', PDO::PARAM_STR);
        return $command->queryColumn();
    }

}
