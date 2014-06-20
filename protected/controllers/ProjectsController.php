<?php

class ProjectsController extends Controller
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
                'actions' => array('index', 'add', 'edit', 'edit_english', 'del', 'roles', 'editserver', 'editserver_english', 'delserver', 'addserver', 'modsjson', 'createguild', 'editguild', 'stats', 'view', 'Approve_site', 'approve_site_file', 'bonuses', 'FMCabinet'),
                'users' => array('@'),
            ),

            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $projects = Projects::getUserProjects(Yii::app()->user->id);
        $this->render('index', array(
            'projects' => $projects
        ));
    }

    public function actionView($id)
    {
        $project = Projects::model()->findByPk($id);
        if (is_null($project))
            throw new CHttpException(404, 'Project was not found');
        if (Projects::checkUserRightsWithException($id, Yii::app()->user->id, 'project_view')) {
            $this->render('project', array(
                'project' => $project
            ));
        }

    }

    public function actionAdd()
    {

        $model = new Projects();
        $image = new Images();
        if (isset($_POST['Projects'])) {
            $model->attributes = $_POST['Projects'];
            $model->having_site = $_POST['Projects']['having_site'];

            $test = CUploadedFile::getInstance($model, 'banner_image');

            if (!empty($test)) {
                $image->image = CUploadedFile::getInstance($model, 'banner_image');
                $model->banner_image = $image;
            }

            if ($model->save()) {
                if ($model->having_site == Projects::HAVING_SITE_NO) {
                    $guild = new Guilds();
                    $guild->name = $model->title;
                    $guild->motd = "Hare Krishna";
                    $guild->pid = $model->id;
                    $guild->save();
                }
                $project_redis = new RedisProjects();

                if ($project_redis->save()) {
                    if (ProjectsRoles::model()->count('role=2 and user=:user', array(':user' => Yii::app()->user->id)) > 1)
                        $this->redirect('/projects');
                    else {
                        $this->render('mctop_new_rules');
                        Yii::app()->end();
                    }

                }

            }

        }

        $this->render('add', array(
            'model' => $model,
            'countries' => Countries::model()->findAll()
        ));
    }

    public function actionEdit($id)
    {
        $project = Projects::model()->findByPk($id);
        if (is_null($project))
            throw new CHttpException(404, 'Project was not found');
        $image = new Images();

        if (Projects::checkUserRightsWithException($id, Yii::app()->user->id, 'project_edit')) {
            if (isset($_POST['Projects'])) {

                $project->attributes = $_POST['Projects'];
                $project->having_site = $_POST['Projects']['having_site'];
                $test = CUploadedFile::getInstance($project, 'banner_image');
                if (!empty($test)) {
                    $image->image = CUploadedFile::getInstance($project, 'banner_image');
                    $project->banner_image = $image;
                }

                if ($project->save()) {
                    $this->redirect('/projects');
                }

            }
            $this->render('edit', array(
                'project' => $project,
                'banner' => $image,
                'countries' => Countries::model()->findAll()
            ));
        }

    }

    public function actionEdit_english($id)
    {
        $english_project = EnglishProject::model()->getProject($id);
        $project = Projects::model()->findByPk($id);

        if (Projects::checkUserRightsWithException($id, Yii::app()->user->id, 'project_edit')) {
            if (isset($_POST['EnglishProject'])) {

                $english_project->attributes = $_POST['EnglishProject'];
                $english_project->project = $id;

                if ($english_project->save()) {
                    $this->redirect('/projects');
                } else
                    die();

            }
            $this->render('edit_english', array(
                'project' => $project,
                'english_project' => $english_project,
            ));
        }
    }

    public function actionEditserver_english($id)
    {
        $server = Servers::model()->findByPk($id);
        $server_english = EnglishServer::model()->getServer($id);
        if (is_null($server))
            throw new CHttpException(404, 'Server was not found');

        if (Projects::checkUserRightsWithException($server->project, Yii::app()->user->id, 'project_edit')) {
            if (isset($_POST['EnglishServer'])) {

                $server_english->attributes = $_POST['EnglishServer'];
                $server_english->server = $id;
                if ($server_english->save())
                    $this->redirect('/projects');
            }
            $this->render('edit_server_english', array(
                'server' => $server,
                'server_english' => $server_english,
            ));
        }
    }

    public function actionDel($id)
    {

        //todo Repair
        // * @property Projects $project
        $project = Projects::model()->findByPk($id);
        if (is_null($project))
            throw new CHttpException(404, 'Project was not found');

        if (Projects::checkUserRightsWithException($id, Yii::app()->user->id, 'project_delete')) {
            if (isset($_POST['answer'])) {
                if ($project->redisRecord->delete($project))
                    if ($project->delete())
                        $this->redirect('/projects');
            } else
                $this->render('delete', array(
                    'project' => $project,
                ));
        }
    }

    public function actionRoles($id)
    {

        $project = Projects::model()->findByPk($id);

        if (isset($_POST['ProjectsRoles']))
            $role = ProjectsRoles::checkExistingInProject($_POST['ProjectsRoles']['user'], $project->id);
        else
            $role = new ProjectsRoles();

        if (is_null($project))
            throw new CHttpException(404, 'Project was not found');

        if (Projects::checkUserRightsWithException($id, Yii::app()->user->id, 'project_set_roles')) {
            if (Yii::app()->request->isPostRequest) {

                if (isset($_POST['login'])) {

                    if (isset($_POST['role'])) {
                        $user_id = Users::model()->findByAttributes(array('login' => trim($_POST['login'])))->id;

                        $role = ProjectsRoles::checkExistingInProject($user_id, $project->id);
                        $role->user = $user_id;
                        $role->project = $id;

                        $role->role = 0;
                        foreach (Roles::getRolesOrderedByWeight() as $aRole) {
                            if (isset($_POST[$aRole->weight])) {
                                $role->role += $aRole->weight;
                            }
                        }

                        if ($role->role == 0)
                            throw new CHttpException(403, Yii::t('translations', 'Вы не выбрали ни одну роль в проекте'));

                        if ($role->save())
                            $this->redirect('/cabinet/projects/roles/' . $project->id);
                    } else
                        $role->addError('role', Yii::t('translations', 'Вы не выбрали ни одну роль в проекте'));

                }
            }

            if (!empty($_POST)) {

                if (isset($_POST['method']) && isset($_POST['user'])) {
                    if ($_POST['method'] == 'delete') {
                        $member = ProjectsRoles::getUserRoleInProject($_POST['user'], $project->id);

                        if (is_null($member))
                            throw new CHttpException(403);

                        if (Roles::getGeneralRole($member->role)->weight == 2)
                            throw new CHttpException(403);

                        $member->delete();
                        $this->redirect('/projects/roles/' . $project->id);
                    }
                }
            }
            $this->render('roles', array(
                'members' => Projects::getProjectMembers($id),
                'model' => $role,
                'project' => $project,
                'roles' => Roles::model()->findAll()
            ));
        }
    }

    public function actionAddServer($id)
    {

        if (is_null($project = Projects::model()->findByPk($id)))
            throw new CHttpException(404, 'Project was not found');

        if (Projects::checkUserRightsWithException($project->id, Yii::app()->user->id, 'project_edit')) {
            $model = new Servers();

            if (isset($_POST['Servers'])) {
                $model->attributes = $_POST['Servers'];
                $model->project = $id;
                $model->whitelist = $_POST['Servers']['whitelist'];
                $model->plugins = ".";

                if ($model->save())
                    $this->redirect('/projects');

            }

            $this->render('add_server', array(
                'model' => $model,
                'DBmods' => ServersMods::model()->findAll(),
                'DBversions' => ServersVersions::model()->findAll(array('order' => 'id desc')),
                'DBtypes' => ServersTypes::model()->findAll(),
                'project' => $project
            ));
        }

    }

    public function actionEditServer($id)
    {
        $server = Servers::model()->findByPk($id);
        if (is_null($server))
            throw new CHttpException(404, 'Server was not found');

        if (Projects::checkUserRightsWithException($server->project, Yii::app()->user->id, 'project_edit')) {
            if (isset($_POST['Servers'])) {
                if (!isset($_POST['mods']) and is_null($server->mods))
                    $server->mods = '';

                $server->attributes = $_POST['Servers'];
                if ($server->save())
                    $this->redirect('/projects');
            }
            $this->render('edit_server', array(
                'server' => $server,
                'DBmods' => ServersMods::model()->findAll(),
                'DBversions' => ServersVersions::model()->findAll(),
                'DBtypes' => ServersTypes::model()->findAll(),
            ));
        }
    }

    public function actionDelServer($id)
    {
        if (is_null($server = Servers::model()->findByPk($id)))
            throw new CHttpException(404, 'Server was not found');

        if (Projects::checkUserRightsWithException($server->project, Yii::app()->user->id, 'project_delete_server')) {
            if (isset($_POST['answer'])) {
                if ($server->deleteServer())
                    $this->redirect('/cabinet/projects/view/' . $server->project);
            } else
                $this->render('delete_server', array(
                    'server' => $server,
                ));
        }
    }

    public function actionCreateGuild($id)
    {
        if (is_null($project = Projects::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        if (!$project->isProjectHaveGuild()) {
            $guild = new Guilds();
            $guild->pid = $id;

            if (Projects::checkUserRightsWithException($id, Yii::app()->user->id, 'project_guild_founder')) {
                if (Yii::app()->request->isPostRequest) {
                    $guild->attributes = $_POST['Guilds'];
                    if ($guild->save())
                        $this->redirect('/projects/guild/' . $id);
                }
            }

            $this->render('create_guild', array(
                'project' => $project,
                'model' => $guild
            ));
        } else
            $this->redirect('/projects/guild/' . $id);

    }

    public function actionEditGuild($id)
    {
        if (is_null($project = Projects::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        if ($project->isProjectHaveGuild()) {
            $guild = Guilds::model()->findByPk($id);

            if (Projects::checkUserRightsWithException($id, Yii::app()->user->id, 'project_guild_founder')) {
                if (Yii::app()->request->isPostRequest) {
                    $guild->attributes = $_POST['Guilds'];
                    if ($guild->save())
                        $this->redirect('/projects/guild/' . $id);
                }
            }

            $this->render('edit_guild', array(
                'project' => $project,
                'model' => $guild
            ));
        } else
            $this->redirect('/projects');

    }

    public function actionStats($id)
    {
        if (is_null($project = Projects::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $project->checkUserRightsWithException($id, Yii::app()->user->id, 'project_view');

        $RedisProject = RedisProjects::get($id);

        $this->render('stats', array(
            'project' => $project,
            'ProjectRedis' => $RedisProject
        ));
    }

    public function actionApprove_site($id)
    {
        if (is_null($project = Projects::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $project->checkUserRightsWithException($id, Yii::app()->user->id, 'project_set_roles');

        if (Yii::app()->request->isPostRequest) {
            $redis = Yii::app()->redis->getClient();
            $approve_needles = $redis->get("site_code_for_project_" . $project->id);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $project->site . '/leo.html');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');
            $str = curl_exec($ch);
            curl_close($ch);

            if ($approve_needles == trim($str))
                if ($redis->del("site_code_for_project_" . $project->id))
                    $this->redirect('/projects');
        }
        $this->render('approve_site', array(
            'project' => $project
        ));
    }

    public function actionapprove_site_file($id)
    {
        if (is_null($project = Projects::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $project->checkUserRightsWithException($id, Yii::app()->user->id, 'project_set_roles');

        $redis = Yii::app()->getComponent('redis')->getClient();
        $approve_needles = $redis->get("site_code_for_project_" . $project->id);

        if (!empty($approve_needles))
            echo $approve_needles;
        else
            $redis->set("site_code_for_project_" . $project->id, md5(time()));
    }

    public function actionBonuses($id)
    {
        if (is_null($project = Projects::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $project->checkUserRightsWithException($id, Yii::app()->user->id, 'project_programmer_check_bonus_script');

        if (Yii::app()->request->isPostRequest) {
            $project->attributes = $_POST['Projects'];
            if ($project->save())
                $this->redirect('/cabinet/projects/view/' . $id);
        }
        $this->render('bonuses_script', array(
            'model' => $project
        ));

    }

    public function actionFMCabinet($id)
    {
        if (is_null($project = Projects::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $project->checkUserRightsWithException($id, Yii::app()->user->id, 'project_financer_create_advert');

        $this->render('financer_cabinet', array(
            'project' => $project
        ));
    }

}
