<li class="dropdown">
    <a id="drop1" href="#" role="button" class="dropdown-toggle"
       data-toggle="dropdown"><?php echo Yii::t('translations', 'Использовать в качестве баннера'); ?> <b
            class="caret"></b></a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
        <?php
        foreach ($projects as $project) {
            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="/images/useasbanner/' . $image->id . '/forproject.' . $project->id . '">' . Yii::t('translations', 'Для проекта') . ' ' . $project->title . ' </a></li>';
        }
        ?>
    </ul>
</li>