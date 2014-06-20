<?php
/* @var $this GuildsController */
/* @var $guild Guilds */
$this->pageTitle .= ' - ' . $guild->name;

$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $project->title => array('/rating/project/' . $project->id),
    $guild->name
);
?>

<?php if ($guild->checkUserRights(Yii::app()->user->id, 'project_guild_founder')): ?>
    <a class="btn btn-primary mctbtn_normal"
       href="/guilds/<?php echo $guild->pid; ?>/roles"><?php echo Yii::t('translations', 'Назначение ролей'); ?></a>
    <a class="btn btn-primary mctbtn_normal"
       href="/guilds/edit/<?php echo $guild->pid; ?>"><?php echo Yii::t('translations', 'Обновить'); ?></a>
<?php endif; ?>

<a class="btn btn-primary mctbtn_normal"
   href="/guilds/<?php echo !is_null(GuildsMembers::model()->checkExistingInGuild(Yii::app()->user->id, $guild->pid)->uid) ? 'leave' : 'join' ?>/<?php echo $guild->pid; ?>"><?php echo !is_null(GuildsMembers::model()->checkExistingInGuild(Yii::app()->user->id, $guild->pid)->uid) ? Yii::t('translations', 'Выйти из гильдии') : Yii::t('translations', 'Присоединиться'); ?></a>


<h1><?php echo $guild->name; ?></h1>

<?php echo Yii::t('translations', 'Сообщение дня') . ' : ' . $guild->motd; ?>
<hr>

<div class="btn-group btn-group-justified">
    <a href="/guilds/<?php echo $guild->pid ?>/news" class="btn btn-primary btn-lg"
       role="button"><?php echo Yii::t('translations', 'Новости'); ?></a>
    <?php /*<a href="/guilds/<?php echo $guild->pid?>/achievements" class="btn btn-primary btn-lg"
       role="button"><?php echo Yii::t('translations', 'Достижения'); ?></a>*/
    ?>
    <a href="/guilds/<?php echo $guild->pid ?>/members" class="btn btn-primary btn-lg"
       role="button"><?php echo Yii::t('translations', 'Участники'); ?></a>
</div>