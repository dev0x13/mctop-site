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
                    id='author<?php echo $comment->author->id; ?>'><?php echo CHtml::encode($comment->author->name.' '.$comment->author->surname); ?></span></a></b>:
        <?php if ($source != null): ?>
            <?php echo Yii::t('translations', 'ответил') ?> <a
                href="/users/profile/<?php echo $source->author->id; ?>"><?php echo $source->author->login; ?></a>:
        <?php endif; ?>

    </div>

    <div class="content">
         <?php echo CHtml::encode($comment->comment); ?>
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
