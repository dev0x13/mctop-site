<?php
/* @var $this ProjectsController */
/* @var $project EnglishProjects */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Редактирование проекта');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/projects'),
    $project->title => array('/projects/' . $english_project->project),
    Yii::t('translations', 'Редактирование проекта')
);
?>


<div class="pageTitle"><?php echo Yii::t('translations', 'Редактирование проекта') ?></div>

<?php $this->renderPartial('form_english', array(
    'model' => $english_project
))?>
