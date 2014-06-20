<?php

class GuildsController extends Controller
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
                'actions' => array('index', 'show', 'news', 'achievements', 'members', 'newsCreate', 'newsEdit', 'newsWithTag', 'roles', 'leave', 'join', 'newsPost', 'NewsDelete'),
                'users' => array('@'),
            ),

            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionShow($id)
    {
        $project = Projects::model()->findByPk($id);
        if (is_null($project))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $guild = Guilds::model()->findByPk($id);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));

        $this->render('guild', array(
            'guild' => $guild,
            'project' => $project,
        ));
    }

    public function actionMembers($id)
    {
        $project = Projects::model()->findByPk($id);
        if (is_null($project))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $guild = Guilds::model()->findByPk($id);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));

        $criteria = new CDbCriteria();
        $criteria->condition = 'pid = :pid';
        $criteria->params = array(':pid' => $id);
        $criteria->order = 'roles_weight asc';
        $pages = new CPagination(GuildsMembers::model()->count($criteria));
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $members = GuildsMembers::model()->findAll($criteria);

        $this->render('guild_members', array(
            'members' => $members,
            'project' => $project,
            'guild' => $guild
        ));

    }

    public function actionNews($id)
    {
        $project = Projects::model()->findByPk($id);
        if (is_null($project))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $guild = Guilds::model()->findByPk($id);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));

        $criteria = new CDbCriteria();
        $criteria->condition = 'pid = :pid';
        $criteria->params = array(':pid' => $id);
        $criteria->order = 'id desc';
        $pages = new CPagination(GuildsNews::model()->count($criteria));
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $news = GuildsNews::model()->findAll($criteria);

        $this->render('guild_news', array(
            'guild' => $guild,
            'news' => $news,
            'pages' => $pages,
            'project' => $project,
        ));
    }

    public function actionNewsCreate($id)
    {
        /* @var $guild Guilds */
        $project = Projects::model()->findByPk($id);
        if (is_null($project))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $guild = Guilds::model()->findByPk($id);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));

        if ($guild->checkUserRights(Yii::app()->user->id, 'guild_news_manage')) {
            $model = new GuildsNews();

            if (Yii::app()->request->isPostRequest) {
                $model->attributes = $_POST['GuildsNews'];
                $model->pid = $id;
                $model->author = Yii::app()->user->id;
                if ($model->save())
                    $this->redirect('/guilds/' . $id . '/news');
            }
            $this->render('news_create', array(
                'model' => $model,
                'guild' => $guild
            ));
        }
    }

    public function actionNewsEdit($id)
    {
        /* @var $guild Guilds */
        $post = GuildsNews::model()->findByPk($id);
        if (is_null($post))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Новость'))));

        $guild = Guilds::model()->findByPk($post->pid);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));

        $project = Projects::model()->findByPk($post->pid);

        if ($guild->checkUserRights(Yii::app()->user->id, 'guild_news_manage')) {

            if (Yii::app()->request->isPostRequest) {
                $post->attributes = $_POST['GuildsNews'];
                $post->pid = $project->id;
                $post->author = Yii::app()->user->id;

                if ($post->save())
                    $this->redirect('/guilds/' . $project->id . '/news');
            }
            $this->render('news_edit', array(
                'model' => $post,
                'guild' => $guild
            ));
        }
    }


    public function actionNewsDelete($id)
    {
        /* @var $guild Guilds */
        $guild = Guilds::model()->findByPk($_GET['pid']);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));

        if ($guild->checkUserRights(Yii::app()->user->id, 'guild_news_manage')) {
            $post = GuildsNews::model()->findByPk($id);
            if (is_null($post))
                throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Новость'))));

            if ($post->delete())
                $this->redirect('/guilds/' . $_GET['pid'] . '/news');
        }

    }

    public function actionNewsPost($id)
    {
        /* @var $guild Guilds */
        $guild = Guilds::model()->findByPk($_GET['pid']);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));

        $post = GuildsNews::model()->findByPk($id);
        if (is_null($post))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Новость'))));

        $model = new Comments();

        if (Yii::app()->request->isPostRequest) {
            $model->attributes = $_POST['Comments'];
            if (isset($_POST['Comments']['parent']))
                $model->parent = $_POST['Comments']['parent'];
            $model->module = Comments::MODULE_GUILD_NEWS;
            $model->entity_id = $id;
            $model->save();
        }

        $this->render('post', array(
            'post' => $post,
            'project' => $guild->p,
            'guild' => $guild,
            'comments' => Comments::model()->getComments(Comments::MODULE_GUILD_NEWS, $id),
            'model' => $model
        ));

    }

    public function actionNewsWithTag($tag)
    {
        $project = Projects::model()->findByPk($_GET['pid']);
        if (is_null($project))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $guild = Guilds::model()->findByPk($project->id);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));

        $criteria = new CDbCriteria;
        $criteria->order = 'id desc';
        $criteria->addSearchCondition('tags', $tag);
        $criteria->compare('pid', $project->id);

        $pages = new CPagination(GuildsNews::model()->count($criteria));
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $news = GuildsNews::model()->findAll($criteria);

        $this->render('guild_news_with_tag', array(
            'news' => $news,
            'pages' => $pages,
            'guild' => $guild,
            'project' => $project
        ));
    }

    public function actionRoles($id)
    {
        $project = Projects::model()->findByPk($id);
        if (is_null($project))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        $guild = Guilds::model()->findByPk($id);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));

        if (isset($_POST['GuildsMembers']))
            $role = GuildsMembers::checkExistingInGuild($_POST['GuildsMembers']['uid'], $project->id);
        else
            $role = new GuildsMembers();

        if (Projects::checkUserRightsWithException($id, Yii::app()->user->id, 'project_guild_founder')) {
            if (isset($_POST['GuildsMembers'])) {

                $user = Users::model()->findByPk($_POST['GuildsMembers']['uid']);
                if (is_null($user))
                    throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Пользователь'))));

                $role = GuildsMembers::checkExistingInGuild($_POST['GuildsMembers']['uid'], $project->id);

                $role->attributes = $_POST['GuildsMembers'];
                $role->pid = $id;

                $role->roles_weight = 0;
                foreach (GuildsRoles::getGuildRolesOrderedByWeight() as $aRole) {
                    if (isset($_POST[$aRole->weight])) {
                        $role->roles_weight += $aRole->weight;
                    }
                }

                if ($role->roles_weight == 0)
                    throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Роль'))));

                if ($role->save())
                    $this->redirect('/guilds/' . $project->id . '/roles');
            }
            if (!empty($_POST)) {

                if (isset($_POST['method']) && isset($_POST['user'])) {
                    if ($_POST['method'] == 'delete') {
                        $member = GuildsRoles::getUserRoleInGuild($_POST['user'], $guild->pid);

                        if (is_null($member))
                            throw new CHttpException(403);

                        if (GuildsMembers::getGeneralRole($member->roles_weight)->weight == 2)
                            throw new CHttpException(403);

                        $member->delete();
                        $this->redirect('/guilds/' . $project->id . '/roles');
                    }
                }
            }
            $this->render('roles', array(
                'members' => GuildsMembers::getGuildRoles($id),
                'model' => $role,
                'project' => $project,
                'roles' => GuildsRoles::model()->findAll()
            ));
        }
    }

    public function actionLeave($id)
    {
        $guild = Guilds::model()->findByPk($id);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));

        $member = GuildsMembers::checkExistingInGuild(Yii::app()->user->id, $id);

        if (is_null($member->uid))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Роль'))));
        $guild->recountGuildScore('leave');
        if ($member->delete())
            $this->redirect('/guilds/' . $id);
    }

    public function actionJoin($id)
    {
        $guild = Guilds::model()->findByPk($id);
        if (is_null($guild))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Гильдия'))));


        $member = GuildsMembers::checkExistingInGuild(Yii::app()->user->id, $id);
        if (!is_null($member->uid))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Роль'))));

        $member->uid = Yii::app()->user->id;
        $member->pid = $id;
        $member->roles_weight = 1024;
        $guild->recountGuildScore('join');
        if ($member->save())
            $this->redirect('/guilds/' . $id);

    }

}