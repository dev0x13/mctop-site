<?php

class RatingController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('*'),
                'users' => array('@', '*'),
            ),

            array('deny',
                'actions' => array('vote', 'favoriteit', 'unfavoriteit'),
                'users' => array('guest'),
            ),
        );
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xF0F000,
            ),
        );
    }

    public function actionIndex()
    {
        $criteria = Projects::getCriteriaForMainRating();
        $pages = new CPagination(Projects::model()->count($criteria));
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $projects = Projects::model()->findAll($criteria);

        $countries = Countries::model()->findAll('', array('order' => 'id asc'));

        foreach ($countries as $key => $country)
            $countries[$key] = $country->code;

        $this->render('content', array(
            'projects' => $projects,
            'pages' => $pages,
            'countries' => $countries,
        ));
    }

    public function actionRecommended()
    {
        $criteria = RecommendedServers::getServers();

        $servers = RecommendedServers::model()->findAll($criteria);

        $countries = Countries::model()->findAll('', array('order' => 'id asc'));

        foreach ($countries as $key => $country)
            $countries[$key] = $country->code;

        $this->render('recommended', array(
            'servers' => $servers,
            'countries' => $countries,
        ));
    }

    public function actionProject($id)
    {
        /*
         * @property Project $project
         */
        $project = Projects::model()->findByPk($id);
        if (is_null($project))
            throw new CHttpException('Project is not exists');

        if (Yii::app()->session["project_$id"] != 1) {
            //$project->redisRecord->increment_countries_viewers();
            Yii::app()->session["project_$id"] = '1';
        }

        $model = new Comments();

        if (Yii::app()->request->isPostRequest) {

            $model->attributes = $_POST['Comments'];
            if (isset($_POST['Comments']['parent']))
                $model->parent = $_POST['Comments']['parent'];
            $model->entity_id = $id;
            $model->module = Comments::MODULE_PROJECT;
            $model->save();
            $model->comment = '';
        }

        $this->render('project', array(
            'project' => $project,
            'model' => $model,
            'comments' => Comments::model()->getComments(Comments::MODULE_PROJECT, $id),
        ));
    }

    public function actionServer($id)
    {
        $server = Servers::model()->findByPk($id);
        $server_redis = RedisServers::model()->get($id);

        if (is_null($server))
            throw new CHttpException('Server is not exists');

        $model = new Comments();

        if (Yii::app()->request->isPostRequest) {
            $model->attributes = $_POST['Comments'];
            if (isset($_POST['Comments']['parent']))
                $model->parent = $_POST['Comments']['parent'];
            $model->entity_id = $id;
            $model->module = Comments::MODULE_SERVER;
            $model->save();
            $model->comment = '';
        }

        $this->render('server', array(
            'server' => $server,
            'server_redis' => $server_redis,
            'model' => $model,
            'comments' => Comments::model()->getComments(Comments::MODULE_SERVER, $id),
        ));
    }

    public function actionServerGallery($id)
    {
        $server = Servers::model()->findByPk($id);
        if (is_null($server))
            throw new CHttpException('Server is not exists');

        $model = new Comments();

        if (Yii::app()->request->isPostRequest) {
            $model->attributes = $_POST['Comments'];
            if (isset($_POST['Comments']['parent']))
                $model->parent = $_POST['Comments']['parent'];
            $model->entity_id = $id;
            $model->module = Comments::MODULE_SERVER_GALLERY;
            $model->save();
            $model->comment = '';
        }

        if (!empty($server->images)) {
            $images = Images::getServerImages($server);

            $this->render('gallery', array(
                'server' => $server,
                'images' => $images,
                'model' => $model,
                'comments' => Comments::model()->getComments(Comments::MODULE_SERVER_GALLERY, $id),
            ));
        } else
            $this->render('server_does_not_have_any_images', array(
                'server' => $server
            ));
    }

    public function actionFavoriteit($id)
    {
        if (!is_null($server = Servers::model()->findByPk($id)))
            $server->addToUserFavoriteList();

        $this->redirect('/rating/server/' . $server->id);
    }

    public function actionUnfavoriteit($id)
    {
        if (!is_null($server = Servers::model()->findByPk($id)))
            $server->deleteFromUserFavoriteList();

        $this->redirect('/rating/server/' . $server->id);
    }

    public function actionAllServers()
    {
        $servers = Servers::model()->findAll();
        $this->render('all_servers', array(
            'data' => $servers
        ));
    }

    public function actionVote($id)
    {

        $UserSocials = UserOAuth::model()->findAll('user_id=:user',array(
            ':user'=>Yii::app()->user->id
        ));
        if(sizeof($UserSocials) == 0)
        {
            $this->render('social_account_not_binded');
        }
         else {
        {
            $model = new PreVote();
            $rd_one = new DateTime('now');
            $rd_two = new DateTime('tomorrow');
            $time = $rd_one->diff($rd_two);

            $project = Projects::model()->findByPk($id);
            if (is_null($project))
                throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

            $svl = new SecurityVoteLayer($project);

            if(isset($svl->flags['multivote']))
            {
                $this->render('vote_success',array(
                    'project'=>$project,
                    'time'=>$time
                ));
                Yii::app()->end();
            }
            else
            {

                if(Yii::app()->request->isPostRequest)
                {
                    $svl->InitSLON();
                    $vote = new Votes();
                    $vote->project = $id;
                    $vote->nick = $_POST['nickname'];
                    $vote->RegisterVote();
                    $vote->registerInQueue($project);

                    $this->render('vote_success',array(
                        'project'=>$project,
                        'time'=>$time
                    ));
                }
                else
                {
                    $this->render('vote',array(
                        'project' => $project,
                        'model' => $model
                    ));
                }


            }

        }
         }

    }

    public function actionOut($id)
    {
        /*
         * @property Project $project
         */

        $project = Projects::model()->findByPk($id);
        if (is_null($project))
            throw new CHttpException('Project is not exists');

        if (Yii::app()->session["project_out_$id"] != 1) {
            //$project->redisRecord->incrementHostsMonth();

            //todo repair it
            Yii::app()->session["project_out_$id"] = '1';
        }

        $this->redirect($project->site);
    }
}
