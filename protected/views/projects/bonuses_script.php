<?php
/* @var $this ProjectsController */
/* @var $project Projects */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Редактирование проекта');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    $model->title => array('/cabinet/projects/view/' . $model->id),
    Yii::t('translations', 'Настройка скрипта выдачи бонуса')
);
?>

<?php /* @var $form CActiveForm */ ?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <?php if (!$model->isNewRecord): ?>

        <div class="row">
            <?php echo $form->textField($model, 'script_url', array('id' => 'site', 'class' => 'form-control', 'size' => 60, 'maxlength' => 64, 'placeholder' => '* ' . Yii::t('translations', 'Адрес скрипта'))); ?>
            <?php echo $form->error($model, 'script_url'); ?>
        </div>

        <div class="row">
            <?php echo $form->textField($model, 'secret_key', array('id' => 'site', 'class' => 'form-control', 'size' => 60, 'maxlength' => 64, 'placeholder' => '* ' . Yii::t('translations', 'Секретное слово'))); ?>
            <?php echo $form->error($model, 'secret_key'); ?>
        </div>

    <?php endif; ?>

    <?php
    //echo CHtml::textArea('output', $output);
    //uncomment it to see the output
    echo '<hr>';
    echo CHtml::ajaxSubmitButton(Yii::t('translations', 'Проверить'), '/ajax/BonusScriptCheck', array(
            'type' => 'POST',
            'update' => '#output',
            //comment it to see the output
            'success' => 'js:function(data){
                    var json = \'\'+data+\'\',
                        response = JSON.parse(json);

                        var date = new Date();
                        var hours = date.getHours();
                        var minutes = date.getMinutes();
                        var seconds = date.getSeconds();

                        // will display time in 10:30:23 format
                        time = hours + ":" + minutes + ":" + seconds;
                        $( "#result" ).text(time+": "+response.message);
                }'
        ),
        array(
            'type' => 'submit',
            'class' => 'btn mctbtn_tight',
        ));
    ?>

    <div id="result">

    </div>

    <div class="row">
        <?php echo CHtml::submitButton(Yii::t('translations', 'Сохранить изменения'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

