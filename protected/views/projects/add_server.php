<?php
/* @var $this ProjectsController */
$this->pageTitle .= ' - ' . Yii::t('translations', 'Добавление сервера');


$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    $project->title => array('/cabinet/projects/' . $project->id),
    Yii::t('translations', 'Добавление сервера')
);
?>
    <div class="pageTitle"><?php echo Yii::t('translations', 'Добавление сервера') ?></div>

<?php $this->renderPartial('form_server', array(
    'model' => $model,
    'DBmods' => $DBmods,
    'DBversions' => $DBversions,
    'DBtypes' => $DBtypes,
))?>