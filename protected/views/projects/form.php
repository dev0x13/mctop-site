<?php /* @var $form CActiveForm */ ?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data')
    )); ?>

    <?php echo $form->label($model, 'having_site'); ?><br>

    <div class="row">
        <?php echo $form->dropDownList($model, 'having_site', $model->getProjectRegisterTypes(), array('id' => 'having_site', 'class' => 'chosen-select', 'style' => 'width:375px;', 'title' => 'test')); ?>
    </div>


    <div class="row">
        <?php echo $form->textField($model, 'title', array('id' => 'title', 'class' => 'form-control', 'size' => 60, 'maxlength' => 64, 'placeholder' => '* ' . Yii::t('translations', 'Название проекта'))); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->textField($model, 'description', array('id' => 'description', 'class' => 'form-control', 'size' => 60, 'maxlength' => 255, 'placeholder' => '* ' . Yii::t('translations', 'Описание'))); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <?php if (!$model->isNewRecord): ?>
        <div class="row">
            <?php echo $form->dropDownList($model, 'give_bonuses', $model->getBonusesOptions(), array('id' => 'give_bonuses', 'class' => 'chosen-select', 'style' => 'width:375px;')); ?>
        </div>

        <div id="script_settings" style="display: none; margin-top: 10px; margin-bottom: 10px;">

            <div class="row">
                <?php echo $form->textField($model, 'script_url', array('id' => 'site', 'size' => 60, 'class' => 'form-control', 'maxlength' => 64, 'placeholder' => '* ' . Yii::t('translations', 'Адрес скрипта'))); ?>
                <?php echo $form->error($model, 'script_url'); ?>
            </div>

            <div class="row">
                <?php echo $form->textField($model, 'secret_key', array('id' => 'site', 'size' => 60, 'class' => 'form-control', 'maxlength' => 64, 'placeholder' => '* ' . Yii::t('translations', 'Секретное слово'))); ?>
                <?php echo $form->error($model, 'secret_key'); ?>
            </div>
        </div>
    <?php endif ?>

    <div class="row">
        <?php echo $form->dropDownList($model, 'banner_clickable', $model->getBannerClickabilityOptions(), array('id' => 'banner_clickable', 'class' => 'chosen-select', 'style' => 'width:375px;')); ?>
    </div>

    <div class="row">
        <?php echo $form->textField($model, 'site', array('id' => 'site', 'size' => 60, 'class' => 'form-control', 'maxlength' => 64, 'placeholder' => '* ' . Yii::t('translations', 'Сайт проекта'))); ?>
        <?php echo $form->error($model, 'site'); ?>
    </div>

    <div class="row">
        <div class="side-by-side clearfix">
            <div>
                <select name="country" id="country" data-placeholder="<?php echo Yii::t('translations', 'Страна'); ?>"
                        style="height:50px; width: 375px;" class="chosen-select" tabindex="8">
                    <?php
                    foreach ($countries as $country) {
                        if ($model->country == $country->id)
                            echo '<option selected value=' . $country->id . '>' . Yii::t('translations', $country->name) . '</option>';
                        else
                            echo '<option value=' . $country->id . '>' . Yii::t('translations', $country->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php echo $form->error($model, 'version'); ?>
    </div>

    <style>
        div.file_upload:before {
            content: '<?php echo Yii::t('translations','Баннер');?>';
        }
    </style>
    <div class="row">
        <div class="file_upload">

            <?php echo CHtml::activeFileField($model, 'banner_image', array('class' => 'file_upload')); ?>
            <?php echo $form->error($model, 'banner'); ?>
        </div>
    </div>

    <hr>

    <div class="row">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('translations', 'Добавить проект') : Yii::t('translations', 'Обновить проект'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


<script>
    $(function () {
        //option_description
        $("input[type='text']").maxlength({
            alwaysShow: true,
            warningClass: "label label-success",
            limitReachedClass: "label label-important"
        });
        $("#country").maxlength({
            //
        });
    });
</script>

<script>
    $(document).ready(function () {
        checkHavingSiteField();
        $('#having_site').on('change', function () {
            checkHavingSiteField();
        });
    });

    function checkHavingSiteField() {
        if ($('#having_site').val() == 1)
            $('#site').show(500);
        else
            $('#site').hide(500);
    }
</script>