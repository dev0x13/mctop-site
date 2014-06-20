<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'adverts-advert-form-project',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation' => false,
    )); ?>

    <input type="hidden" name="type" value="project">

    <div class="row">
        <select name="Adverts[payer]" data-placeholder="<?php echo Yii::t('translations', 'Позиция объявления'); ?>"
                style="height:55px; width: 250px;" class="chosen-select" tabindex="8">
            <?php

            if (!empty($bank_account)) {
                foreach ($bank_account as $key => $account) {
                    if ($id != 0) {
                        if ($account->id == $id)
                            echo '<option selected value="p' . $account->id . '">' . $account->p->title . ' (' . $account->balance . ' rub)</option>';
                    } else {
                        if ('p' . $account->id == $selected)
                            echo '<option selected value="p' . $account->id . '">' . $account->p->title . ' (' . $account->balance . ' rub)</option>';
                        else
                            echo '<option value="p' . $account->id . '">' . $account->p->title . ' (' . $account->balance . ' rub)</option>';
                    }
                }
            }
            ?>
        </select>
    </div>

    <div class="row">
        <?php echo $form->textField($model, 'name', array('style' => 'width:250px', 'class' => 'form-control', 'placeholder' => Yii::t('translations', 'Название объявления'), 'maxlength' => 30, 'size' => 39)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <select name="Adverts[type]" id="Adverts_type"
                data-placeholder="<?php echo Yii::t('translations', 'Позиция объявления'); ?>"
                style="height:55px; width: 250px;" class="chosen-select" tabindex="8">
            <?php
            if ($model->type) $s = 'selected'; else $s = '';
            echo '<option value="0">' . Yii::t('translations', 'Позиция: Шапка сайта') . ' 728x90 px</option>';
            echo '<option ' . $s . ' value="1">' . Yii::t('translations', 'Позиция: Правая колонка') . ' XxX px</option>';
            ?>
        </select>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <select name="Adverts[pay_type]" id="Adverts_pay_type"
                data-placeholder="<?php echo Yii::t('translations', 'Тип оплаты'); ?>"
                style="height:55px; width: 250px;" class="chosen-select" tabindex="8">
            <?php
            if ($model->pay_type) $s = 'selected'; else $s = '';
            echo '<option value="0">' . Yii::t('translations', 'Плата за клики') . '</option>';
            echo '<option ' . $s . ' value="1">' . Yii::t('translations', 'Плата за просмотры') . '</option>';
            ?>
        </select>
        <?php echo $form->error($model, 'pay_type'); ?>
    </div>

    <div class="row">
        <?php echo $form->textField($model, 'ordered', array('style' => 'width:250px', 'class' => 'form-control', 'placeholder' => Yii::t('translations', 'Количество'), 'maxlength' => 30, 'size' => 39)); ?>
        <?php echo $form->error($model, 'ordered'); ?>
    </div>

    <div class="row">
        <?php echo Yii::t('translations', 'Стоимость'); ?>: <b><span id='money'>0</span></b>
    </div>

    <div class="row">
        <?php echo '* ' . Yii::t('translations', 'Баннер') ?>
        <?php echo CHtml::activeFileField($model, 'banner_image'); ?>
        <?php echo $form->error($model, 'image'); ?>
    </div>

    <hr>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('translations', 'Создать объявление') : Yii::t('translations', 'Обновить объявление'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->



