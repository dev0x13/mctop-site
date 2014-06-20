<?php /* @var $project Projects */ ?>
<div class="server">

    <div class="title">
        <a href="/rating/server/<?php echo $server->id; ?>"><?php echo $server->title; ?></a>
    </div>
    <div class="buttons">
        <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_edit')): ?>
            <a class="btn btn-primary mctbtn_tight"
               href="/projects/editserver/<?php echo $server->id ?>"><?php echo Yii::t('translations', 'Редактировать'); ?></a>
        <?php endif; ?>
        <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_edit')): ?>
            <?php if (Yii::app()->language != 'en'): ?>
                <a class="btn btn-primary mctbtn_tight"
                   href="/projects/editserver_english/<?php echo $server->id ?>"><?php echo Yii::t('translations', 'English'); ?></a>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_delete')): ?>
            <a class="btn btn-danger mctbtn_tight"
               href="/projects/delserver/<?php echo $server->id ?>"><?php echo Yii::t('translations', 'Удалить'); ?></a>
        <?php endif; ?>
    </div>

</div>