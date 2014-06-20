<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Регистрация');

?>

<div class="pageTitle"><?php echo Yii::t('translations', 'Регистрация') ?></div>

<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'users-user-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation' => false,
    )); ?>

    <h1>
        <?php if (Yii::app()->language == 'en') echo 'MCTop.Servers project is greeting You.<hr>' ?>
    </h1>

    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'login'); ?>
        <?php echo $form->textField($model, 'login', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'login'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="form-group">
        <label><?php echo $form->labelEx($model, 'birthday'); ?></label>
        <?
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'Users[birthday]',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '1920:' . (date("Y", time()) - 6),
                'minDate' => '1920-01-01', // minimum date
                'maxDate' => (date("Y", time()) - 6) . '-12-31', // maximum date
            ),
            'value' => date("m/d/Y", (time())),
            'htmlOptions' => array(
                'style' => 'height:30px;',
                'class' => 'form-control'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'birthday'); ?>
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
        <?php echo $form->passwordField($model, 'pwd', array('class' => 'form-control', 'placeholder' => Yii::t('translations', 'Пароль'), 'value' => '')); ?>
        <?php echo $form->error($model, 'pwd'); ?>
    </div>

    <hr>
    <div class="form-group buttons">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Создать аккаунт'), array('class' => 'btn btn-primary')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->