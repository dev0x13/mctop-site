<?php /* @var $mod Mdb */ ?>

<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'MDB Wiki') => array('/wiki'),
);
?>

<div class="pageTitle"><?php echo Yii::t('translations', 'MDB Wiki'); ?></div>

<div class="mdb">

    <div class="about">
        <?php echo Yii::t('translations', 'MDB Wiki - база данных, в которой вы можете найти различную информацию о модах и плагинах, установленных на серверах'); ?>
    </div>

    <hr>
    <a href="/wiki/plugins/list" class="btn"><?php echo Yii::t('translations', 'Плагины') ?></a>

    <hr>
    <a href="/wiki/mods/list" class="btn"><?php echo Yii::t('translations', 'Моды') ?></a>

    <hr>
    <a href="/wiki/search" class="btn"><?php echo Yii::t('translations', 'Поиск по названию') ?></a>

    <hr>
    <a href="/wiki/searchbycommand" class="btn"><?php echo Yii::t('translations', 'Поиск по команде') ?></a>

</div>
