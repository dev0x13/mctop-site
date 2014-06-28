<div class="project">
    <div class="country"><img src="/static/img/flags/<?php echo $countries[$project->country - 1]; ?>.png"></div>
    <div class="title"><a
            href="/rating/project/<?php echo CHtml::encode($project['id']); ?>"><?php echo CHtml::encode($project['title']); ?></a>
    </div>
    <div class="score">
        <?php echo Yii::t('translations', 'Очков') . ': ' . $project['score']; ?><br>
        <?php echo Yii::t('translations', 'Голосов') . ': ' . $project['votes_month']; ?>
    </div>

    <div class="banner">
        <?php if($project->banner_clickable):?>
        <a href="/rating/project/<?php echo $project->id?>">
        <?php endif;?>
            <img src="<?php echo CHtml::encode($project['banner']); ?>"/>
        <?php if($project->banner_clickable):?>
        </a>
        <?php endif;?>
    </div>

    <?php
        $user_country = Yii::app()->SxGeo->getCountry($_SERVER['REMOTE_ADDR']);
    ?>

    <div class="description">
        <?php
            if(Yii::app()->language=='en')
                $english_description = EnglishProject::model()->findByPk($project->id);

            if(isset($english_description))
            {
                if(isset($english_description) and Yii::app()->language=='en')
                {
                    if($project->id == $english_description->project)
                        echo CHtml::encode($english_description->description);
                }
            }
            else
                echo CHtml::encode($project['description']);
        ?>
    </div>

    <?php
    if (!empty($project['servers']))
        foreach ($project['servers'] as $server)
            $this->renderPartial('_server', array('server' => $server));
    ?>

</div>