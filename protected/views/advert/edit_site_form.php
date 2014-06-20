<a class="btn btn-danger"
   href="/advert/move/<?php echo $model->id; ?>"><?php echo Yii::t('translations', 'Переместить в архив') ?></a>
<hr>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
    <input type="hidden" name="type" value="only_name">
    <div class="row">
        <?php echo $form->textField($model, 'name', array('placeholder' => Yii::t('translations', 'Название объявления'), 'maxlength' => 30, 'size' => 39)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Обновить название объявления'), array('class' => 'btn btn-default')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<hr>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <input type="hidden" name="type" value="only_status">

    <div class="row">
        <?php
        echo CHtml::radioButton('Adverts[displayed]', $model->displayed ? true : false, array('value' => 1)) . ' ' . Yii::t('translations', 'Запущено') . '&emsp;';
        echo CHtml::radioButton('Adverts[displayed]', !$model->displayed ? true : false, array('value' => 0)) . ' ' . Yii::t('translations', 'Приостановлено') . '&emsp;';
        ?>

        <?php echo $form->error($model, 'displayed'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Обновить статус объявления'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<hr>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
    <input type="hidden" name="type" value="convert">

    <div class="row">
        <select name="Adverts[type]" id="Adverts_type"
                data-placeholder="<?php echo Yii::t('translations', 'Позиция объявления'); ?>"
                style="height:55px; width: 250px;" class="chosen-select" tabindex="8">
            <?php
            if ($model->type) $s = 'selected'; else $s = '';
            echo '<option value="0">' . Yii::t('translations', 'Позиция: Шапка сайта') . '</option>';
            echo '<option ' . $s . ' value="1">' . Yii::t('translations', 'Позиция: Правая колонка') . '</option>';
            ?>
        </select>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <select name="Adverts[pay_type]" id="Adverts_pay_type"
                data-placeholder="<?php echo Yii::t('translations', 'Тип оплаты'); ?>"
                style="height:55px; width: 250px;" class="chosen-select" tabindex="8">
            <?php
            $clicks = '';
            $views = '';
            $model->pay_type == Adverts::PAY_TYPE_CLICKS ? $clicks = 'selected' : $views = 'selected';
            echo '<option ' . $clicks . ' value="0">' . Yii::t('translations', 'Плата за клики') . '</option>';
            echo '<option ' . $views . ' value="1">' . Yii::t('translations', 'Плата за просмотры') . '</option>';
            ?>
        </select>
        <?php echo $form->error($model, 'pay_type'); ?>
    </div>
    <?php
    switch ($model->pay_type) {
        case Adverts::PAY_TYPE_CLICKS:
            $model->cost == Adverts::POSITION_HEAD ? $model->cost = $model->balance / 5 : $model->cost = $model->balance / 1;
            break;

        case Adverts::PAY_TYPE_VIEWS:
            $model->cost == Adverts::POSITION_HEAD ? $model->cost = $model->balance / 25 * 1000 : $model->cost = $model->balance / 15 * 1000;
            break;
    }
    ?>
    <div class="row">
        <?php echo $form->textField($model, 'ordered', array('placeholder' => Yii::t('translations', 'Количество'), 'maxlength' => 30, 'size' => 39, 'value' => $model->redisRecord->get_balance()*40)); ?>
        <?php echo $form->error($model, 'ordered'); ?>
    </div>

    <div class="row">
        <?php echo Yii::t('translations', 'Стоимость'); ?>: <b><span id='money'>0</span></b>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('translations', 'Создать объявление') : Yii::t('translations', 'Обновить объявление'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<hr>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <input type="hidden" name="type" value="only_banner">
    <div class="row">
        <?php echo '* ' . Yii::t('translations', 'Баннер') ?>
        <?php echo CHtml::activeFileField($model, 'banner_image'); ?>
        <?php echo $form->error($model, 'image'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Обновить баннер объявления'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
