<?php
/* @var $this ProjectsController */
/* @var $project Projects */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Редактирование проекта');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    $project->title => array('/cabinet/projects/view/' . $project->id),
    Yii::t('translations', 'Кабинет финансового менеджера')
);
?>

<?php

?>

<a class="btn"
   href="/advert/create/project/<?php echo $project->id ?>"><?php echo Yii::t('translations', 'Заказать рекламу для проекта') ?></a>