<?php
/* @var $this ProjectsController */
/* @var $project Projects */

$this->pageTitle .= ' - ' . $project->title;

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/projects'),
    $project->title
);
?>
<script>
    $(function () {
        $("#project_menu").menu();
        $("#guild_menu").menu();
    });
</script>
<style>
    .ui-menu {
        width: 200px;
    }
</style>

<div class="cabinet_project">

    <h1><?php echo Yii::t('translations', 'Проект'); ?> <?php echo $project->title; ?></h1>
    <hr>

    <div class="banner">
        <?php if ($project->banner_clickable): ?>
        <a href="/rating/out/<?php echo $project->id ?>">
            <?php endif; ?>
            <img src="<?php echo CHtml::encode($project['banner']); ?>"/>
            <?php if ($project->banner_clickable): ?>
        </a>
    <?php endif; ?>
    </div>

    <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_programmer_check_bonus_script')): ?>
        <?php if ($project->give_bonuses): ?>
            <a class="btn mctbtn_normal"
               href="/cabinet/projects/bonuses/<?php echo $project->id; ?>"><?php echo Yii::t('translations', 'Настройка скрипта выдачи бонуса'); ?></a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_financer_create_advert')): ?>
        <a class="btn mctbtn_normal"
           href="/cabinet/projects/fmCabinet/<?php echo $project->id; ?>"><?php echo Yii::t('translations', 'Кабинет финансового менеджера'); ?></a>
    <?php endif; ?>

    <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_edit')): ?>
        <div class="buttons">

            <?php
            $redis = Yii::app()->getComponent('redis')->getClient();
            $approve_needles = $redis->get("site_code_for_project_" . $project->id);
            ?>

            <?php if (!empty($approve_needles) and $project->having_site == Projects::HAVING_SITE_YES)
                echo
                    '<b>
                        <a class="btn mctbtn_normal" href="/cabinet/projects/approve_site/' . $project->id . '">
                    ' . Yii::t('translations', 'Подтвердить сайт') . '
                    </a>
                </b>';
            ?>

            <div class="menus">
                <ul id="project_menu">
                    <li>
                        <a href="#"><?php echo Yii::t('translations', 'Проект') ?></a>
                        <ul>
                            <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_edit')): ?>
                                <li>
                                    <a href="/cabinet/projects/edit/<?php echo $project->id; ?>">
                                        <?php echo Yii::t('translations', 'Редактировать'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_set_roles')): ?>
                                <li>
                                    <a href="/cabinet/projects/roles/<?php echo $project->id; ?>">
                                        <?php echo Yii::t('translations', 'Назначение ролей'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (Yii::app()->language != 'en'): ?>
                                <li>
                                    <a href="#">English</a>
                                    <ul>
                                        <li>
                                            <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_edit')): ?>
                                                <?php if (Yii::app()->language != 'en'): ?>
                                                    <a href="/cabinet/projects/edit_english/<?php echo $project->id; ?>">
                                                        <?php echo Yii::t('translations', 'Description'); ?>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_delete')): ?>
                                <li>
                                    <a href="/cabinet/projects/del/<?php echo $project->id; ?>">
                                        <?php echo Yii::t('translations', 'Удалить'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                </ul>

                <ul id="guild_menu">
                    <li>
                        <a href="#"><?php echo Yii::t('translations', 'Гильдия') ?></a>
                        <ul>

                            <?php if ($project->isProjectHaveGuild()): ?>
                                <li>
                                    <a href="/guilds/<?php echo $project->id; ?>"><?php echo Yii::t('translations', 'Просмотреть'); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_guild_founder')): ?>

                                <?php if (!$project->isProjectHaveGuild()): ?>
                                    <li>
                                        <a href="/cabinet/projects/guild/create/<?php echo $project->id; ?>">
                                            <?php echo Yii::t('translations', 'Создать гильдию'); ?>
                                        </a>
                                    </li>
                                <?php endif ?>

                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>

            <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_add_server')): ?>
                <a class="btn mctbtn_normal"
                   href="/cabinet/projects/addserver/<?php echo $project->id; ?>"><?php echo Yii::t('translations', 'Добавить сервер'); ?></a>
            <?php endif; ?>

            <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_view')): ?>
                <a class="btn mctbtn_normal"
                   href="/cabinet/projects/stats/<?php echo $project->id; ?>"><?php echo Yii::t('translations', 'Статистика'); ?></a>
            <?php endif; ?>

        </div>
    <?php endif; ?>


    <div class="servers">

        <?php
        if (!empty($project->servers)) {
            foreach ($project->servers as $server) {
                $this->renderPartial('_server', array(
                    'server' => $server,
                    'project' => $project
                ));
            }
        }
        ?>

    </div>
</div>
