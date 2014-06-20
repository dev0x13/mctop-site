<?php /* @var $project Projects */ ?>

<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $project->title
);
?>

<div class="pageTitle"><?php echo CHtml::encode($project['title']) ?></div>

<div class="project">

    <div class="description">
        <?php echo CHtml::encode($project['description']) ?>
    </div>

    <div class="vote_button">
        <a class="btn btn-success"
           href="/rating/vote/<?php echo $project->id ?>"><?php echo Yii::t('translations', 'Голосование'); ?></a>
    </div>

    <div class="label"><?php echo Yii::t('translations', 'Сервера проекта') ?></div>


    <div class="servers">
        <?php
        if (!empty($project['servers']))
            foreach ($project['servers'] as $server)
                $this->renderPartial('project_server', array('server' => $server));
        ?>
    </div>

</div>