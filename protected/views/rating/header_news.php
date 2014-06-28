<?php $this->pageTitle = ' - ' . (Yii::app()->language == 'en') ? $post->title : $post->title; ?>

<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<?php
if (Yii::app()->language == 'en')
    $category = EnglishNewsCategories::model()->findByPk($post->category);
else
    $category = NewsCategories::model()->findByPk($post->category);
?>

<div class="post">

    <div class="title">
        <?php echo (Yii::app()->language == 'en') ? $post->title : $post->title; ?>
        <div class="author">
            <?php echo Yii::t('translations', 'Автор') ?>: <a
                href="/users/profile/<?php echo $post->author; ?>"><?php echo $post->author0->login; ?></a>
            <hr>
            <?php
            if ($post->author == 1)
                echo '<a href="https://plus.google.com/103750166841428082528?rel=author">' . $post->author0->login . ' in Google+</a>';
            ?>
        </div>
        <div class="category">
            <a href="/news/category/<?php echo $post->category; ?>">@<?php echo $category->title; ?></a>
        </div>
    </div>

    <div class="date">
        <?php echo $post->date; ?>
    </div>

    <div class="full">
        <?php echo (Yii::app()->language == 'en') ? $post->full : $post->full; ?>
    </div>


    <?php if (sizeof($tags) > 0): ?>
        <hr>
        <div class="tags">
            <span class="glyphicon glyphicon-tags"></span>
            <?php $this->beginWidget('LazyEntities', array(
                'view' => '_tag',
                'entity_name' => 'tag',
                'entities' => $tags,
            ))?>
            <?php $this->endWidget(); ?>
        </div>
    <?php endif; ?>

    <?php
    /* @var $this CommentsController */
    /* @var $model Comments */
    /* @var $form CActiveForm */
    ?>

    <div class="share_social">
        <!-- Put this script tag to the <head> of your page -->
        <script type="text/javascript" src="//vk.com/js/api/openapi.js?113"></script>

        <script type="text/javascript">
            VK.init({apiId: 4370926, onlyWidgets: true});
        </script>

        <!-- Put this div tag to the place, where the Like block will be -->
        <div id="vk_like"></div>
        <script type="text/javascript">
            VK.Widgets.Like("vk_like", {type: "button"});
        </script>
        <hr>

        <div id="fb-root"></div>

        <div class="fb-like" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
        <script type="text/javascript">(function () {
                if (window.pluso)if (typeof window.pluso.start == "function") return;
                if (window.ifpluso == undefined) {
                    window.ifpluso = 1;
                    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                    s.type = 'text/javascript';
                    s.charset = 'UTF-8';
                    s.async = true;
                    s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://share.pluso.ru/pluso-like.js';
                    var h = d[g]('body')[0];
                    h.appendChild(s);
                }
            })();</script>
        <hr>
        <div class="pluso" data-background="transparent" data-options="medium,square,line,horizontal,counter,theme=04"
             data-services="vkontakte,odnoklassniki,facebook,twitter,google,email,tumblr,print"></div>
    </div>

    <?php $this->beginWidget('CommentsWidget', array(
        'entities' => $comments,
        'additional' => $model
    ));
    $this->endWidget();?>

</div>