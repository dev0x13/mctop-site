<?php
/* @var $this ProjectsController */
/* @var $guild Guilds */
$this->pageTitle .= ' - ' . $guild->name;

$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $guild->p->title => array('/rating/project/' . $guild->p->id),
    $guild->name => array('/guilds/' . $guild->pid),
    Yii::t('translations', 'Новости')
);
?>

<h1><?php echo Yii::t('translations', 'Новости') ?></h1>
<?php if ($guild->checkUserRights(Yii::app()->user->id, 'guild_news_manage')): ?>
    <a class="btn btn-primary"
       href="/projects/guild/<?php echo $guild->pid; ?>/news/create"><?php echo Yii::t('translations', 'Добавить новость'); ?></a>
<?php endif; ?>
<hr>
<div class="news-list">
    <?php
    foreach ($news as $post) {
        $this->renderPartial('_post', array(
            'post' => $post,
            'project' => $project,
            'guild' => $guild,
        ));
    }
    ?>
</div>
