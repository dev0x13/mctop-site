<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Проекты');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты'),
);
?>

<div class="bs-example">
    <div class="btn-group btn-group-justified">
        <a href="/cabinet/projects/add" class="btn"><?php echo Yii::t('translations', 'Добавить проект'); ?></a>
    </div>
    <div class="project_list">
        <?php
        if (!empty($projects)) {
            foreach ($projects as $project) {
                $this->renderPartial('_project', array(
                    'project' => $project,
                ));
            }
        }
        ?>
    </div>
</div>
