<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Рекомендуемые серверы')
);
?>

<div class="servers-in-features-recommended">
    <?php
    if (isset($servers)) {
        foreach ($servers as $key => $server)
            $this->renderPartial('_server', array('server' => $server));
    }
    ?>
</div>