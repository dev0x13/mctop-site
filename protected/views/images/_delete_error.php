<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - Удаление изображения';

$this->breadcrumbs = array(
    Yii::t('translations', 'Изображения') => array('/images'),
    Yii::t('translations', 'Удаление изображения'),
);
?>

<?php echo $message; ?>

<div class="form">

    <?php

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
    )); ?>

    <br>

    <?php if ($image->using != Images::USING_AS_ADVERT_BANNER): ?>
        <div class="row">
            <input type="hidden" value="yes" name="answer"/>
            <?php echo CHtml::submitButton(Yii::t('translations', 'Удалить из галереи и с сервера. Безвозвратно'), array('class' => 'btn btn-danger')); ?>
        </div>
    <?php endif ?>
    <?php $this->endWidget(); ?>

</div><!-- form -->
