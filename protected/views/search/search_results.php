<?php
/* @var $this SearchController */
/* @var $mod ServersMods */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Поиск');

$this->breadcrumbs = array(
    Yii::t('translations', 'Поиск') => array('/search'),
    Yii::t('translations', 'Результаты')
);
?>
<div class="search">

    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'events-form',
        )); ?>

        <input type="hidden" name="go" value="go"/>

        <?php $this->renderPartial('_form', array(
            'online' => $online,
            'mods' => $mods,
            'versions' => $versions,
            'countries' => $countries_search,
            'types' => $types,
            'selected' => $selected,
            'server_title' => $server_title
        ))?>

        <div class="row">
            <?php echo CHtml::submitButton(Yii::t('translations', 'Искать'), array('class' => 'btn btn-primary')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>

    <div class="search-results">
        <?php
        echo '<hr>';
        if (!empty($servers))
            foreach ($servers as $server)
                $this->renderPartial('_server', array('server' => $server, 'countries' => $countries));
        else
            echo Yii::t('translations', 'По заданным параметрам сервера не найдены');
        ?>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>

    <?php
    $this->widget('CLinkPager', array(
        'header' => '<hr>',
        'pages' => $pages,
        'maxButtonCount' => 1,
        'cssFile' => '',
    ));

    ?>
</div>