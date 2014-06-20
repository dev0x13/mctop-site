<?php

/**
 * This is the model class for table "projects".
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $site
 * @property string $banner
 * @property integer $country
 * @property integer $score
 * @property integer $give_bonuses
 * @property string $script_url
 * @property string $secret_key
 * @property integer $active
 * @property string $register_date
 * @property ProjectRedis $redisRecord
 * @property integer $banner_clickable
 *
 * The followings are the available columns in table 'projects':
 * @property BalanceProjects $balanceProjects
 * @property Guilds $guilds
 * @property Users[] $users
 * @property GuildsNews[] $guildsNews
 * @property Countries $country0
 * @property ProjectsRoles[] $projectsRoles
 * @property Servers[] $servers
 */
class Projects extends CActiveRecord
{

    const HAVING_SITE_YES = 1;
    const HAVING_SITE_NO = 0;
    const HAVING_SITE_NO_WITHOUT_GUILD = 2;
    public $userRole;
    public $redisRecord;
    protected $registration;
    public $banner_image;
    public $actions = array();
    public $roles = array();
    public $votes_month;
    public $votes_all_period;
    public $register_stage;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'projects';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, description, banner, score', 'required'),
            array('country, give_bonuses, active, banner_clickable', 'numerical', 'integerOnly' => true),
            array('title, site', 'length', 'max' => 64),
            array('description', 'length', 'max' => 256),
            array('banner, script_url, secret_key', 'length', 'max' => 255),
            array('score', 'length', 'max' => 10),
            array('site', 'unique'),
            // The following rule is used by search().
            array('id, title, description, site, banner, country, score, give_bonuses, banner_clickable, script_url, secret_key, active, register_date', 'safe', 'on' => 'search'),
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
            'balanceProjects' => array(self::HAS_ONE, 'BalanceProjects', 'id'),
            'country0' => array(self::BELONGS_TO, 'Countries', 'country'),
            'projectsRoles' => array(self::HAS_MANY, 'ProjectsRoles', 'project'),
            'servers' => array(self::HAS_MANY, 'Servers', 'project'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'site' => 'Site',
            'banner' => 'Banner',
            'country' => 'Country',
            'score' => 'Score',
            'give_bonuses' => 'Give Bonuses',
            'script_url' => 'Script Url',
            'secret_key' => 'Secret Key',
            'active' => 'Banned; Waiting for moderation; Displaying',
            'register_date' => 'Register Date',
            'having_site' => Yii::t('translations', 'Наличие сайта'),
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('site', $this->site, true);
        $criteria->compare('banner', $this->banner, true);
        $criteria->compare('country', $this->country);
        $criteria->compare('score', $this->score, true);
        $criteria->compare('give_bonuses', $this->give_bonuses);
        $criteria->compare('script_url', $this->script_url, true);
        $criteria->compare('secret_key', $this->secret_key, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('register_date', $this->register_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Projects the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeValidate()
    {

        if (empty($this->description))
            if (!empty(Yii::app()->session['provider']))
                $this->description = 'Смените описание';

        $this->checkProjectBanner();

        if (Yii::app()->getController()->id != 'rating') {
            if ($this->having_site == Projects::HAVING_SITE_YES) {
                if (empty($this->site))
                    $this->addError('site', Yii::t('translations', 'Вы не ввели адрес сайта'));
                $this->checkSiteUrl();
            }
        }

        if (isset($_POST['country']))
            $this->country = $_POST['country'];
        if ($this->isNewRecord)
            $this->score = 0;

        return parent::beforeValidate();
    }

    public function checkProjectBanner()
    {
        if ($this->isNewRecord) {
            if (empty($this->banner_image)) {
                $this->addError('banner', Yii::t('translations', 'Укажите изображение для баннера'));
            }
        }
        if (!empty($this->banner_image)) {
            if ($this->banner_image->canBeBanner()) {
                $this->banner_image->save();
                $this->banner_image->image->saveAs(root . '/static/uploaded/u' . Yii::app()->user->id . '/' . $this->banner_image->filename);
                $this->banner = '/static/uploaded/u' . Yii::app()->user->id . '/' . $this->banner_image->filename;
            } else {
                $this->addError('banner', Yii::t('translations', 'Изображение баннера должно быть size пикселей и не более weight кб.', array('size' => '468x60', 'weight' => Yii::app()->params['images']['maxBannerWeight'] / 1024)));
            }
        }

    }

    public function checkSiteUrl()
    {

        if ($this->site != '') {

            //$this->site = Projects::cutAllExceptHttpAndDomain($this->site);

            $expected_https_protocol = substr($this->site, 0, 5);

            /*if ($expected_https_protocol != 'https') {
                $expected_http_protocol = substr($this->site, 0, 5);
                if ($expected_http_protocol != 'http')
                    $this->addError('site', Yii::t('translations', 'Вы ввели некорректный адрес сайта. Формат ввода: :site', [':site' => "<b><u>http</u></b>://mctop.im"]));
            }*/

            //todo FIX

            if (!HUtils::isItValidLink($this->site))
                $this->addError('site', Yii::t('translations', 'Вы ввели некорректный адрес сайта. Формат ввода: :site', [':site' => "http://mctop.im"]));

            if (Projects::model()->exists('site=:site and id<>:id', array(':site' => $this->site, ':id' => $this->id)))
                $this->addError('site', Yii::t('translations', 'Проект с этим сайтом уже имеется в системе'));
        }
    }

    public static function cutAllExceptHttpAndDomain($url)
    {

        if (strlen($url) < 8)
            return '';

        $slash_position = strrchr($url, '/');

        var_dump($slash_position);

        if (strlen($url) > $slash_position)
            $slash_position = strlen($url);

        if ($slash_position)
            $url = substr($url, 0, $slash_position);

        var_dump($url);

        return $url;
    }

    public function afterValidate()
    {

        parent::afterValidate();
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->registration = 1;
            $this->servers_count = 0;
        } else {

            if (!$this->give_bonuses) {
                $this->secret_key = '';
                $this->script_url = '';
            }
        }

        return parent::beforeSave();
    }

    public function afterSave()
    {

        if ($this->registration == 1) {
            $role = new ProjectsRoles();
            if (isset(Yii::app()->session['mctop_register_user_id'])) {
                if (Yii::app()->session['mctop_register_user_id'] > 0)
                    $role->user = Yii::app()->session['mctop_register_user_id'];
            } else
                $role->user = Yii::app()->user->id;
            $role->role = 2;
            $role->project = $this->id;
            $role->save() or $this->delete();
            $redis = Yii::app()->getComponent('redis')->getClient();
            $redis->set("site_code_for_project_" . $this->id, md5(time()));
        }

    }

    public function afterFind()
    {
        $this->votes_month = Yii::app()->redis->getClient()->hget("project:stats:".$this->id, "votes_month");
        $this->votes_all_period = Yii::app()->redis->getClient()->hget("project:stats:".$this->id, "votes_all_period");
        if(!$this->votes_month)
            $this->votes_month = 0;
        if(!$this->votes_all_period)
            $this->votes_all_period = 0;
        $this->redisRecord = ProjectRedis::model()->findByPk($this->id);
        return parent::afterFind();
    }


    /**
     * @param $user
     * @return Projects[]
     */
    public static function getUserProjects($user)
    {
        $roles = ProjectsRoles::getUserRoles($user);
        $projects = [];
        foreach ($roles as $role) {
            $project = Projects::model()->findByPk($role->project);
            $project->userRole = $role;
            $projects[] = $project;
        }
        return $projects;
    }

    public function checkUserRights($user, $action)
    {

        if (empty($this->actions[$action]))
            $this->actions[$action] = Actions::getActionIdByName($action);

        $user_role = ProjectsRoles::getUserRoleInProject($user, $this->id);

        if (empty($this->roles))
            $this->roles = Roles::getRolesOrderedByWeight();

        $user_role = $user_role->role;

        foreach ($this->roles as $role) {

            if ($role->weight <= $user_role) {
                $user_role -= $role->weight;
                if (in_array($this->actions[$action], HUtils::Parse($role->actions)))
                    return true;
            }

        }

        return false;
    }

    public static function checkUserRightsWithException($project, $user, $action)
    {

        $action_id = Actions::getActionIdByName($action);
        $user_role = ProjectsRoles::getUserRoleInProject($user, $project);

        if (is_null($user_role))
        {
            if(!Yii::app()->user->isGuest)
            {
                $description = [];
                $description['action'] = $action;
                $description['target_entity_type'] = 'project';
                $description['target_entity_id'] = $project;
                $serialized_description = serialize($description);

                if(!Reports::model()->isReportExists($serialized_description))
                {
                    $report = new Reports();
                    $report->description = serialize($description);
                    $report->user = Yii::app()->user->id;
                    $report->time = HUtils::getCurrentTimestamp(); //todo Use Time.now
                    $report->save();
                }


            }

            throw new CHttpException(403, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Роль'))));
        }

        $roles = Roles::getRolesOrderedByWeight();

        $user_role = $user_role->role;

        foreach ($roles as $role) {

            if ($role->weight <= $user_role) {
                $user_role -= $role->weight;
                if (in_array($action_id, HUtils::Parse($role->actions)))
                    return 1;
            }

        }

    }

    public static function getProjectRoles($project)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'project=:project';
        $criteria->params = array(':project' => $project);
        return ProjectsRoles::model()->findAll($criteria);
    }

    public static function getProjectMembers($project)
    {
        return self::getProjectMembersByRoles($project);
    }

    public static function getProjectMembersByRoles($project)
    {
        $roles = self::getProjectRoles($project);
        $members = [];
        foreach ($roles as $key => $role) {
            $members[] = Users::model()->findByPk($role->user);
            $members[$key]->user_role = $role->role;
        }

        return $members;
    }

    public function getProjectServers($project)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'project=:project';
        $criteria->params = array(':project' => $project);
        return Servers::model()->findAll($criteria);
    }

    public function getProjectDump($project_servers, $project_roles, $project_balance)
    {

        $balance_dump = 'INSERT INTO balance_projects (';

        foreach ($project_balance as $key => $value)
            $balance_dump .= "`$key`, ";

        $balance_dump = substr($balance_dump, 0, strlen($balance_dump) - 2) . ') VALUES (';
        foreach ($project_balance as $key => $value)
            $balance_dump .= "'$value', ";

        $balance_dump = substr($balance_dump, 0, strlen($balance_dump) - 2) . ");\n";

        $project_dump = 'INSERT INTO projects (';

        foreach ($this as $key => $value) {
            $project_dump .= "`$key`, ";
        }

        $project_dump = substr($project_dump, 0, strlen($project_dump) - 2) . ') VALUES (';
        foreach ($this as $key => $value) {
            $project_dump .= "'$value', ";
        }
        $project_dump = substr($project_dump, 0, strlen($project_dump) - 2) . ");\n";
        $servers = '';

        foreach ($project_servers as $server) {

            $servers .= 'INSERT INTO servers (';

            foreach ($server as $key => $value) {
                $servers .= "`$key`, ";
            }

            $servers = substr($servers, 0, strlen($servers) - 2) . ') VALUES (';
            foreach ($server as $key => $value) {
                $servers .= "'$value', ";
            }
            $servers = substr($servers, 0, strlen($servers) - 2) . ");\n";
        }

        $roles = '';

        foreach ($project_roles as $role) {
            $roles .= 'INSERT INTO projects_roles (';
            foreach ($role as $key => $value) {
                $roles .= "`$key`, ";
            }

            $roles = substr($roles, 0, strlen($roles) - 2) . ') VALUES (';
            foreach ($role as $key => $value) {
                $roles .= "'$value', ";
            }
            $roles = substr($roles, 0, strlen($roles) - 2) . ");\n";
        }
        $ret = array();
        $ret['project'] = $project_dump;
        $ret['project_balance'] = $balance_dump;
        $ret['servers'] = $servers;
        $ret['roles'] = $roles;

        return $ret;
    }

    public function beforeDelete()
    {

        $guild = Guilds::model()->findByPk($this->id);
        if (!empty($guild))
            $guild->delete();

        $project_dump = $this->getProjectDump($project_servers = Projects::getProjectServers($this->id), $project_roles = ProjectsRoles::getProjectRoles($this->id), $project_balance = BalanceProjects::model()->findByPk($this->id));
        HUtils::writeDump($project_dump, '../project_' . $this->id . '.sql');

        foreach ($project_servers as $role) {
            $role->delete();
        }

        foreach ($project_roles as $role) {
            $role->delete();
        }

        if (!empty($project_balance))
            $project_balance->delete();
        return parent::beforeDelete();
    }

    /**
     * @return CDbCriteria
     */
    public static function getCriteriaForMainRating()
    {
        $criteria = new CDbCriteria;
        //$criteria->condition = 'active=:active and servers_count>0 and register_date < DATE_SUB(NOW(), INTERVAL 1 DAY) ';
        $criteria->condition = 'active=:active and servers_count>0 and register_date < DATE_SUB(NOW(), INTERVAL 0 DAY) ';
        $criteria->params = array(':active' => 1);
        $criteria->order = 'score desc';

        if (!Yii::app()->user->isGuest) {
            $user = Users::model()->findByPk(Yii::app()->user->id);
            if (!$user->show_all_projects)
                $criteria->condition .= ' and country <=3';
        }


        return $criteria;
    }

    public function getBonusesOptions()
    {
        return [
            0 => Yii::t('translations', 'Не выдавать бонусы'),
            1 => Yii::t('translations', 'Выдавать бонусы')
        ];
    }

    public function getBannerClickabilityOptions()
    {
        return [
            1 => Yii::t('translations', 'Баннер кликабелен'),
            0 => Yii::t('translations', 'Баннер не кликабелен')
        ];
    }

    public function getProjectRegisterTypes()
    {
        return [
            1 => Yii::t('translations', 'С сайтом'),
            0 => Yii::t('translations', 'Без сайта, создать гильдию'),
            2 => Yii::t('translations', 'Без сайта и гильдии, только IP')
        ];
    }

    public function recountScoreOnVote()
    {

        //TODO UDALI SUKA
        if(!isset($this->redisRecord))
            $this->redisRecord = RedisProjects::get($this->id);

        $k_novelty = time()-strtotime($this->register_date)<24*3600*30 ? 10 : 1;
        $rating = (((($this->redisRecord->stats->votes_month*4) + ($this->redisRecord->stats->votes_all_period / 20)) * $k_novelty));
        $this->score = $rating;
        $this->redisRecord->stats->score = $rating;
    }

    public function getVotesCountMonth()
    {
        $votes_month = Yii::app()->redis->getClient()->hget("project:stats:".$this->id, "votes_month");
        return $votes_month == FALSE ? 0 : $votes_month;
    }

    public function getVotesCountAllPeriod()
    {
        $votes_month = Yii::app()->redis->getClient()->hget("project:stats:".$this->id, "votes_all_period");
        return $votes_month == FALSE ? 0 : $votes_month;
    }

    public function isProjectHaveGuild()
    {
        return (Guilds::model()->exists('pid=:pid', array(':pid' => $this->id))) ? true : false;
    }

}
