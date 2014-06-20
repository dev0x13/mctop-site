<?php
/* @var $server EnglishServer */
?>

<div class="form">

    <?php

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
    )); ?>

    <div class="row">
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255, 'placeholder' => '* ' . Yii::t('translations', 'Название сервера'))); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 255, 'placeholder' => '* ' . Yii::t('translations', 'Описание сервера'))); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Редактировать'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->








