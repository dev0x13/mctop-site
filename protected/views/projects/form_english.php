<?php /* @var $form CActiveForm */ ?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data')
    )); ?>

    <div class="row">
        <?php echo $form->textField($model, 'title', array('id' => 'title', 'size' => 60, 'maxlength' => 64, 'placeholder' => '* ' . Yii::t('translations', 'Название проекта'))); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->textField($model, 'description', array('id' => 'description', 'size' => 60, 'maxlength' => 255, 'placeholder' => '* ' . Yii::t('translations', 'Описание'))); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Обновить проект'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


