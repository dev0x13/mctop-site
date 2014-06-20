<?php
/* @var $this ProjectsController */
/* @var $project Projects */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Назначение ролей');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    $project->title => array('/cabinet/projects/view/' . $project->id),
    Yii::t('translations', 'Назначение ролей для проекта') . ' ' . $project->title,
);
?>

<div class="pageTitle"><?php echo Yii::t('translations', 'Назначение ролей'); ?></div>

<div class="project_roles">

    <?php if ($project->checkUserRights(Yii::app()->user->id, 'project_set_roles')): ?>
        <div class="form">


            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'events-form',
            )); ?>

            <div class="form-group">
                <?php
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'name' => 'login',
                    'value' => '',
                    'source' => $this->createUrl('ajax/ProjectSetRolesUsers/' . $project->id),
                    'htmlOptions' => array(
                        'class' => 'form-control',
                        'placeholder' => Yii::t('translations', 'Введите логин пользователя')
                    )
                ));
                ?>
            </div>

            <div class="row">
                <?php
                foreach (Roles::getRolesForForm() as $role) {
                    echo CHtml::CheckBox($role->weight, false, array('value' => $role->weight)) . ' ' . Yii::t('translations', $role->title) . '&emsp;';
                }
                ?>
                <?php echo $form->error($model, 'role'); ?>
                <input type="hidden" name="role" value="role"/>
            </div>

            <div class="row">
                <?php echo CHtml::submitButton(Yii::t('translations', 'Добавить роль'), array('class' => 'btn btn-primary')); ?>
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