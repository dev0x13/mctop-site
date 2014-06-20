<?php
/* @var $this ProjectsController */
/* @var $server Servers */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Редактирование сервера');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    $server->project0->title => array('/cabinet/projects/view/' . $server->project0->id),
    $server->title
);
?>

    <div class="pageTitle"><?php echo Yii::t('translations', 'Редактирование сервера') ?></div>

<?php $this->renderPartial('form_server', array(
    'model' => $server,
    'DBmods' => $DBmods,
    'DBversions' => $DBversions,
    'DBtypes' => $DBtypes,
))?>