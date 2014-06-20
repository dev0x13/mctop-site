<div class="image" id="image_<?php echo $image->id; ?>">

    <?php echo CHtml::form();
    //echo CHtml::textArea('output', $output, array('class'=>'form-control'));

    echo CHtml::ajaxSubmitButton(Yii::t('translations', 'Обновить'), '', array(
            'type' => 'POST',
            'update' => '#output',
            'success' => 'js:function(string){
                $("#status_' . $image->id . '.status").fadeIn( "slow");
                $("#status_' . $image->id . '.status").delay(1000).fadeOut(400);
                $("#input_' . $image->id . '").focusout();
            }'
        ),
        array(
            'type' => 'submit',
            'style' => '-webkit-margin-before: -28px;margin-right:5px;',
            'class' => 'btn btn-success mctbtn_small'
        ));


    echo CHtml::textField('input', $image->name, array('class' => 'name', 'maxlength' => 30, 'id' => 'input_' . $image->id));

    echo '<input type="hidden" name="id" value=' . $image->id . '>';
    ?>
    <div class="status" id="status_<?php echo $image->id; ?>">
        <?php echo Yii::t('translations', 'Изменения сохранены'); ?>
    </div>
    <?php echo CHtml::endForm(); ?>

    <div class="info">
        <?php echo $image->width; ?>x<?php echo $image->height; ?> px
        (<?php echo Images::getImageSize($image->size, 'kb'); ?>)
    </div>

    <div class="picture">
        <img src="/static/uploaded/u<?php echo Yii::app()->user->id; ?>/<?php echo $image->filename; ?>"
             class="img-responsive" alt="Responsive image"/>
    </div>

    <div class="button">
        <div class="bs-example">
            <nav id="navbar-example" class="navbar navbar-default navbar-static" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse"
                                data-target=".bs-example-js-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><?php echo $image->name; ?></a>
                    </div>
                    <div class="collapse navbar-collapse bs-example-js-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php

                            if ($image->using != Images::USING_AS_PROJECT_BANNER and $image->using != Images::USING_AS_ADVERT_BANNER) {
                                if ($image->checkForBannerSetPossibilityInImageList())
                                    $image->makeBannerToProject(Yii::app()->user->id);
                                else
                                    if (!$image->isUsingInGallery())
                                        $image->addToServerGallery(Yii::app()->user->id);
                            }

                            ?>
                            <?php if ($image->using != Images::USING_AS_ADVERT_BANNER): ?>
                                <li>
                                    <a href="/images/del/<?php echo $image->id; ?>"><?php echo Yii::t('translations', 'Удалить изображение'); ?></a>
                                </li>
                            <? endif ?>
                        </ul>

                    </div>
                    <!-- /.nav-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
            <!-- /navbar-example -->
        </div>
    </div>

</div>


<script>
    $(document).keypress(function (e) {
        if (e.which == 13) {
            $('#input_<?php echo $image->id?>').blur();
        }
    });
</script>
