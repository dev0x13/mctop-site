<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - Добавление изображения';

$this->breadcrumbs = array(
    Yii::t('translations', 'Изображения') => array('/images'),
    Yii::t('translations', 'Добавление изображения'),
);
?>

<?php echo CHtml::form('', 'post', array('enctype' => 'multipart/form-data')); ?>
<?php echo CHtml::activeFileField($image, 'image'); ?>
    <br>
<?php echo CHtml::submitButton(Yii::t('translations', 'Загрузить')); ?>
<?php echo CHtml::endForm(); ?>