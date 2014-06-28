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

    public function actionAuth_Admin()
    {
	$this->render('auth_admin');	
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

        if (Yii::app()->request->urlReferrer != Yii::app()->params['site_url'] . 's/login')
            Yii::app()->request->cookies['previous_url'] = new CHttpCookie('previous_url', Yii::app()->request->urlReferrer);

        if (Yii::app()->user->isGuest) {

            $model = new LoginForm;

            if (!isset($_POST['LoginForm'])) 
                $this->render('login', array('model' => $model));

            else
            {   

                $model->attributes = $_POST['LoginForm'];

                if ($model->validate() && $model->login()) 
                {

                    if(Yii::app()->request->cookies['previous_url'] != Yii::app()->params['site_url'] . 's/login')
                        $this->redirect(Yii::app()->request->cookies['previous_url']);
                    else
                        $this->redirect('/rating');

                }

            }


        } 

        else 
        {
            //if (Yii::app()->request->urlReferrer != Yii::app()->params['site_url'] . 's/login')
            //    Yii::app()->request->cookies['previous_url'] = new CHttpCookie('previous_url', Yii::app()->request->urlReferrer);
            //else
                $this->redirect('/rating');
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

}
