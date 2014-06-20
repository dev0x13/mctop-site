<?php
/* @var $this ProjectsController */
/* @var $project Projects */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Удаление проекта');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    Yii::t('translations', 'Удаление проекта') . ' ' . $project->title,
);
?>

<div class="form">


    <?php echo Yii::t('translations', 'Вы собираетесь удалить ВСЕ данные о проекте <b>project_title</b>, включая все серверы, должности.<br> Эта операция необратима', array('project_title' => $project->title)); ?>

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