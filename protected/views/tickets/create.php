<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Тикеты');

$this->breadcrumbs = array(
    Yii::t('translations', 'Тикеты') => array('/tickets'),
    Yii::t('translations', 'Создание тикета')
);
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
    )); ?>

    <div class="row">
        <?php echo $form->textField($model, 'name', array('id' => 'title', 'size' => 60, 'maxlength' => 64, 'placeholder' => '* ' . Yii::t('translations', 'Тема тикета'))); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->textField($message, 'message', array('id' => 'title', 'size' => 60, 'maxlength' => 64, 'placeholder' => '* ' . Yii::t('translations', 'Сообщение'))); ?>
        <?php echo $form->error($message, 'message'); ?>
    </div>


    <div class="row">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Отправить'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->