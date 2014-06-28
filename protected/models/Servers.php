<?php

/**
 * This is the model class for table "servers".
 *
 * The followings are the available columns in table 'servers':
 * @property string $id
 * @property string $project
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string $version
 * @property integer $license
 * @property integer $whitelist
 * @property integer $own_client
 * @property string $mods
 * @property string $plugins
 * @property string $address
 * @property string $images
 * @property string $images_weight
 * @property string $map_url
 * @property string $register_date
 * @property string $avg_online
 * The followings are the available model relations:
 * @property Projects $project0
 */
class Servers extends CActiveRecord
{

    public $online;
    public $slots;
    public $average_online_month;
    public $queries_count;
    public $queries_count_success;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'servers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('project, title, description, type, version, license, whitelist, own_client, address', 'required'),
            array('license, whitelist, own_client', 'numerical', 'integerOnly' => true),
            array('project', 'length', 'max' => 10),
            array('title', 'length', 'max' => 64),
            array('description', 'length', 'max' => 255),
            array('type, version, address', 'length', 'max' => 128),
            array('mods, plugins, images, images_weight, map_url', 'length', 'max' => 256),
            array('avg_online', 'length', 'max' => 11),
            // The following rule is used by search().
            array('id, project, title, description, type, version, license, whitelist, own_client, mods, plugins, address, images, images_weight, map_url, register_date, avg_online', 'safe', 'on' => 'search'),
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
            'recommended' => array(self::BELONGS_TO, 'RecommendedServers', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'project' => 'Project',
            'title' => 'Title',
            'description' => 'Description',
            'type' => 'Type',
            'version' => 'Version',
            'license' => 'License',
            'whitelist' => 'Whitelist',
            'own_client' => 'Own Client',
            'mods' => 'Mods',
            'plugins' => 'Plugins',
            'address' => 'Address',
            'images' => 'Images',
            'images_weight' => 'Images Weight',
            'map_url' => 'Map url',
            'regiser_date' => 'Register date',
            'avg_online' => 'Avg Online',
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
        $criteria->compare('project', $this->project, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('version', $this->version, true);
        $criteria->compare('license', $this->license);
        $criteria->compare('whitelist', $this->whitelist);
        $criteria->compare('own_client', $this->own_client);
        $criteria->compare('mods', $this->mods, true);
        $criteria->compare('plugins', $this->plugins, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('images', $this->images, true);
        $criteria->compare('images_weight', $this->images_weight, true);
        $criteria->compare('map_url', $this->map_url, true);
        $criteria->compare('register_date', $this->register_date, true);
        $criteria->compare('avg_online', $this->avg_online, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Servers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function isCorrectIp()
    {
        $ip = $this->address;
        if ($this->isHavePort())
            $ip = substr($this->address, 0, strpos($this->address, ':'));

        return (preg_match('/^([\.a-zA-Z0-9\-]{4,32})$/', $ip)) ? true : false;
    }

    public function isHavePort()
    {
        return strpos($this->address, ':') ? true : false;
    }

    public function isCorrectPort($port)
    {
        return ($port >= 0 and $port < 65535) ? true : false;
    }

    public function beforeValidate()
    {

        if (!$this->isCorrectIp())
            $this->addError('address', Yii::t('translations', 'Вы ввели некорректный IP адрес'));

        if ($this->isHavePort())
            if (!$this->isCorrectPort($port = substr($this->address, strpos($this->address, ':') + 1)))
                $this->addError('address', Yii::t('translations', 'Вы ввели некорректный порт'));


        if (!$this->isNewRecord) {
            if (Servers::model()->exists('address=:address and id<>:id', array(':address' => $this->address, ':id' => $this->id)))
                $this->addError('address', Yii::t('translations', 'Сервер с данным адресом уже имеется в системе'));
        } else {
            if (Servers::model()->exists('address=:address', array(':address' => $this->address)))
                $this->addError('address', Yii::t('translations', 'Сервер с данным адресом уже имеется в системе'));
        }


        if (isset($_POST['mods'])) {
            $mods = $_POST['mods'];
            $this->mods = HUtils::TransformToString($mods);
        }

        if (isset($_POST['type'])) {
            $type = $_POST['type'];
            $this->type = HUtils::TransformToString($type);
        }

        if (isset($_POST['version']))
            $this->version = $_POST['version'];

        if (isset($_POST['own_client']))
            $this->own_client = $_POST['own_client'];

        if (isset($_POST['license']))
            $this->license = $_POST['license'];

        return parent::beforeValidate();
    }

    public function afterSave()
    {

        $errors = $this->getErrors();
        if (empty($errors)) {
            $server_address = explode(':', $this->address);

            $server_ip = $server_address[0];

            if (isset($server_address[1]))
                $server_port = $server_address[1];
            else
                $server_port = 25565;

            $version = ServersVersions::model()->findByPk($this->version)->version;
            $version = str_replace('.', '', $version);

            if ($version >= 170)
                $protocol_version = 'new';
            else
                $protocol_version = 'old';

            if (!$this->isNewRecord) {
                $_server = RedisServers::model()->get($this->id);
                $_server->set_id($this->id);
                $_server->set_project_id($this->project);
                $_server->set_ip($server_ip);
                $_server->set_port($server_port);
                $_server->set_protocol_version($protocol_version); //todo id сервера в список проекта
            } else {
                $_server = new RedisServers;
                $_server->set_id($this->id);
                $_server->set_project_id($this->project);
                $_server->set_ip($server_ip);
                $_server->set_port($server_port);
                $_server->set_protocol_version($protocol_version); //todo id сервера в список проекта
            }

            $_server->save();
        }
        return parent::afterSave();
    }

    public function beforeSave()
    {

        if ($this->isNewRecord) {
            if (!empty(Yii::app()->session['mctop_register_project_id']))
                $project = Projects::model()->findByPk(Yii::app()->session['mctop_register_project_id']);
            else
                $project = Projects::model()->findByPk($_GET['id']);
            $project->servers_count++;
            $project->save();
        }

        return parent::beforeSave();

    }

    public function beforeDelete()
    {
        $recommended = RecommendedServers::model()->findByPk($this->id);
        if (!empty($recommended))
            $recommended->delete();
        return parent::beforeDelete();
    }

    public function deleteServer()
    {
        Yii::app()->servers_bd->getClient()->del('server_' . $this->id);
        $this->project0->servers_count--;
        $this->project0->save();

        if ($this->delete())
            return 1;
    }

    public static function generateCriteriaOnSearchByCheckboxes()
    {
        $criteria = new CDbCriteria; // criteria for handling our search values

        if (isset($_POST['players'])) {
            $players = explode('|', $_POST['players']);
            $players_min = $players[0];
            $players_max = $players[1];
        }

        if ($criteria->condition != '')
            $criteria->condition .= ' and avg_online >= ' . $players_min . ' and avg_online <= ' . $players_max;
        else
            $criteria->condition .= 'avg_online >= ' . $players_min . ' and avg_online <= ' . $players_max;

        if (isset($_POST['server_title']))
            $criteria->compare('t.title', $_POST['server_title'], true, 'AND');

        if (isset($_POST['license'])) {
            if ($_POST['license'] <> 'all') {
                $criteria->compare('t.license', (int)$_POST['license'], true, 'AND');
            }
        }

        if (isset($_POST['version'])) {
            if ($_POST['version'] <> 'all') {
                if (isset($_POST['version']))
                    $criteria->compare('version', substr($_POST['version'], 1, strlen($_POST['version'])), true, 'AND');
            }
        }

        if (isset($_POST['whitelist'])) {
            if ($_POST['whitelist'] <> 'all') {
                $criteria->compare('whitelist', (int)$_POST['whitelist'], true, 'AND');
            }
        }

        foreach ($_POST as $key => $checkbox) {
            if ($key <> 'server_title' and $key <> 'version') {
                switch (substr($key, 0, 1)) {
                    case 't':
                        $criteria->compare('type', ':' . substr($key, 1, strlen($key)) . ':', true, 'AND');
                        break;
                    case 'm':
                        $criteria->compare('mods', ':' . substr($key, 1, strlen($key)) . ':', true, 'AND');
                        break;
                }
            }
        }

        $criteria->order = 't.register_date DESC';
        if (isset($_POST['country'])) {
            if ($_POST['country'] <> 'all') {
                $criteria->with = array('project0');
                $criteria->compare('country', substr($_POST['country'], 1, strlen($_POST['country'])), true, 'AND');
            }
        }

        return $criteria;
    }

    public function registerServerInRedis()
    {
        $server_redis = new ServersRedis();
        $server_redis->id = $this->id;
        $server_redis->active = 1;
        $server_redis->name = $this->title;
        $server_redis->ip = $this->address;
        if ($this->isHavePort()) {
            $server_redis->ip = substr($this->address, 0, strpos($this->address, ':'));
            $server_redis->port = substr($this->address, strpos($this->address, ':') + 1);
        } else
            $server_redis->port = 25565;
        $server_redis->totalPlayers = 0;
        $server_redis->totalTrys = 0;
        $server_redis->totalSuccess = 0;
        $server_redis->lastSuccess = 0;
        $server_redis->lastMassCheck = 0;
        if (!$server_redis->save())
            throw new CHttpException(502, 'error');
    }

    public function whitelist()
    {
        if ($this->whitelist)
            return Yii::t('translations', 'Включен');
        else
            return Yii::t('translations', 'Выключен');
    }

    public function license()
    {
        if ($this->license)
            return Yii::t('translations', 'Лицензионная версия');
        else
            return Yii::t('translations', 'Пиратская версия');
    }

    public function version()
    {
        return ServersVersions::model()->findByPk($this->version)->version;
    }

    public function own_client()
    {
        if ($this->own_client)
            return Yii::t('translations', 'Свой клиент');
        else
            return Yii::t('translations', 'Обычный клиент');
    }

    public function getUserServers()
    {
        $roles = ProjectsRoles::getUserRoles(Yii::app()->user->id);
        $projects = [];
        $servers = [];
        if (!empty($roles))
            foreach ($roles as $key => $role) {
                if ($role->role == 2)
                    $projects[] = $role->project;
            }

        if (!empty($projects)) {
            foreach ($projects as $key => $id)
                $projects[$key] = Projects::model()->findByPk($id);

            foreach ($projects as $key => $project) {
                $project_servers = Servers::model()->findAll('project=:project', array(':project' => $project->id));
                if (!empty($project_servers))
                    foreach ($project_servers as $key => $server)
                        $servers[] = $server;
            }
        }

        return $servers;
    }

    public function getUserFavoriteServers()
    {
        if (Yii::app()->user->isGuest)
            throw new CHttpException(403, 'User is guest. <br>M.Servers::' . __LINE__);

        $q = new CDbCriteria();
        $q->condition = 'user = :user';
        $q->params = array(':user' => Yii::app()->user->id);

        $serversRecord = FavoritesServers::model()->find($q);
        if (!is_null($serversRecord)) {
            $servers = HUtils::Parse($serversRecord->servers);
            if (!is_null($servers)) {
                foreach ($servers as $key => $server_id)
                    if (!is_null($server = Servers::model()->findByPk($server_id)))
                        $servers[$key] = $server;
                    else
                        $serversRecord->deleteServerFromFavorites($server_id);
            }
            return $servers;
        } else
            return array();
    }

    public function getStatus()
    {
        return Yii::t('translations', 'Доступен');
    }

    public function addToUserFavoriteList($user = null)
    {

        if (is_null($user))
            $user = Yii::app()->user->id;

        $user_favorite_list = FavoritesServers::model()->findByPk($user);

        if (is_null($user_favorite_list)) {
            $user_favorite_list = new FavoritesServers();
            $user_favorite_list->user = $user;
            $servers = HUtils::TransformToString(array($this->id));
            $servers = HUtils::Parse($servers);
        } else {
            $servers = HUtils::Parse($user_favorite_list->servers);
            if (is_array($servers))
                foreach ($servers as $key => $value) {
                    if ($value == $this->id)
                        return false;
                }

            $servers[] = $this->id;
        }

        $user_favorite_list->servers = HUtils::TransformToString($servers);
        $user_favorite_list->save();

    }

    public function deleteFromUserFavoriteList($user = null)
    {
        if (is_null($user))
            $user = Yii::app()->user->id;

        $user_favorite_list = FavoritesServers::model()->findByPk($user);

        if (is_null($user_favorite_list))
            return false;
        else {
            $servers = HUtils::Parse($user_favorite_list->servers);
            if (is_array($servers))
                foreach ($servers as $key => $value) {
                    if ($value == $this->id)
                        unset($servers[$key]);
                }
            else
                return false;
        }

        $user_favorite_list->servers = HUtils::TransformToString($servers);
        $user_favorite_list->save() or die(print_r($user_favorite_list->getErrors()));
    }

    public function inFavorites($user = null)
    {
        if (is_null($user))
            $user = Yii::app()->user->id;

        $user_favorite_list = FavoritesServers::model()->findByPk($user);

        if (!is_null($user_favorite_list)) {
            $servers = HUtils::Parse($user_favorite_list->servers);
            if (is_array($servers))
                foreach ($servers as $key => $value) {
                    if ($value == $this->id)
                        return true;
                }
            else
                return false;
        }

    }

    public function isServerRecommendedOrWas()
    {
        return is_null($this->recommended) ? false : true;
    }

    public function isRecommendationIsEnded()
    {
        if(isset($this->recommended))
            return HUtils::getCurrentTimestamp() < $this->recommended->till ? false : true;
        else
            return 1;
    }

    public function getCabinetRecommendedStatusMessage()
    {
        if ($this->isServerRecommendedOrWas()) {
            if (!$this->recommended->approved) {
                return Yii::t('translations', '<span class="label label-primary">Статус: Ожидание модерации</span>');
            }
            else
            {
                if(!$this->recommended->payed)
                    return Yii::t('translations', '<span class="label label-warning">Статус: Ожидание оплаты</span>').'<br><a class="btn" href="/cabinet/Recommendedserverspay/'.$this->id.'">'.Yii::t('translations','Оплатить').'</a>';
                else
                    return Yii::t('translations', '<span class="label label-success">Статус: Сервер является рекомендованным</span>');
            }
        }
        if (!$this->isServerRecommendedOrWas()) {
            if($this->isRecommendationIsEnded())
                return '<a class="btn" href="/cabinet/makerecommended/' . $this->id . '">' . Yii::t('translations', 'Приобрести место серверу в списке рекомендованных') . '</a>';
        }

    }

}
