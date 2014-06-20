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

    <div class="form-group">
        <label for="login"><?php echo Yii::t('translations', 'Ваш логин') ?></label>
        <input name="login" class="form-control" id="login"
               placeholder="<?php echo Yii::t('translations', 'Введите логин') ?>">
    </div>

    <div class="form-group">
        <label for="email"><?php echo Yii::t('translations', 'Ваш email') ?></label>
        <input name="email" class="form-control" id="email"
               placeholder="<?php echo Yii::t('translations', 'Введите email') ?>">
    </div>

    <input class="btn" type="submit" value="<?php echo Yii::t('translations', 'Напомнить') ?>"/>

    <?php $this->endWidget(); ?>
</div>