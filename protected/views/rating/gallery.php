<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/south-street/jquery-ui.css"
      id="theme">
<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">

<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $server->project0->title => array('/rating/project/' . $server->project0->id),
    $server->title => array('/rating/server/' . $server->id),
    Yii::t('translations', 'Галерея')
);
?>

<!-- The dialog widget -->
<div id="blueimp-gallery-dialog" data-show="fade" data-hide="fade">
    <!-- The gallery widget  -->
    <div class="blueimp-gallery blueimp-gallery-carousel blueimp-gallery-controls">
        <div class="slides"></div>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="play-pause"></a>
    </div>
</div>

<div class="server_gallery">
    <div id="links">
        <?php $this->beginWidget('LazyEntities', array(
            'view' => '_image_in_gallery',
            'entity_name' => 'image',
            'entities' => $images,
            'additional' => sizeof($images),
        ))?>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php
$this->beginWidget('CommentsWidget', array(
    'entities' => $comments,
    'additional' => $model
));
$this->endWidget();?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="/static/js/jquery.image-gallery.min.js"></script>

