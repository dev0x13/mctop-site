<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle .= ' - Импортирование проекта и серверов с MCTop.su';

?>

<div class="pageTitle">Импортирование проекта и серверов с MCTop.su</div>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data')
    )); ?>

    <?php

    $this->renderPartial('_project', array(
        'form' => $form,
        'model' => $project,
        'countries' => Countries::model()->findAll()
    ));
    ?>
    <input class="btn" type="submit" value="Продолжить"/>

    <?php $this->endWidget(); ?>
</div>
