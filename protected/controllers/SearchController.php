<?php

class SearchController extends Controller
{

    public function actionIndex()
    {

        if (Yii::app()->request->isAjaxRequest) {
            unset($_POST['yt0']);
            unset($_POST['go']);

            $criteria = Servers::generateCriteriaOnSearchByCheckboxes();
            $pages = new CPagination(Servers::model()->count($criteria));
            $pages->pageSize = 200;
            $pages->applyLimit($criteria);

            $results = Servers::model()->findAll($criteria);
            $countries = Countries::model()->getAllCountriesToSearchResults();

            if (!empty($results))
                foreach ($results as $server)
                    $this->renderPartial('_server', array('server' => $server, 'countries' => $countries));

            Yii::app()->end();
        }

        if (empty($results) && empty($_POST)) {
            $this->render('search', array(
                'mods' => ServersMods::model()->findAll(),
                'types' => ServersTypes::model()->findAll(),
                'versions' => ServersVersions::model()->findAll(),
                'countries_search' => Countries::model()->findAll(),
            ));
        }
    }
}