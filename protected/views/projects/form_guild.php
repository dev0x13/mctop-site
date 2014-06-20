<?php
/* @var $this GuildsController */
/* @var $model Guilds */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'guilds-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <?php echo Yii::t('translations', 'Поля со * обязательны к заполнению'); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'motd'); ?>
        <?php echo $form->textField($model, 'motd', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
        <?php echo $form->error($model, 'motd'); ?>
    </div>

    <div class="form-group buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('translations', 'Создать') : Yii::t('translations', 'Обновить'), array('class' => 'btn btn-success')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->