<?php
/* @var $this ProjectsController */
/* @var $images Images */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Изображения');

$this->breadcrumbs = array(
    Yii::t('translations', 'Изображения'),
);
?>

<a class="btn btn-default" href="/images/add"><?php echo Yii::t('translations', 'Добавить изображение'); ?></a>

<?php
$this->widget('CLinkPager', array(
    'pages' => $pages,
    'maxButtonCount' => 1,
    'cssFile' => '',
));

?>

<div class="image_list">
    <?php $this->beginWidget('LazyEntities', array(
        'view' => '_image',
        'entity_name' => 'image',
        'entities' => $images,
    ))?>
    <?php $this->endWidget(); ?>
</div>

<script>
    $(function () {
        $('input#input').maxlength({
            alwaysShow: true,
            warningClass: "label label-success",
            limitReachedClass: "label label-important"
        });
    });
</script>

<?php
$this->widget('CLinkPager', array(
    'pages' => $pages,
    'maxButtonCount' => 1,
    'cssFile' => '',
));

?>

