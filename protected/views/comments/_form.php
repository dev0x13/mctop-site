<?php
/* @var $this CommentsController */
/* @var $model Comments */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'comments-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
        <?php echo $form->error($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'user'); ?>
        <?php echo $form->textField($model, 'user'); ?>
        <?php echo $form->error($model, 'user'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'comment'); ?>
        <?php echo $form->textArea($model, 'comment', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'comment'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'module'); ?>
        <?php echo $form->textField($model, 'module'); ?>
        <?php echo $form->error($model, 'module'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'entity_id'); ?>
        <?php echo $form->textField($model, 'entity_id'); ?>
        <?php echo $form->error($model, 'entity_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'time'); ?>
        <?php echo $form->textField($model, 'time'); ?>
        <?php echo $form->error($model, 'time'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->