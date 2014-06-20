<?php
/* @var $this ProjectsController */
$this->pageTitle .= ' - ' . $guild->name;

$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $guild->p->title => array('/rating/project/' . $guild->p->id),
    $guild->name => array('/guilds/' . $guild->pid),
    Yii::t('translations', 'Новости') => array('/guilds/' . $guild->pid . '/news'),
    Yii::t('translations', 'Новости с тегом :tag', array(':tag' => CHtml::encode($_GET['tag']))),
);
?>

<h1><?php echo Yii::t('translations', 'Новости') ?></h1>
<?php if ($project->checkUserRights(Yii::app()->user->id, 'project_guild_founder')): ?>
    <a class="btn btn-primary"
       href="/projects/guild/<?php echo $guild->pid; ?>/news/create"><?php echo Yii::t('translations', 'Добавить новость'); ?></a>
<?php endif; ?>
<hr>
<div class="news-list">
    <?php

    if (!empty($news))
        foreach ($news as $post) {
            $this->renderPartial('_post', array(
                'post' => $post,
                'project' => $project,
                'guild' => $guild,
            ));
        }
    else
        echo Yii::t('translations', 'Новости с тегом <b>:tag</b> не найдены', array(':tag' => $_GET['tag']));
    ?>
</div>

