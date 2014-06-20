<?php
/* @var $this ProjectsController */
/* @var $project Projects */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Редактирование проекта');

$this->breadcrumbs = array(
    Yii::t('translations', 'Кабинет') => array('/cabinet'),
    Yii::t('translations', 'Проекты') => array('/cabinet/projects'),
    $project->title => array('/cabinet/projects/view/' . $project->id),
    Yii::t('translations', 'Редактирование проекта')
);
?>


<div class="pageTitle"><?php echo Yii::t('translations', 'Редактирование проекта') ?></div>

<?php $this->renderPartial('form', array(
    'model' => $project,
    'countries' => $countries
))?>

<script>
    $(document).ready(function () {
        checkBonusesFields();
        $('#give_bonuses').on('change', function () {
            checkBonusesFields();
        });
    });

    function checkBonusesFields() {
        if ($('#give_bonuses').val() == 1)
            $('#script_settings').show(500);
        else
            $('#script_settings').hide(500);
    }
</script>