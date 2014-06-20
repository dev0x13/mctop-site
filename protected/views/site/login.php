<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle .= ' - Login';

?>

<link rel="stylesheet" href="/static/css/zocial.css"/>
<div class="pageTitle"><?php echo Yii::t('translations', 'Авторизация') ?></div>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'class' => 'form-horizontal'
    )
)); ?>

<?php $this->widget('ext.hoauth.widgets.HOAuth'); ?>

<hr>

<div class="form-group">
    <div class="col-sm-4">
        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => Yii::t('translations', 'Логин'))); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-4">
        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'type' => 'password', 'placeholder' => Yii::t('translations', 'Пароль'))); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
</div>


<?php echo $form->checkBox($model, 'rememberMe'); ?>
<?php echo Yii::t('translations', 'Запомнить меня'); ?>

<?php echo $form->error($model, 'rememberMe'); ?>

<hr>
<div style="text-align: center;">
    <?php echo CHtml::submitButton(Yii::t('translations', 'Войти'), array('class' => 'btn btn-success mctbtn_tight')); ?>
    <a href="/s/forgotpwd"
       class="btn btn-primary mctbtn_tight"><?php echo Yii::t('translations', 'Забыл пароль (('); ?></a>
    <?php if (Yii::app()->language != 'en'): ?>
        <a href="/s/import" class="btn btn-default">Регистрация текущих участников mctop.su</a>
    <?php endif ?>
</div>

<?php $this->endWidget(); ?>
