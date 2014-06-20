<?php

Class MdbController extends Controller
{

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionType($id = null)
    {

        if (isset($_GET['mods']))
            $id = Mdb::TYPE_MOD;
        if (isset($_GET['plugins']))
            $id = Mdb::TYPE_PLUGIN;

        if ($id > 1 or $id < 0)
            $this->redirect('/mdb');

        $criteria = new CDbCriteria;
        $criteria->order = 'name asc';
        $criteria->condition = 'type=:type';
        if (Yii::app()->language == 'en')
            $criteria->condition .= ' and (select count(*) from english_mdb where id = t.id)>0';
        $criteria->params = array(':type' => $id);
        $pages = new CPagination(Mdb::model()->count($criteria));
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $content = Mdb::model()->findAll($criteria);

        $this->render('type', array(
            'content' => $content,
            'id' => $id
        ));

    }

    public function actionSearch()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $criteria = new CDbCriteria();
            $criteria->order = 'name asc';
            $criteria->addSearchCondition('name', $_POST['title']);
            $results = Mdb::model()->findAll($criteria);
            if (isset($results))
                foreach ($results as $result)
                    $this->renderPartial('_result', array('result' => $result));


            Yii::app()->end();
        }
        $this->render('search');
    }

    public function actionSearchBycommand()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->select = 't.*';
            $criteria->order = 't.name ASC';
            $criteria->join = 'LEFT JOIN mdb_commands ON t.id = mdb_commands.mdb_entity';
            $criteria->condition = 'mdb_commands.name = :command';
            $criteria->params = array(':command' => $_POST['command']);
            $results = Mdb::model()->findAll($criteria);
            if (isset($results))
                foreach ($results as $result)
                    $this->renderPartial('_result', array('result' => $result));

            Yii::app()->end();
        }
        $this->render('searchbycommand');
    }

    public function actionMod($id)
    {
        $mod = Mdb::model()->getMod($id);
        $commands = $mod->getCommands();

        if (is_null($mod))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Модификация'))));

        $english_mod = EnglishMdb::model()->findByPk($id);
        $mod->registerEnglishRecord($english_mod);

        if (Yii::app()->language == 'en' and $english_mod->isNewRecord)
            $this->redirect('/mdb');

        $this->render('mod', array(
            'mod' => $mod,
            'english_mod' => $english_mod,
            'commands' => $commands,
        ));

    }

    public function actionPlugin($id)
    {
        $plugin = Mdb::model()->getPlugin($id);
        $commands = $plugin->getCommands();

        if (is_null($plugin))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Плагин'))));

        $english_plugin = EnglishMdb::model()->findByPk($id);
        $plugin->registerEnglishRecord($english_plugin);

        if (Yii::app()->language == 'en' and $english_plugin->isNewRecord)
            $this->redirect('/mdb');

        $this->render('plugin', array(
            'plugin' => $plugin,
            'english_plugin' => $english_plugin,
            'commands' => $commands,
        ));

    }


}
