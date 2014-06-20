<?php
/* @var $this ProjectsController */
$this->pageTitle .= ' - ' . $guild->name;

$this->breadcrumbs = array(
    $guild->name => array('/guilds/' . $guild->pid),
    Yii::t('translations', 'Участники гильдии')
);
?>

<h1><?php echo Yii::t('translations', 'Участники гильдии') ?></h1>
<?php if ($project->checkUserRights(Yii::app()->user->id, 'project_guild_founder')): ?>
    <a class="btn btn-primary"
       href="/guilds/<?php echo $guild->pid; ?>/roles"><?php echo Yii::t('translations', 'Назначение ролей'); ?></a>
<?php endif; ?>
<hr>
<div class="news-list">
    <?php
    foreach ($members as $member) {
        $this->renderPartial('_member', array(
            'member' => $member->u,
            'role' => $member,
            'project' => $project,
            'guild' => $guild,
        ));
    }
    ?>
</div>
