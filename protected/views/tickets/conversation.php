<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Тикеты') => array('/tickets'),
    $ticket->name,
);
?>

<?php if ($ticket->status != TicketsTopics::STATUS_CLOSED): ?>

    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'events-form',
        )); ?>

        <input type="hidden" name="close"/>

        <div class="row">
            <?php echo CHtml::submitButton(Yii::t('translations', 'Закрыть тикет'), array('class' => 'btn btn-default')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->

    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'events-form',
        )); ?>

        <div class="row">
            <?php echo $form->textArea($model, 'message', array('id' => 'title', 'size' => 60, 'maxlength' => 64, 'placeholder' => '* ' . Yii::t('translations', 'Сообщение'), 'class' => 'form-control', 'rows' => '3')); ?>
            <?php echo $form->error($model, 'message'); ?>
        </div>


        <div class="row">
            <?php echo CHtml::submitButton(Yii::t('translations', 'Отправить'), array('class' => 'btn btn-default')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
<?php endif; ?>


<?php
$this->widget('CLinkPager', array(
    'pages' => $pages,
    'maxButtonCount' => 1,
    'cssFile' => '',
));

?>

    <div class="conversation_list">
        <?php

        foreach ($messages as $message) {
            $this->renderPartial('_message', array(
                'message' => $message,
                'user_name' => $user->name . ' ' . $user->surname
            ));
        }

        ?>
    </div>

<?php
$this->widget('CLinkPager', array(
    'pages' => $pages,
    'maxButtonCount' => 1,
    'cssFile' => '',
));

?>