<?php
/* @var $this ProjectsController */
$tags = HUtils::Parse($post->tags);
$this->pageTitle .= ' - ' . Yii::t('translations', 'Новости');

$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/projects'),
    $guild->name => array('projects/guild/' . $guild->pid),
    Yii::t('translations', 'Новости') => array('projects/guild/' . $guild->pid . '/news'),
    $post->name
);
?>
<div class="post">

    <div class="title">
        <?php echo $post->name; ?>
    </div>

    <div class="date">
        <?php echo $post->date; ?>
    </div>

    <div class="full">
        <?php echo $post->text; ?>
    </div>

    <?php if (sizeof($tags) > 0): ?>
        <hr>
        <div class="tags">
            <span class="glyphicon glyphicon-tags"></span>
            <?php $this->beginWidget('LazyEntities', array(
                'view' => '_news_tag',
                'entity_name' => 'tag',
                'entities' => $tags,
            ))?>
            <?php $this->endWidget(); ?>
        </div>
    <?php endif; ?>

    <?php $this->beginWidget('CommentsWidget', array(
        'entities' => $comments,
        'additional' => $model
    ));
    $this->endWidget();?>

</div>


