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

    <input type="hidden" name="stage" value="userRegister">

    <div class="form-group">
        <label for="login">Новый логин для входа</label>
        <input type="text" name="login" class="form-control" id="login" placeholder="Введите логин"
               value="<?php echo $model->login ?>">
        <?php echo $form->error($model, 'login'); ?>
    </div>

    <div class="form-group">
        <label for="password">Новый пароль для входа</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Введите пароль">
    </div>

    <div class="form-group">
        <label for="email">Ваш Email</label>
        <input type="text" name="email" class="form-control" id="email" placeholder="Введите Email"
               value="<?php echo $model->email ?>">
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

    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'language' => 'ru',
        'model' => $model,
        'name' => 'birthday',
        'attribute' => 'birthday',
        'flat' => true, //remove to hide the datepicker
        'options' => array(
            'dateFormat' => 'yy-mm-dd',
            'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
            'changeMonth' => true,
            'changeYear' => true,
            'yearRange' => '1950:' . (date('Y', time()) - 6),
            'minDate' => '1950-01-01', // minimum date
            'maxDate' => '' . (date('Y', time()) - 6) . '-12-31', // maximum date
        ),
        'htmlOptions' => array(
            'style' => ''
        ),
    ));
    ?>

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
    <input class="btn" type="submit" value="Импортировать"/>

    <?php $this->endWidget(); ?>
</div>
