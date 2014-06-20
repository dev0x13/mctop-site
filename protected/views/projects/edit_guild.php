<?php
/* @var $this ProjectsController */
$this->pageTitle .= ' - ' . Yii::t('translations', 'Создание гильдии');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    Yii::t('translations', 'Редактирование гильдии проекта name', array('name' => $project->title))
);
?>

<h1><?php echo Yii::t('translations', 'Редактирование гильдии') ?></h1>

<?php $this->renderPartial('form_guild', array(
    'model' => $model
))?>

