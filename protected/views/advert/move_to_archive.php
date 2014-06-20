<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Перемещение объявления в архив');

$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Реклама') => array('/advert'),
    Yii::t('translations', 'Редактирование объявления') => array('/advert/edit/'.$model->id),
    Yii::t('translations', 'Перемещение объявления в архив'),
);
?>

<div class="pageTitle"><?php echo Yii::t('translations', 'Перемещение объявления в архив') ?></div>


<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'adverts-advert-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation' => false,
    )); ?>


    <input type="hidden" name="answer" value="only_name">

    <div class="row">
        <?php echo Yii::t('translations', 'Объявление будет помещено в архив, после этого его будет нельзя запустить.') ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Переместить'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->



