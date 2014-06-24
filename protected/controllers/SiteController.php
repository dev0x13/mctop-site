<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            'page' => array(
                'class' => 'CViewAction',
            ),
            'oauth' => array(
                'class' => 'ext.hoauth.HOAuthAction',
                'model' => 'Users',
                'attributes' => array(
                    'email' => 'email',
                    'name' => 'firstName',
                    'surname' => 'lastName',
                    'gender' => 'genderShort',
                    'birthday' => 'birthDate',
                    'avatar' => 'photoURL',
                ),
            ),
        );
    }

    public function actionGg()
    {

        if ($_SERVER['REMOTE_ADDR'] != '93.92.202.81')
            die();
        $servers = Servers::model()->findAll();
        foreach ($servers as $key => $server) {
            $server_address = explode(':', $server->address);

            $server_ip = $server_address[0];

            if (isset($server_address[1]))
                $server_port = $server_address[1];
            else
                $server_port = 25565;

            $version = ServersVersions::model()->findByPk($server->version)->version;
            $version = str_replace('.', '', $version);

            if ($version >= 170)
                $version = 'new';
            else
                $version = 'old';

            $_to_json = array(
                'id' => $server->id,
                'ip' => $server_ip,
                'port' => $server_port,
                'protocol_version' => $version
            );

            Yii::app()->servers_bd->getClient()->set('server:' . $server->id, json_encode($_to_json));
        }
    }

    public function actionImport()
    {
        $project = new Projects();
        $servers = [];
        $image = new Images();
        if(Yii::app()->request->isAjaxRequest)
        {
            $server = new Servers();
            $server->attributes = $_POST['Servers'];
            $server->license = $_POST['license'];
            if(!empty($server->type))
                $server->type = $_POST['type'];
            else
                $server->type = ':1:';
            $server->own_client = $_POST['own_client'];
            $server->project = Yii::app()->session['mctop_register_project_id'];

            if($server->save())
                echo 'success';
            else
                var_dump($server->getErrors());
            Yii::app()->end();
        }

        if (Yii::app()->request->isPostRequest) {
            if (isset($_POST['password']))
                Yii::app()->session['mctop_register_password'] = $_POST['password'];
            if (isset($_POST['username']))
                Yii::app()->session['mctop_register_username'] = $_POST['username'];


            $ch = curl_init();
            $url = "http://mctop.im/leo/?a=api&module=project&action=registerWithPassword&password=" . Yii::app()->session['mctop_register_password'] . "&username=" . Yii::app()->session['mctop_register_username'] . "";


            $result = HUtils::sendAjaxGetRequestWithoutParamsArray($url);

            $data = json_decode($result);

            if (is_null($data)) {
                $this->render('profile_not_found');
                Yii::app()->end();
            }

            if ($data->user->pwd == md5(Yii::app()->session['mctop_register_password'])) {
                unset($data->user->id);
                unset($data->project->id);
                $user = new Users();
                foreach ($data->user as $key => $value)
                    $user->$key = $value;

                if (isset($_POST['stage'])) {
                    if ($_POST['stage'] == 'first') {
                        $this->render('continue_import', array(
                            'model' => $user
                        ));
                        die();
                    }
                    if ($_POST['stage'] == 'userRegister') {

                        if (isset($_POST['Users'])) {
                            $user->attributes = $_POST['Users'];
                            $user->pwd = crypt($_POST['password']);
                            $user->language = $_POST['Users']['language'];
                            $user->login = $_POST['login'];
                            $user->can_change_login = false;
                            Yii::app()->session['provider'] = 'mctop';
                            if ($user->save()) {
                                Yii::app()->session['mctop_register_user_id'] = $user->id;

                                foreach ($data->project as $key => $value) {
                                    if ($key != 'url')
                                        $project->$key = $value;
                                    else
                                        $project->site = $value;
                                }

                                $this->render('project_info', array(
                                    'servers' => $servers,
                                    'project' => $project
                                ));
                            } else
                                $this->render('continue_import', array(
                                    'model' => $user
                                ));
                            die();
                        } else {
                            $this->render('continue_import', array(
                                'model' => $user
                            ));
                            die();
                        }


                    }
                }


                $test = CUploadedFile::getInstance($project, 'banner_image');
                if (!empty($test)) {
                    $image->image = CUploadedFile::getInstance($project, 'banner_image');
                    $project->attributes = $_POST['Projects'];
                    $project->banner_image = $image;

                    foreach ($data->servers as $key => $_server) {
                        $server = new Servers();
                        foreach ($_server as $_key => $value)
                            $server->$_key = $value;

                        switch ($server->type) {
                            case 1:
                                $server->type = 2;
                                break;
                            case 2:
                                $server->type = 6;
                                break;
                            case 3:
                                $server->type = 1;
                        }

                        $server->type = ':' . $server->type . ':';
                        $project->servers_count++;
                        $servers[] = $server;
                    }

                    $project->register_date = $data->user->registered;
                    if ($project->save()) {
                        Yii::app()->session['mctop_register_stage'] = 'finally';
                        Yii::app()->session['mctop_register_project_id'] = $project->id;

                        $this->render('servers', array(
                            'servers' => $servers,
                            'project' => $project
                        ));
                        die();
                    } else {
                        $this->render('project_info', array(
                            'servers' => $servers,
                            'project' => $project
                        ));
                        die();
                    }

                }

                if ($_POST['Projects']['register_stage'])
                    if ($_POST['Projects']['register_stage'] == 'finally')
                        $this->redirect('/s/login');

                Yii::app()->end();
            }


            die();
            curl_close($ch);
        }
        $this->render('import');
    }

    public function actionImportUpdateSettings()
    {

    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionLogin()
    {

        if (Yii::app()->user->isGuest) {

            if (Yii::app()->request->urlReferrer != Yii::app()->params['site_url'] . 's/login')
                Yii::app()->request->cookies['previous_url'] = new CHttpCookie('previous_url', Yii::app()->request->urlReferrer);

            $model = new LoginForm;

            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];

                if ($model->validate() && $model->login()) {

                    if ((empty(Yii::app()->session['last_update'])) or (time() - strtotime(Yii::app()->session['last_update']) > 120)) {
                        Yii::app()->session['last_update'] = date('Y-m-d H:i:s', time());
                        if (!empty(Yii::app()->session['last_update'])) {
                            $user = Users::model()->findByPk(Yii::app()->user->id);
                            $user->last_update = Yii::app()->session['last_update'];
                            $user->save();
                        }

                        if (!isset(Yii::app()->request->cookies['previous_url']))
                            $this->redirect(Yii::app()->request->urlReferrer);
                        else
                            $this->redirect(Yii::app()->request->cookies['previous_url']);
                    }

                }

            }

            $this->render('login', array('model' => $model));
        } else {
            if (isset(Yii::app()->request->cookies['previous_url']))
                if (Yii::app()->request->cookies['previous_url'] == Yii::app()->params['site_url'] . 's/login')
                    $this->redirect('/');
            if (!isset(Yii::app()->request->cookies['previous_url']))
                $this->redirect(Yii::app()->request->urlReferrer);
            else
                $this->redirect(Yii::app()->request->cookies['previous_url']);
        }


    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionForgotPwd()
    {
        if (Yii::app()->request->isPostRequest) {
            $model = new PreVote();

            if (isset($_POST['stage'])) {

                // todo: fix captcha Bug
                //if ($model->validate()) {
                if (1 == 1) {
                    $user = Users::model()->findByPk(Yii::app()->session['forgetfulUserId']);
                    $hash = md5(time());

                    $record = ForgottenPasswords::model()->getUserHash($user->id);
                    $record->uid = $user->id;
                    $record->time = new CDbExpression('NOW()');
                    $record->hash = $hash;
                    if ($record->save()) {
                        $message = Yii::t('translations', '
                        Здравствуйте!

                        Похоже на то, что Вы потеряли пароль.

                        Для того, чтобы восстановить пароль Вам необходимо пройти по ссылке.

                        link', array('link' => Yii::app()->params['site_url'] . 's/restorepassword/' . $hash));
                        $mail = mail($user->email, 'MCTop: ' . Yii::t('translations', 'Восстановление пароля'), $message, 'From: MCTop.Dev <dev@mctop.im>' . "\r\n" .
                            'Reply-To: webmaster@mctop.im');
                        var_dump($mail);
                        if ($mail)
                            $this->render('message_sent');
                    }

                    Yii::app()->end();
                }

                $this->render('before_sending_request', array(
                    'model' => $model
                ));
                Yii::app()->end();
            }
            if (isset($_POST['login']))
                $login = $_POST['login'];
            else
                $login = null;
            if (isset($_POST['email']))
                $email = $_POST['email'];
            else
                $email = null;
            $user = Users::model()->findForgetfulUser($login, $email);

            if (!is_null($user)) {
                Yii::app()->session['forgetfulUserId'] = $user->id;
                $this->render('before_sending_request', array(
                    'model' => $model
                ));
            } else
                throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Пользователь'))));

            Yii::app()->end();
        }
        $this->render('forgotpwd');
    }

    public function actionRestorepassword($hash)
    {

        if (!is_null($record = ForgottenPasswords::model()->find('hash=:hash', array(':hash' => $hash)))) {
            if (Yii::app()->request->isPostRequest) {
                $user = Users::model()->findByPk($record->uid);
                $user->pwd = crypt($_POST['pwd']);

                if ($user->save()) {
                    $this->render('passwordsaved');
                    Yii::app()->end();
                }
            }
            $this->render('restorepassword');
        } else
            throw new CHttpException(404, Yii::t('translations', 'Повторите попытку.'));
    }

    public function actionLang($language)
    {
        if ($language == 'lo' or $language == 'en' or $language == 'ru') {
            Yii::app()->session['lang'] = $language;
            if (!Yii::app()->user->isGuest) {
                $user = Users::model()->findByPk(Yii::app()->user->id);
                $user->language = $language;
                $user->save();
            }
        }

        if (isset(Yii::app()->request->urlReferrer))
            $this->redirect(Yii::app()->request->urlReferrer);
        else
            $this->redirect('/');
    }

    public function actionRules()
    {
        $this->render('rules');
    }

    public function actionAbout()
    {
        $this->render('about');
    }

    public function actionTeam()
    {
        $this->render('team');
    }

    public function actionAdvert()
    {
        $this->render('advert');
    }

    public function actionTime()
    {
        Yii::app()->session['time'] = $_GET['time'];
    }

    public function actionRegister()
    {
        $model = new Users();
        if (Yii::app()->request->isPostRequest) {

            $model->attributes = $_POST['Users'];
            if ($model->save()) {
                $this->render('success_register');
                Yii::app()->end();
            }

        }
        $this->render('register', array(
            'model' => $model
        ));
    }

    public function actionSponsors()
    {
        $this->render('sponsors');
    }

    public function actionfest_in_jule()
    {
        $this->render('fest_in_jule');
    }
}
