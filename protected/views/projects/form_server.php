<?php

/* @var $server Servers */

if (!empty($model->mods)) {
    $server_mods = HUtils::Parse($model->mods);
    $server_mods_2 = array();
    foreach ($DBmods as $mod) {
        $mod_info['used'] = false;
        $mod_info['info'] = $mod;
        if (in_array($mod->id, $server_mods)) {
            $mod_info['used'] = true;
        }
        $server_mods_2[] = $mod_info;
    }
} else {
    foreach ($DBmods as $mod) {
        $mod_info['used'] = false;
        $mod_info['info'] = $mod;
        $server_mods_2[] = $mod_info;
    }
}

if (!empty($model->type)) {
    $server_types = HUtils::Parse($model->type);
    $server_types_2 = array();
    foreach ($DBtypes as $type) {
        $type_info['used'] = false;
        $type_info['info'] = $type;
        if (in_array($type->id, $server_types)) {
            $type_info['used'] = true;
        }
        $server_types_2[] = $type_info;
    }
} else {
    foreach ($DBtypes as $type) {
        $type_info['used'] = false;
        $type_info['info'] = $type;
        $server_types_2[] = $type_info;
    }
}
?>

<div class="form">

    <?php

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
    )); ?>

    <div class="row">
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255, 'placeholder' => '* ' . Yii::t('translations', 'Название сервера'))); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 255, 'placeholder' => '* ' . Yii::t('translations', 'Описание сервера'))); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <div class="side-by-side clearfix">
            <div>
                <select name="mods[]" data-placeholder="<?php echo Yii::t('translations', 'Моды'); ?>"
                        style="height:50px; width: 375px;" multiple class="chosen-select" tabindex="8">
                    <?php
                    if (!empty($server_mods_2))
                        foreach ($server_mods_2 as $mod) {
                            if ($mod['used'])
                                echo '<option selected value=' . $mod['info']->id . '>' . $mod['info']->title . '</option>';
                            else
                                echo '<option value=' . $mod['info']->id . '>' . $mod['info']->title . '</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="side-by-side clearfix">
            <div>
                <select name="own_client" data-placeholder="<?php echo Yii::t('translations', 'Свой клиент'); ?>"
                        style="height:50px; width: 375px;" class="chosen-select" tabindex="8">
                    <?php
                    if ($model->own_client) $s = 'selected'; else $s = '';

                    echo '<option value="0">' . Yii::t('translations', 'Обычный клиент') . '</option>';
                    echo '<option ' . $s . ' value="1">' . Yii::t('translations', 'Свой клиент') . '</option>';
                    ?>
                </select>
            </div>
        </div>
        <?php echo $form->error($model, 'own_client'); ?>
    </div>

    <div class="row">
        <div class="side-by-side clearfix">
            <div>
                <select name="license" data-placeholder="<?php echo Yii::t('translations', 'Лицензия'); ?>"
                        style="height:50px; width: 375px;" class="chosen-select" tabindex="8">
                    <?php
                    if ($model->license) $s = 'selected'; else $s = '';
                    echo '<option value="0">' . Yii::t('translations', 'Нелицензионная версия') . '</option>';
                    echo '<option ' . $s . ' value="1">' . Yii::t('translations', 'Лицензионная версия') . '</option>';
                    ?>
                </select>
            </div>
        </div>
        <?php echo $form->error($model, 'license'); ?>
    </div>

    <div class="row">
        <div class="side-by-side clearfix">
            <div>
                <select name="Servers[whitelist]" data-placeholder="<?php echo Yii::t('translations', 'Whitelist'); ?>"
                        style="height:50px; width: 375px;" class="chosen-select" tabindex="8">
                    <?php
                    if ($model->whitelist) $s = 'selected'; else $s = '';
                    echo '<option ' . $s . ' value="0"> Whitelist: ' . Yii::t('translations', 'Выключен') . '</option>';
                    echo '<option value="1"> Whitelist: ' . Yii::t('translations', 'Включен') . '</option>';
                    ?>
                </select>
            </div>
        </div>
        <?php echo $form->error($model, 'license'); ?>
    </div>

    <div class="row">
        <div class="side-by-side clearfix">
            <div>
                <select name="type[]" data-placeholder="<?php echo Yii::t('translations', 'Тип сервера'); ?>"
                        style="height:50px; width: 375px;" multiple class="chosen-select" tabindex="8">
                    <?php
                    if (!empty($server_types_2))
                        foreach ($server_types_2 as $type) {
                            if ($type['used'])
                                echo '<option selected value=' . $type['info']->id . '>' . Yii::t('translations', $type['info']->type) . '</option>';
                            else
                                echo '<option value=' . $type['info']->id . '>' . Yii::t('translations', $type['info']->type) . '</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <div class="side-by-side clearfix">
            <div>
                <select name="version" data-placeholder="<?php echo Yii::t('translations', 'Версия'); ?>"
                        style="height:50px; width: 375px;" class="chosen-select" tabindex="8">
                    <?php
                    foreach ($DBversions as $version) {
                        if ($model->version == $version->id)
                            echo '<option selected value=' . $version->id . '>' . $version->version . '</option>';
                        else
                            echo '<option value=' . $version->id . '>' . $version->version . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php echo $form->error($model, 'version'); ?>
    </div>

    <div class="row">
        <?php echo $form->textField($model, 'address', array('size' => 60, 'maxlength' => 255, 'placeholder' => Yii::t('translations', 'Адрес сервера: (пример)') . ': 173.194.70.100:25565')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>

    <div class="row">
        <?php echo $form->textField($model, 'map_url', array('size' => 60, 'maxlength' => 255, 'placeholder' => Yii::t('translations', 'Карта сервера (ссылка)'))); ?>
        <?php echo $form->error($model, 'map_url'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('translations', 'Добавить сервер') : Yii::t('translations', 'Редактировать'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->








