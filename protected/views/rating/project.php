<?php /* @var $project Projects */ ?>

<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $project->title
);
?>

<div class="pageTitle"><?php echo CHtml::encode($project['title']) ?></div>

<div class="project">

    <a class="btn btn-primary"
       href="/rating/vote/<?php echo $project->id; ?>"><?php echo Yii::t('translations', 'Голосование'); ?></a>

    <a class="btn btn-primary"
       href="/rating/out/<?php echo $project->id; ?>"><?php echo Yii::t('translations', 'Перейти на сайт'); ?></a>
    <?php if ($project->isProjectHaveGuild()): ?>
        <a class="btn btn-warning"
           href="/projects/guild/<?php echo $project->id; ?>"><?php echo Yii::t('translations', 'Гильдия'); ?></a>
    <?php endif ?>
    <br>
    <?php
    echo Yii::t('translations', 'Страна') . ' : <b>' . Yii::t('translations', Countries::model()->findByPk($project->country)->name) . '</b>';
    ?>
    <div class="description">
        <?php
        if (Yii::app()->language == 'en')
            $english_description = EnglishProject::model()->findByPk($project->id);

        if (isset($english_description)) {
            if (isset($english_description) and Yii::app()->language == 'en')
                echo CHtml::encode($english_description->description);
        } else
            echo CHtml::encode($project['description']);
        ?>
    </div>

    <div class="label"><?php echo Yii::t('translations', 'Сервера проекта') ?></div>

    <div class="servers">
        <?php
        if (!empty($project['servers']))
            foreach ($project['servers'] as $server)
                $this->renderPartial('project_server', array('server' => $server));
        ?>
    </div>

    <?php $this->beginWidget('CommentsWidget', array(
        'entities' => $comments,
        'additional' => $model
    ));
    $this->endWidget();?>

</div>
