<div class="rating-list">
    <a class="btn" href="/rating/recommended"><?php echo Yii::t('translations','Рекомендуемые серверы');?></a>
    <br>
    <hr>
    Уважаемые пользователи!
    <br>
    Из-за технических неполадок мы потеряли часть изображений (баннеров). Администрация MCTop приносит свои глубочайшие извинения.
    <br>
    Просим всех владельцев проектов проверить свои баннеры и загрузить их заново в случае надобности. 
    <hr>
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
