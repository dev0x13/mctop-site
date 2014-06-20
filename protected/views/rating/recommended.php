<?php /* @var $server Servers */ ?>

<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    Yii::t('translations', 'Рекомендуемые серверы'),
);
?>

<div class="recommended-rating-list">
    <?php
    if (!empty($servers))
        foreach ($servers as $server)
            $this->renderPartial('_recommended', array('server' => $server, 'countries' => $countries));
    else
        if (!Yii::app()->user->isGuest)
            echo Yii::t('translations', 'В данный момент нет рекомендованных серверов. <br><br> Вы можете приобрести место здесь, воспользовавшись следующей ссылкой: <br><a class="btn" href="/cabinet/features">Дополнительный функционал Личного Кабинета</a>');
    ?>
</div>

