<?php

$this->widget('CLinkPager', array(
    'pages' => $pages,
    'maxButtonCount' => 1,
    'cssFile' => '',
));

?>

<div class="rating-list">
    <a class="btn" href="/rating/recommended"><?php echo Yii::t('translations','Рекомендуемые серверы');?></a>
    <br>
    <?php
    if (!empty($projects))
        foreach ($projects as $project)
            $this->renderPartial('_project', array('project' => $project, 'countries' => $countries));
    ?>
</div>

<?php

$this->widget('CLinkPager', array(
    'pages' => $pages,
    'maxButtonCount' => 1,
    'cssFile' => '',
));

?>
