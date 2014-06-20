<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Избранные серверы')
);
?>

<div class="servers-in-features-recommended">
    <ol>
        <?php
        if (isset($servers))
            foreach ($servers as $key => $server)
                $this->renderPartial('_server_favorite', array('server' => Servers::model()->findByPk($server->id)));
        ?>
    </ol>
</div>