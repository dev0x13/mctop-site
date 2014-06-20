<?php /* @var $project Projects */ ?>
<a class="btn" href="/cabinet/projects/view/<?php echo $project->id; ?>"><?php echo $project->title; ?></a>

<div class="role">
    <?php echo Yii::t('translations', 'Роль'); ?>
    : <?php echo Roles::getRolesInString(ProjectsRoles::getUserRoleInProject(Yii::app()->user->id, $project->id)->role); ?>
</div>

<?php

$redis = Yii::app()->getComponent('redis')->getClient();
$approve_needles = $redis->get("site_code_for_project_" . $project->id);

if (!empty($approve_needles) and $project->having_site == Projects::HAVING_SITE_YES)
    echo '<b>' . Yii::t('translations', 'Необходимо подтвердить сайт') . '</b>';
else
    $redis->set("site_code_for_project_" . $this->id, md5(time()));
?>

<hr>