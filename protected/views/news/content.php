<div class="news-list">
    <?php $this->beginWidget('LazyEntities', array(
        'view' => '_post',
        'entity_name' => 'post',
        'entities' => $news,
    ))?>
    <?php $this->endWidget(); ?>
</div>

<?php
$this->widget('CLinkPager', array(
    'pages' => $pages,
    'maxButtonCount' => 1,
    'cssFile' => '',
));
?>