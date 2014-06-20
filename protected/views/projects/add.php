<?php
/* @var $this ProjectsController */
$this->pageTitle .= ' - ' . Yii::t('translations', 'Добавление проекта');


$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    Yii::t('translations', 'Добавление проекта')
);
?>

<h1><?php echo Yii::t('translations', 'Добавление проекта') ?></h1>

<?php $this->renderPartial('form', array(
    'model' => $model,
    'countries' => $countries
))?>

