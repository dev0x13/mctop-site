<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Реклама'),
);
?>

<div class="pageTitle"><?php echo Yii::t('translations', 'Реклама') ?></div>

<div class="advert-cp">
    <a class="btn btn-primary" href="/advert/create"><?php echo Yii::t('translations', 'Создать объявление') ?></a>
    <hr>
    <div class="head">
        <div class="row stats_table">
            <div class="col-md-3">
                <div class="title">
                    <?php echo Yii::t('translations', 'Название') ?>
                </div>
            </div>
            <div class="col-md-2"><?php echo Yii::t('translations', 'Статус') ?></div>
            <div class="col-md-1">CTR</div>
            <div class="col-md-2"><?php echo Yii::t('translations', 'Переходы') ?></div>
            <div class="col-md-2"><?php echo Yii::t('translations', 'Показы') ?></div>
            <div class="col-md-2"><?php echo Yii::t('translations', 'Баланс') ?></div>
        </div>
    </div>
    <?php $this->beginWidget('LazyEntities', array(
        'view' => '_advert',
        'entity_name' => 'advert',
        'entities' => $adverts,
    ))?>
    <?php $this->endWidget(); ?>
</div>

<script>

    function declOfNum(number, titles) {
        cases = [2, 0, 1, 1, 1, 2];
        return titles[ (number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5] ];
    }
</script>