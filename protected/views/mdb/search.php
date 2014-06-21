<?php /* @var $mod Mdb */ ?>

<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'MDB Wiki') => array('/wiki'),
    Yii::t('translations', 'Поиск по названию')
);
?>

<div class="pageTitle"><?php echo Yii::t('translations', 'Поиск по названию') ?></div>

<div class="mdb">

    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'events-form',
        ));
        ?>

        <input type="text" class="form-control" name="title"
               placeholder="<?php echo Yii::t('translations', 'Название мода или плагина'); ?>" value="">

        <div class="mdb-search-results" id="output"></div>
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
