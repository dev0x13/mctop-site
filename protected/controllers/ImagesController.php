<?php

class ImagesController extends Controller
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
                'actions' => array('index', 'add', 'edit', 'del', 'addtogallery', 'useasbanner'),
                'users' => array('@'),
            ),


            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $data = Images::getUserImagesWithPages(Yii::app()->user->id);
        if (Yii::app()->request->isAjaxRequest) {
            Images::rename($_POST['id'], $_POST['input']);
            Yii::app()->end();
        } else {
            $this->render('index', array(
                'images' => $data['images'],
                'pages' => $data['pages']
            ));
        }

    }

    public function actionAdd()
    {

        $image = new Images();
        if (isset($_POST['Images'])) {
            $image->attributes = $_POST['Images'];
            $image->image = CUploadedFile::getInstance($image, 'image');
            if ($image->save()) {
                $image->image->saveAs(root . '/static/uploaded/u' . Yii::app()->user->id . '/' . $image->filename);
                $this->redirect('/images');
            }
        }
        $this->render('add', array(
            'image' => $image
        ));
    }

    public function actionEdit($id)
    {
        $this->render('edit');
    }

    public function actionDel($id)
    {

        $image = Images::getUserImage(Yii::app()->user->id, $id);

        if (is_null($image))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдено', array('entity' => Yii::t('translations', 'Изображение'))));

        $err = 0;

        if ($image->using == Images::USING_AS_PROJECT_BANNER) {
            $err++;
            $this->render('_delete_error', array(
                'message' => Yii::t('translations', 'Ошибка при удалении: изображение используется в качестве баннера.'),
                'type' => 1
            ));
        } else
            if ($image->using == Images::USING_IN_GALLERY) {
                if (isset($_POST['answer'])) {
                    if (Images::deleteFromGalleries($image))
                        $this->redirect('/images');
                }
                $err++;
                $this->render('_delete_error', array(
                    'message' => Yii::t('translations', 'Ошибка при удалении: изображение используется в галерее.'),
                    'type' => 2
                ));
            } else
                if ($image->using == Images::USING_AS_ADVERT_BANNER) {
                    $err++;
                    $this->render('_delete_error', array(
                        'message' => Yii::t('translations', 'Ошибка при удалении: изображение используется в качестве рекламного баннера.'),
                        'type' => 3,
                        'image' => $image
                    ));
                }

        if ($err == 0)
            if ($image->deleteImage())
                $this->redirect('/images');

    }

    public function actionUseAsBanner($id, $project)
    {

        $project = Projects::model()->findByPk($project);
        $image = Images::getUserImage(Yii::app()->user->id, $id);

        if (is_null($image) or is_null($project) or (!Projects::checkUserRightsWithException($project->id, Yii::app()->user->id, 'project_edit')))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдено', array('entity' => Yii::t('translations', 'Изображение'))));

        if (isset($_POST['answer'])) {
            if ($_POST['answer'] == 'yes') {
                $project->banner = '/static/uploaded/u' . Yii::app()->user->id . '/' . $image->filename;
                $project->save();
                $image->using = Images::USING_AS_PROJECT_BANNER;
                $image->save();
                $this->redirect('/images');
            }
        }

        $this->render('useasbanner', array(
            'image' => $image,
            'project' => $project
        ));
    }

    public function actionAddToGallery($id, $server)
    {
        $server = Servers::model()->findByPk($server);
        $image = Images::getUserImage(Yii::app()->user->id, $id);

        if (is_null($image) or is_null($server) or (!Projects::checkUserRightsWithException($server->project0->id, Yii::app()->user->id, 'project_edit')) or Images::isAlreadyUsingInGallery($image, null, HUtils::Parse($server->images)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдено', array('entity' => Yii::t('translations', 'Изображение'))));

        if ($image->using == Images::USING_AS_PROJECT_BANNER or $image->using == Images::USING_AS_ADVERT_BANNER)
            $this->redirect('/images');

        if (isset($_POST['answer'])) {
            if ($_POST['answer'] == 'yes') {
                $images = HUtils::Parse($server->images);
                $images[] = $id;
                $server->images = HUtils::TransformToString($images);
                $server->save();
                $image->using = Images::USING_IN_GALLERY;
                $image->save();
                $this->redirect('/images');
            }
        }

        $this->render('addtogallery', array(
            'image' => $image,
            'server' => $server
        ));
    }

}