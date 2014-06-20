<?php
/* @var $this ProjectsController */
/* @var $server EnglishServer */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Редактирование сервера');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/projects'),
    $server->project0->title => array('/projects'),
    $server->title
);
?>

    <div class="pageTitle"><?php echo Yii::t('translations', 'Редактирование сервера') ?></div>

<?php $this->renderPartial('form_server_english', array(
    'model' => $server_english,
))?>