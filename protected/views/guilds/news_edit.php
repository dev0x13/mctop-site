<?php
/* @var $this ProjectsController */
$this->pageTitle .= ' - ' . $guild->name;

$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $guild->p->title => array('/rating/project/' . $guild->p->id),
    $guild->name => array('/guilds/' . $guild->pid),
    Yii::t('translations', 'Новости') => array('/guilds/' . $guild->pid . '/news'),
    Yii::t('translations', 'Обновление новости'),

);
?>

<h1><?php echo Yii::t('translations', 'Обновление новости') ?></h1>
<?php $this->renderPartial('_form', array(
    'model' => $model
))?>

