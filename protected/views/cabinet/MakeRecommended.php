<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Дополнительные опции') => array('/cabinet/features/'),
    Yii::t('translations', 'Сделать рекомендованным') . ' ' . Yii::t('translations', 'сервер') . ' ' . $server->title
);
?>


<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
    )); ?>

    <?php
    echo Yii::t('translations', 'Эта операция может позволить переместить Ваш сервер <b>:server</b> в рекомендуемые<br><br>Для того, чтобы сервер попал в список, Вы должны оплатить время, которое там будет находиться сервер: 1 день, 1 неделя, 1 месяц.<br><br>После того, как Ваш сервер пройдет одобрение от нас, вы сможете оплатить его внесение в список.', array(':server' => $server->title));
    ?>
    <hr>
    <div class="">
        <input name="option_period" type="radio"
               value="one_day"> <?php echo Yii::t('translations', 'Один день') ?></input><br>
        <input name="option_period" type="radio"
               value="one_week"> <?php echo Yii::t('translations', 'Одну неделю') ?></input><br>
        <input name="option_period" type="radio"
               value="one_month"> <?php echo Yii::t('translations', 'Один месяц') ?></input>
    </div>

    <?php
    echo $form->error($server, 'error');
    ?>

    <div class="row">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Отправить запрос'), array('class' => 'btn btn-default')); ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->

