<?php
/* @var $this CommentsController */
/* @var $model Comments */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'user'); ?>
        <?php echo $form->textField($model, 'user'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'comment'); ?>
        <?php echo $form->textArea($model, 'comment', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'module'); ?>
        <?php echo $form->textField($model, 'module'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'entity_id'); ?>
        <?php echo $form->textField($model, 'entity_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'time'); ?>
        <?php echo $form->textField($model, 'time'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->