<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Ошибка');
$this->breadcrumbs = array(
    Yii::t('translations', 'Ошибка'),
);
?>

<h2><?php echo Yii::t('translations', 'Ошибка') ?> <?php echo $code; ?></h2>

<div class="error">
    <?php echo CHtml::encode($message); ?>
</div>