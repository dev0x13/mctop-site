<?php
/* @var $post GuildsNews */
/* @var $project Projects */
$tags = HUtils::Parse($post->tags);
?>

<div class="post guild_post"
     onclick="javascript:window.location.href = '/guilds/<?php echo $post->pid; ?>/news/post/<?php echo $post->id; ?>'">
    <div class="title">
        <?php echo $post->name; ?>
    </div>

    <div class="date">
        <?php $date = explode('-', $post->date); ?>
        <?php echo $date[0] . '.' . $date[1] . '.' . $date[2]; ?>
    </div>

    <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_guild_founder')): ?>
        <a class="btn btn-warning"
           href="/projects/guild/<?php echo $post->pid; ?>/news/edit/<?php echo $post->id; ?>"><?php echo Yii::t('translations', 'Обновить'); ?></a>
    <?php endif; ?>

    <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_guild_founder')): ?>
        <a class="btn btn-danger"
           href="/projects/guild/<?php echo $post->pid; ?>/news/delete/<?php echo $post->id; ?>"><?php echo Yii::t('translations', 'Удалить'); ?></a>
    <?php endif; ?>

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
                'additional' => $guild
            ))?>
            <?php $this->endWidget(); ?>
        </div>
    <?php endif; ?>

</div>
