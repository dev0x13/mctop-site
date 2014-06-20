<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Проекты');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты'),
);
?>

По нашим новым правилам, после одобрения проекта, мы собираем информацию о нем в течении 1 дня после одобрения.<br><br>
Таким образом, проект будет участвовать в рейтинге через 1 день.<br><br>

<a class="btn" href="/projects">Осознал</a>