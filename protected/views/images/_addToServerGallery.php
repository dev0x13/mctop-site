<?php /* @var $image Images */ ?>
<?php /* @var $projects Projects */ ?>

<li class="dropdown" id="image_<?php echo $image->id; ?>">
    <a id="drop1" href="#" role="button" class="dropdown-toggle"
       data-toggle="dropdown"><?php echo Yii::t('translations', 'Добавить в галерею сервера'); ?> <b class="caret"></b></a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
        <?php

        $servers_count = 0;
        $picture_in_used_by_servers = 0;
        foreach ($projects as $project) {
            foreach ($project->servers as $server) {
                $servers_count++;
                $server_image_ids = Images::getServerImagesIds($server);

                if (!Images::isAlreadyUsingInGallery($image, null, $server_image_ids))
                    echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="/images/addtogallery/' . $image->id . '/forserver.' . $server->id . '">' . $project->title . ' => ' . $server->title . ' </a></li>';
                else
                    $picture_in_used_by_servers++;
            }
        }
        ?>
    </ul>

    <?php //echo $picture_in_used_by_servers;?>

    <?php if ($servers_count == $picture_in_used_by_servers): ?>
        <script>
            $("#image_<?php echo $image->id;?>").remove();
        </script>
    <?php endif; ?>
</li>




