<div class="<?php echo ($message->author == Yii::app()->user->id) ? 'user_answer' : 'helper_answer'; ?>">

    <div class="author">
        <?php echo ($message->author == Yii::app()->user->id) ? $user_name : Yii::t('translations', 'Агент поддержки'); ?>
    </div>

    <div class="time">
        <?php echo $message->time; ?>
    </div>

    <div class="text">
        <?php echo $message->message; ?>
    </div>

</div>