<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/projects'),
    $server->s->project0->title => array('/cabinet/projects/' . $server->s->project0->id . '/'),
    $server->s->title => array('/cabinet/projects/editserver/' . $server->s->id . '/'),
    Yii::t('translations', 'Дополнительные опции') => array('/cabinet/features/'),
    Yii::t('translations', 'Сделать рекомендованным'),
);
?>

<?php echo Yii::t('translations', 'Платеж прошел успешно!'); ?>