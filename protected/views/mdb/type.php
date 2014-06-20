<?php /* @var $mod Mdb */ ?>

<?php

$title = $id == Mdb::TYPE_PLUGIN ? Yii::t('translations', 'Плагины') : Yii::t('translations', 'Моды');
$this->breadcrumbs = array(
    Yii::t('translations', 'Мдб Вики') => array('/wiki'),
    Yii::t('translations', $title)
);

?>

<div class="pageTitle"><?php echo $title ?></div>

<div class="mdb">

    <div class="mdb-search-results" id="output">

        <?php $this->beginWidget('LazyEntities', array(
            'view' => '_result',
            'entity_name' => 'result',
            'entities' => $content,
        ))?>
        <?php $this->endWidget(); ?>
    </div>

    <?php
    if (isset($pages)) {
        $this->widget('CLinkPager', array(
            'pages' => $pages,
            'maxButtonCount' => 1,
            'cssFile' => '',
        ));

    }
    ?>

</div>