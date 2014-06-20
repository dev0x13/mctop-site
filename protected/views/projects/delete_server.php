<?php
/* @var $this ProjectsController */
/* @var $project Projects */

$this->pageTitle .= ' - Удаление сервера';

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    $server->project0->title => array('/cabinet/projects/view/' . $server->project0->id),
    Yii::t('translations', 'Удаление сервера') . ' ' . $server->title,
);
?>

<div class="form">

    <?php echo yii::t('translations', 'Вы собираетесь удалить ВСЕ данные о сервере <b>server_title</b>.<br> Эта операция необратима', array('server_title' => $server->title)); ?>

    <?php

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
    )); ?>

    <br>

    <div class="row">
        <input type="hidden" value="yes" name="answer"/>
        <?php echo CHtml::submitButton(Yii::t('translations', 'Удалить все данные. Безвозвратно'), array('class' => 'btn btn-danger')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->