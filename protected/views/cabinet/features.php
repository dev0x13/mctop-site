<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Дополнительные опции')
);
?>

<p>
<h2><b><a class="btn"
          href="/cabinet/recommendedservers"><?php echo Yii::t('translations', 'Рекомендуемые серверы') ?></a></b></h2>
<?php echo Yii::t('translations', 'Вы можете приобрести волшебное место у нас под крылышком - на странице рекомендованных серверов') ?>
</p>
<hr>
<div class="servers-in-features-recommended">
    <?php
    if (isset($servers)) {
        foreach ($servers as $key => $server)
            $this->renderPartial('_server', array('server' => $server));
    }
    ?>
</div>