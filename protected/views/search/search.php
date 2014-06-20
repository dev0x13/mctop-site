<?php
/* @var $this SearchController */
/* @var $mod ServersMods */
/* @var $type ServersTypes */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Поиск');

$this->breadcrumbs = array(
    Yii::t('translations', 'Поиск') => array('/search'),
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
            'mods' => $mods,
            'versions' => $versions,
            'countries' => $countries_search,
            'types' => $types
        ))?>

        <div class="search-results" id="output"></div>
        <br>

        <div class="row">
            <?php
            echo CHtml::ajaxSubmitButton(Yii::t('translations', 'Искать'), '', array(
                    'type' => 'POST',
                    'update' => '#output',
                ),
                array(
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>

</div>