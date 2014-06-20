<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Добавление изображения в галерею сервера') . ' ' . $server->title;

$this->breadcrumbs = array(
    Yii::t('translations', 'Изображения') => array('/images'),
    Yii::t('translations', 'Добавление изображения в галерею сервера server_title', array('server_title' => $server->title)),
);
?>

<?php echo Yii::t('translations', 'Хотите ли Вы добавить следущее изображение в галерею сервера <b>server_title</b>', array('server_title' => $server->title)); ?>
<br><br>

<img class="img-responsive" src="/static/uploaded/<?php echo 'u' . Yii::app()->user->id . '/' . $image->filename; ?>"/>

<div class="form">

    <?php

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
    )); ?>

    <br>

    <div class="row">
        <input type="hidden" value="yes" name="answer"/>
        <?php echo CHtml::submitButton(Yii::t('translations', 'Да'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->