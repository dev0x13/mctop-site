<?php
/* @var $this GuildsNewsController */
/* @var $model GuildsNews */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'guilds-news-_form-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation' => false,
    )); ?>

    <?php echo Yii::t('translations', 'Поля со * обязательны к заполнению'); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php echo $form->textField($model, 'text', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'tags'); ?>
        <?php echo $form->textField($model, 'tags', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'tags'); ?>
    </div>

    <div class="form-group buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('translations', 'Создать') : Yii::t('translations', 'Обновить'), array('class' => 'btn btn-success')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->