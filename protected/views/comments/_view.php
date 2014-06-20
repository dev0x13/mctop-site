<?php
/* @var $this CommentsController */
/* @var $data Comments */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('user')); ?>:</b>
    <?php echo CHtml::encode($data->user); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
    <?php echo CHtml::encode($data->comment); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('module')); ?>:</b>
    <?php echo CHtml::encode($data->module); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('entity_id')); ?>:</b>
    <?php echo CHtml::encode($data->entity_id); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
    <?php echo CHtml::encode($data->time); ?>
    <br/>


</div>