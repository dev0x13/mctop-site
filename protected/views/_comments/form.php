<?php if (Yii::app()->user->isGuest): ?>
    <hr>
    <div
        class="alert alert-info"><?php echo Yii::t('translations', 'Комментарии могут оставлять только :авторизованные пользователи', array(':авторизованные' => '<a href="/s/login">' . Yii::t('translations', 'авторизованные') . '</a>')); ?></div>
    <hr>
<?php endif; ?>

<?php if (!Yii::app()->user->isGuest): ?>
    <div class="form perspective">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'comments-t-form',
            'enableAjaxValidation' => false,
        )); ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="form-group">
            <?php echo $form->textField($model, 'comment', array('size' => 90)); ?>
            <?php echo $form->hiddenField($model, 'parent', array('value' => '0')); ?>
            <?php echo $form->error($model, 'comment'); ?>
        </div>

        <div class="form-group buttons">
            <?php echo CHtml::submitButton(Yii::t('translations', 'Отправить'), array('class' => 'btn mctbtn_black mctbtn_normal')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->

    <script>
        function answerTo(id, name) {
            $("#Comments_parent").val(id);
            if ($("#Comments_comment").val() == "")
                $("#Comments_comment").val(name + ", ");
            document.getElementById('Comments_comment').focus()
        }
    </script>

<?php endif ?>