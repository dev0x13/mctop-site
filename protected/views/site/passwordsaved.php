<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle .= ' - Login';

?>

<div class="pageTitle">Login</div>

<?php echo Yii::t('translations', 'Пароль был обновлен'); ?><br><br>
<a href="/s/login" class="btn btn-primary"><?php echo Yii::t('translations', 'Войти на сайт'); ?></a>