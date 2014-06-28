<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<?php
$this->breadcrumbs = array(
    $model->name . ' ' . $model->surname => array('/users/profile/' . $model->id),
    Yii::t('translations', 'Настройки профиля'),
);
?>
<link rel="stylesheet" href="/static/css/zocial.css"/>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'users-user-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation' => false,
    )); ?>

    <?php echo $form->errorSummary($model); ?>
    <?php $this->widget('ext.hoauth.widgets.HOAuth'); ?>
    <hr>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'login'); ?>
        <?php echo $form->textField($model, 'login', array('class' => 'form-control')); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'surname'); ?>
        <?php echo $form->textField($model, 'surname', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'surname'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'gender'); ?>
        <?php echo $form->dropDownList($model, 'gender', $model->getGenderOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'gender'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'language'); ?>
        <?php echo $form->dropDownList($model, 'language', $model->getLanguageOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'language'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'show_all_projects'); ?>
        <?php echo $form->dropDownList($model, 'show_all_projects', $model->getShowAllProjectsOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'show_all_projects'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'pwd'); ?>
        <?php echo $form->textField($model, 'pwd', array('class' => 'form-control', 'placeholder' => Yii::t('translations', 'Введите пароль, если хотите изменить текущий'), 'value' => '')); ?>
        <?php echo $form->error($model, 'pwd'); ?>
    </div>

    <hr>
    <div class="form-group buttons">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Обновить'), array('class' => 'btn btn-primary')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->