<?php

class AdvertController extends Controller
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
                'actions' => array('index', 'create', 'edit', 'move'),
                'users' => array('@'),
            ),

            array('allow',
                'actions' => array('out'),
                'users' => array('*'),
            ),

            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->render('index', array(
            'adverts' => Adverts::getUserAdverts(Yii::app()->user->id),
        ));
    }

    public function actionCreate($type = null, $id = null)
    {

        $model = new Adverts();
        $image = new Images();
        $selected = null;
        if (is_null($id))
            $id = 0;
        else {
            $project = Projects::model()->findByPk($id);
            if (is_null($project))
                throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

            $project->checkUserRightsWithException($id, Yii::app()->user->id, 'project_financer_create_advert');
        }

        if (isset($_POST['Adverts'])) {
            $selected = $_POST['Adverts']['payer'];
            $model->attributes = $_POST['Adverts'];
            $model->user = Yii::app()->user->id;
            $model->registerPayer($_POST['Adverts']['payer']);

            $test = CUploadedFile::getInstance($model, 'banner_image');
            if (!empty($test)) {
                $image->image = CUploadedFile::getInstance($model, 'banner_image');
                $model->banner_image = $image;
            }

            if ($model->registerAdvert())
                $this->redirect('/advert');
        }

        if (is_null($type))
            $this->render('create');
        else {

            $bank_account = $type == 'project' ? Adverts::getPossibleBankAccountsForUser(Yii::app()->user->id) : BalanceUsers::getUserBankAccount(Yii::app()->user->id);
            if (!empty($bank_account)) {
                $this->render('create', array(
                    'model' => $model,
                    'bank_account' => $bank_account,
                    'selected' => $selected,
                    'id' => $id
                ));
            } else
                throw new CHttpException(404, 'Вы не имеете проектов');

        }

    }

    public function actionEdit($id)
    {
        if (!($advert = Adverts::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдено', array('entity' => Yii::t('translations', 'Объявление'))));

        if ($advert->user != Yii::app()->user->id)
            throw new CHttpException(404, Yii::t('translations', 'entity не найдено', array('entity' => Yii::t('translations', 'Объявление'))));

        $image = new Images();

        if (isset($_POST['Adverts'])) {
            if (isset($_POST['Adverts']['name']))
                $advert->name = $_POST['Adverts']['name'];
            if(isset($_POST['Adverts']['displayed']))
                $advert->displayed = $_POST['Adverts']['displayed'];
            $test = CUploadedFile::getInstance($advert, 'banner_image');
            if (!empty($test)) {
                $image->image = CUploadedFile::getInstance($advert, 'banner_image');
                $advert->banner_image = $image;
            }
            if ($advert->save())
                $this->redirect('/advert');
        }

        $this->render('edit', array(
            'model' => $advert,
        ));
    }

    public function actionMove($id)
    {
        if (!($advert = Adverts::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдено', array('entity' => Yii::t('translations', 'Объявление'))));

        if (isset($_POST['answer'])) {
            $advert->active = Adverts::ADVERT_ARCHIVED;
            if ($advert->returnMoney())
                if ($advert->save() or die())
                    $this->redirect('/advert');
        }

        $this->render('move_to_archive', array(
            'model' => $advert,
        ));
    }

    public function actionOut($id)
    {
        if (is_null($advert = Adverts::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдено', array('entity' => Yii::t('translations', 'Объявление'))));

        $advert->out();
    }
}