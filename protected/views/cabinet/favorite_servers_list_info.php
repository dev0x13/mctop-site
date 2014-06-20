<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    '' . Yii::t('translations', 'Избранные серверы')
);
?>
<?php echo Yii::t('translations', 'Вы еще не добавили не один сервер в избранные'); ?>
    <hr>

    <span class="glyphicon glyphicon-heart glyphicon-"></span>
    <b><?php echo Yii::t('translations', 'Избранные серверы') ?></b> - <?php echo Yii::t('translations', 'Сервис закладок на MCTop, в котором Вы можете хранить быстрые ссылки на сервера') ?>