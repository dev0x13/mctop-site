<div class="comment perspective">


    <?php
    $source = Comments::model()->findByPk($comment->parent);
    ?>

    <div class="date">
        <?php $date = explode('-', $comment->time); ?>
        <?php echo $date[0] . '.' . $date[1] . '.' . $date[2]; ?>
    </div>


    <div class="author" onclick="javascript:window.location.href='/users/profile/<?php echo $comment->author->id; ?>';">
        <b><a href="/users/profile/<?php echo $comment->author->id; ?>"><span
                    id='author<?php echo $comment->author->id; ?>'><?php echo $comment->author->login; ?></span></a></b>:
        <?php if ($source != null): ?>
            <?php echo Yii::t('translations', 'ответил') ?> <a
                href="/users/profile/<?php echo $source->author->id; ?>"><?php echo $source->author->login; ?></a>:
        <?php endif; ?>

    </div>
    <div class="status" style="display:none;">
        <?php
        if(time()-strtotime($comment->author->last_update)<60*10)
            echo Yii::t('translations','В сети');
        else
            echo Yii::t('translations','Не в сети');
        ;?>
    </div>

    <div class="content">
         <?php echo $comment->comment; ?>
    </div>
    <br>
    <?php if (!Yii::app()->user->isGuest): ?>
        <?php
        echo CHtml::button(Yii::t('translations', 'Ответить'), array(
            'class' => 'btn mctbtn_black mctbtn_tight',
            'onclick' => 'answerTo("' . $comment->id . '", "' . $comment->author->login . '" )'
        ));
        ?>
    <?php endif; ?>

</div>
