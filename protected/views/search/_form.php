<div class="server_title">
    <input type="text" class="form-control" name="server_title"
           placeholder="<?php echo Yii::t('translations', 'Название сервера'); ?>" value="">
</div>
<hr>

<div class="row">
    <div class="label"><?php echo Yii::t('translations', 'Страна'); ?></div>
    <?php
    foreach ($countries as $country)
        echo CHtml::radioButton('country', false, array('value' => 'c' . $country->id)) . ' ' . Yii::t('translations', $country->name) . '&emsp;';
    echo CHtml::radioButton('country', true, array('value' => 'all')) . ' ' . Yii::t('translations', 'Все') . '&emsp;';
    ?>
    <hr>
    <div class="label"><?php echo Yii::t('translations', 'Версия'); ?></div>
    <?php
    foreach ($versions as $version)
        echo CHtml::radioButton('version', false, array('value' => 'v' . $version->id)) . ' ' . Yii::t('translations', $version->version) . '&emsp;';
    echo CHtml::radioButton('version', true, array('value' => 'all')) . ' ' . Yii::t('translations', 'Все') . '&emsp;';

    ?>
    <hr>
    <div class="label"><?php echo Yii::t('translations', 'Моды'); ?></div>
    <?php
    foreach ($mods as $mod)
        echo CHtml::CheckBox('m' . $mod->id, false, array('value' => $mod->id)) . ' ' . Yii::t('translations', $mod->title) . '&emsp;';
    ?>
    <hr>
    <div class="label"><?php echo Yii::t('translations', 'Средний онлайн'); ?></div>
    <p>
        <span id="amount"></span>
        <input name="players" id="players" type="hidden" value="test"/>
    </p>

    <div class="search_slider">
        <div id="slider-online"></div>
    </div>

    <hr>

    <div class="label"><?php echo Yii::t('translations', 'Типы'); ?></div>
    <?
    foreach ($types as $type)
        echo CHtml::CheckBox('t' . $type->id, false, array('value' => $type->id)) . ' ' . Yii::t('translations', $type->type) . '&emsp;';
    ?>

    <hr>
    <div class="label"><?php echo Yii::t('translations', 'Тип лицензии'); ?></div>
    <?php
    echo CHtml::radioButton('license', false, array('value' => '1')) . ' ' . Yii::t('translations', 'Лицензионная версия') . '&emsp;';
    echo CHtml::radioButton('license', false, array('value' => '0')) . ' ' . Yii::t('translations', 'Пиратская версия') . '&emsp;';
    echo CHtml::radioButton('license', true, array('value' => 'all')) . ' ' . Yii::t('translations', 'Все') . '&emsp;';
    ?>
    <hr>
    <div class="label"><?php echo Yii::t('translations', 'Whitelist'); ?></div>
    <?php
    echo CHtml::radioButton('whitelist', false, array('value' => '1')) . ' ' . Yii::t('translations', 'Включен') . '&emsp;';
    echo CHtml::radioButton('whitelist', false, array('value' => '0')) . ' ' . Yii::t('translations', 'Выключен') . '&emsp;';
    echo CHtml::radioButton('whitelist', 1, array('value' => 'all')) . ' ' . Yii::t('translations', 'Все') . '&emsp;';
    ?>

</div>

<script>
    $(function () {
        $("#slider-online").slider({
            range: true,
            min: 0,
            max: 200,
            values: [ 0, 200 ],
            slide: function (event, ui) {
                $("#amount").text(ui.values[ 0 ] + " - " + ui.values[ 1 ]);
                $("#players").val(ui.values[0] + "|" + ui.values[1]);
            }
        });
        $("#amount").text($("#slider-online").slider("values", 0) +
            " - " + $("#slider-online").slider("values", 1));
        $("#players").val("0|100");
    });
</script>
