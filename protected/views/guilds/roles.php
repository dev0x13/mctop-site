<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Назначение ролей');

$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/projects'),
    Yii::t('translations', 'Назначение ролей для проекта') . ' ' . $project->title,
);
?>

<div class="pageTitle"><?php echo Yii::t('translations', 'Назначение ролей'); ?></div>

<div class="project_roles">

    <?php
    if (GuildsMembers::getGeneralRole(GuildsMembers::model()->find('uid=:user and pid=:guild', array(
            ':user' => Yii::app()->user->id, ':guild' => $project->id))->roles_weight)->weight == 2
    ):
        ?>

        <div class="form">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'events-form',
            )); ?>

            <div class="row">
                <?php echo $form->textField($model, 'uid', array('size' => 60, 'maxlength' => 255, 'placeholder' => Yii::t('translations', 'UID'))); ?>
                <?php echo $form->error($model, 'uid'); ?>
            </div>

            <div class="row">
                <?php
                foreach (GuildsRoles::getRolesForForm() as $role) {
                    echo CHtml::CheckBox($role->weight, false, array('value' => $role->weight)) . ' ' . Yii::t('translations', $role->name) . '&emsp;';
                }
                ?>
                <?php echo $form->error($model, 'role'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::submitButton(Yii::t('translations', 'Добавить роль'), array('class' => 'btn btn-primary mctbtn_normal')); ?>
            </div>

            <?php $this->endWidget(); ?>

        </div>
        <!-- form -->

    <?php endif; ?>

    <?php
    if (!empty($members))
        foreach ($members as $member) {
            $this->renderPartial('_member_profile', array(
                'member' => $member
            ));
        }
    ?>
</div>