<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle .= ' - Login';

?>

<div class="pageTitle"><?php echo Yii::t('translations', 'Забыт пароль ((') ?></div>


<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <input type="hidden" name="stage" value="before_sending">

    <? if (CCaptcha::checkRequirements()): ?>
        <?php echo CHtml::activeLabel($model, 'validacion'); ?>
        <?php $this->widget('application.extensions.recaptcha.EReCaptcha',
            array('model' => $model, 'attribute' => 'validacion',
                'theme' => 'red', 'language' => 'es_ES',
                'publicKey' => '6Lerl_ISAAAAALFJu7P-3m6FRczEG6P1H0G_gSYB')) ?>
        <?php echo CHtml::error($model, 'validacion'); ?>
    <? endif ?>

    <input class="btn" type="submit" value="<?php echo Yii::t('translations', 'Напомнить') ?>"/>

    <?php $this->endWidget(); ?>
</div>