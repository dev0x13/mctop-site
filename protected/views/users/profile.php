<?php
$this->pageTitle .= ' - ' . CHtml::encode($user->name) . ' ' . CHtml::encode($user->surname);
?>

<div class="user_page">

    <div class="user_name">
        <img
            src="/static/img/flags/<?php echo $user->language; ?>.png"/>

        <?php echo CHtml::encode($user->name); ?> <?php echo CHtml::encode($user->surname); ?>
    </div>

    <div class="left-side">
        <div class="avatar">
            <img src="<?php echo $user->avatar; ?>"/>
        </div>
    </div>

    <div class="right-side">
        <div class="status">
            <?php
                if(time()-strtotime($user->last_update)<60*10)
                    echo Yii::t('translations','В сети');
                else
                    echo Yii::t('translations','Не в сети');
                ;?>
        </div>
    </div>

    <?php
    /*
    <!--Проекты, в которых участвует пользователь-->

    <div class="user_projects">
        <?php
        if (!empty($user->projectsRoles)) {
            foreach ($user->projectsRoles as $role)
                $this->renderPartial('_project', array(
                    'project' => Projects::model()->findByPk($role->project),
                    'user' => $user->id
                ));
        }
        ?>
    </div>
    */
?>

</div>
