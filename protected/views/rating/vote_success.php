<?php /* @var $project Projects */ ?>

<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $project->title => array('/rating/project/' . $project->id),
    Yii::t('translations', 'Голосование за проект {name}', array('{name}' => CHtml::encode($project['title'])))
);
?>

<div
    class="pageTitle"><?php echo Yii::t('translations', 'Голосование за проект {name}', array('{name}' => CHtml::encode($project['title']))); ?></div>

<div class="project form">

    <?php echo Yii::t('translations', 'Времени до повторного голосования'); ?>:
    <div id="time" style="display: inline;">
        <?php if ($time->h != 0): ?>
            <?php echo Yii::t('translations', '{n} часа |{n} часа | {n} часов', $time->h); ?>
        <?php endif ?>
        <?php echo Yii::t('translations', '{n} минута |{n} минуты | {n} минут', $time->i); ?>
        <?php echo Yii::t('translations', '{n} секунда |{n} секунды | {n} секунд', $time->s); ?>
    </div>
    <br>
    <br>

    <?php echo Yii::t('translations', 'Ваш голос был учтен!<br><br>Повторное голосование доступно после 00:00 по Москве'); ?>


</div>
