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
        <label for="username">Логин на MCTop.su</label>
        <input name="username" class="form-control" id="username" placeholder="Введите логин">
    </div>

    <div class="form-group">
        <label for="username">Пароль на MCTop.su</label>
        <input type="password" name="password" class="form-control" id="username" placeholder="Введите пароль">
    </div>

    <input class="btn" type="submit" value="Импортировать"/>

    <?php $this->endWidget(); ?>
</div>
