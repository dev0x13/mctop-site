<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет')
);
?>

<div class="bs-example">

    <div class="btn-group btn-group-justified">
        <a href="/cabinet/projects" class="btn btn-primary btn-lg"
           role="button"><?php echo Yii::t('translations', 'Проекты'); ?></a>
        <a href="/images" class="btn btn-primary btn-lg"
           role="button"><?php echo Yii::t('translations', 'Изображения'); ?></a>
        <a href="/tickets" class="btn btn-primary btn-lg"
           role="button"><?php echo Yii::t('translations', 'Тикеты'); ?></a>
        <a href="/advert" class="btn btn-primary btn-lg"
           role="button"><?php echo Yii::t('translations', 'Реклама'); ?></a>
    </div>

    <hr>

    <div class="btn-group btn-group-justified">
        <a href="/cabinet/favoriteserverslist" class="btn btn-primary btn-lg"
           role="button"><span
                class="glyphicon glyphicon-heart glyphicon-"></span> <?php echo Yii::t('translations', 'Избранные серверы'); ?>
        </a>

        <a href="/cabinet/features" class="btn btn-primary btn-lg"
           role="button"><?php echo Yii::t('translations', 'Дополнительные опции'); ?></a>

        <a href="/cabinet/manual" class="btn btn-primary btn-lg"
           role="button"><?php echo Yii::t('translations', 'MCTop.Manual'); ?></a>
    </div>
    <hr>

    <div>
        <?php echo Yii::t('translations', 'Ваш баланс') . ': ' . $bank_account->balance; ?>
        <div style="display: inline;" id="money"></div>
        .
        <br>
        <a class="btn btn-primary btn-lg" href="/cabinet/bank"><?php echo Yii::t('translations', 'Банк'); ?></a>
    </div>

    <div class="btn-group btn-group-justified">
        <a href="/users/settings" class="btn btn-primary btn-lg"
           role="button"><?php echo Yii::t('translations', 'Настройки профиля'); ?></a>
    </div>

</div>
<script>
    function declOfNum(number, titles) {
        cases = [2, 0, 1, 1, 1, 2];
        return titles[ (number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5] ];
    }
    $(function () {
        $("#money").text(declOfNum(Math.round(<?php echo $bank_account->balance?>).toFixed(1), ['<?php echo Yii::t('translations','рубль');?>', '<?php echo Yii::t('translations','рубля');?>', '<?php echo Yii::t('translations','рублей');?>']));
    });
</script>