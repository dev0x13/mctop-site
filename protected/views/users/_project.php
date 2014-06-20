<div class="user_project">
    <a href="/rating/project/<?php echo $project->id; ?>"><?php echo $project->title; ?></a>
    (<?php echo Roles::getRolesInString(ProjectsRoles::getUserRoleInProject($user, $project->id)->role); ?>)
</div>