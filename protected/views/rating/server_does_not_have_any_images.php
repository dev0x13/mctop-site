<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $server->project0->title => array('/rating/project/' . $server->project0->id),
    $server->title,
    Yii::t('translations', 'Изображения')
);
?>

<?php echo Yii::t('translations', 'Администрация сервера ещё не добавила изображения.'); ?>

<?php if (isset($comments)): ?>
    <?php $this->beginWidget('CommentsWidget', array(
        'entities' => $comments,
        'additional' => $model
    ));
    $this->endWidget();?>

<?php endif; ?>