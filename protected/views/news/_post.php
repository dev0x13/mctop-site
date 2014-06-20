<div class="news">

    <div class="title">
        <a href="/news/post/<?php echo Yii::app()->language == 'en' ? $post->post : $post->id; ?>"><?php echo $post->title; ?></a>
    </div>

    <div class="date">
        <?php echo Yii::app()->language == 'en' ? $post->original_post->date : $post->date; ?>
    </div>

    <div class="few_words">
        <?php echo $post->few_words; ?>
    </div>


</div>