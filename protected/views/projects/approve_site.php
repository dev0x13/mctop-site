<?php
/* @var $this ProjectsController */
/* @var $project Projects */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Редактирование проекта');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    $project->title => array('/cabinet/projects/view/' . $project->id),
    Yii::t('translations', 'Подтверждение сайта проекта')
);
?>


<div class="pageTitle"><?php echo Yii::t('translations', 'Подтверждение сайта проекта') ?></div>

<?php echo Yii::t('translations', 'Для подтверждения владения сайтом Вам необходимо поместить :link текст в корень своего сайта, в файл с названием leo.html,  и нажать кнопку <b>проверить</b>, находящуюся на данной странице', array(':link' => '<a target="_blank" href="' . Yii::app()->params['site_url'] . 'cabinet/projects/approve_site_file/' . $project->id . '">' . Yii::t('translations', 'данный') . '</a>')) ?>
<br>
<br>
<?php echo Yii::t('translations', 'Другими словами, файл должен находиться по адресу: :link', array(':link' => $project->site)) ?>/leo.html
<hr>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array()); ?>
    <?php echo $form->error($project, 'site'); ?>
    <input class="btn" type="submit" value="<?php echo Yii::t('translations', 'Подтвердить') ?>"/>

    <? $this->endWidget(); ?>

</div>