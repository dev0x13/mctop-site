<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle .= ' - Login';

?>

<div class="pageTitle">Login</div>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <div class="form-group">
        <label for="pwd"><?php echo Yii::t('translations', 'Ваш новый пароль') ?></label>
        <input name="pwd" class="form-control" id="pwd"
               placeholder="<?php echo Yii::t('translations', 'Введите пароль') ?>">
    </div>

    <input class="btn" type="submit" value="<?php echo Yii::t('translations', 'Обновить') ?>"/>

    <?php $this->endWidget(); ?>
</div>