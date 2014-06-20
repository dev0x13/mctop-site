<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Использование в качестве баннера');

$this->breadcrumbs = array(
    Yii::t('translations', 'Изображения') => array('/images'),
    Yii::t('translations', 'Использование в качестве баннера'),
);
?>

<?php echo Yii::t('translations', 'Хотите ли Вы использовать баннер для проекта') ?> <?php echo $project->title; ?>?
<br><br>

<img src="/static/uploaded/<?php echo 'u' . Yii::app()->user->id . '/' . $image->filename; ?>"/>

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


