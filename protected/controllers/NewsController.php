<?php

class NewsController extends Controller
{

    public function actionIndex()
    {
        $criteria = new CDbCriteria;
        if (Yii::app()->language == 'en') {
            $criteria->order = 'post desc';
            $pages = new CPagination(EnglishNewsPost::model()->count($criteria));
            $pages->pageSize = 10;
            $pages->applyLimit($criteria);
            $news = EnglishNewsPost::model()->findAll($criteria);
        } else {
            $criteria->order = 'id desc';
            $pages = new CPagination(News::model()->count($criteria));
            $pages->pageSize = 10;
            $pages->applyLimit($criteria);
            $news = News::model()->findAll($criteria);
        }


        $this->render('content', array(
            'news' => $news,
            'pages' => $pages,
        ));
    }

    public function actionCategory($id)
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'id desc';
        $criteria->condition = 'category=:category';
        $criteria->params = array(':category' => $id);

        $pages = new CPagination(News::model()->count($criteria));
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $news = News::model()->findAll($criteria);

        $this->render('content', array(
            'news' => $news,
            'pages' => $pages,
        ));
    }

    public function actionPost($id)
    {
        $post = News::model()->findByPk($id);
        if (is_null($post))
            throw new CHttpException(404, 'Post is not exists');

        $model = new Comments();

        if (Yii::app()->request->isPostRequest) {
            $model->attributes = $_POST['Comments'];
            $model->entity_id = $id;
            $model->module = Comments::MODULE_NEWS;
            $model->save();
            $model->comment = '';
        }

        $english_post = EnglishNewsPost::model()->findByPk($id);

        if (Yii::app()->language == 'en' and $english_post->isNewRecord)
            $this->redirect('/news');

        $this->render('post', array(
            'post' => $post,
            'english_post' => $english_post,
            'tags' => (Yii::app()->language == 'en') ? HUtils::Parse($english_post->tags) : HUtils::Parse($post->tags),
            'model' => $model,
            'comments' => Comments::model()->getComments(Comments::MODULE_NEWS, $id),
        ));
    }

    public function actionWithTag($tag)
    {
        $criteria = new CDbCriteria;
        $criteria->addSearchCondition('tags', $tag);

        if (Yii::app()->language == 'en') {
            $criteria->order = 'post desc';
            $pages = new CPagination(EnglishNewsPost::model()->count($criteria));
            $pages->pageSize = 10;
            $pages->applyLimit($criteria);
            $news = EnglishNewsPost::model()->findAll($criteria);
        } else {
            $criteria->order = 'id desc';
            $pages = new CPagination(News::model()->count($criteria));
            $pages->pageSize = 10;
            $pages->applyLimit($criteria);
            $news = News::model()->findAll($criteria);
        }


        $this->render('content', array(
            'news' => $news,
            'pages' => $pages,
        ));
    }
}
