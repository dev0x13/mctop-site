<?php /* @var $project Projects */ ?>

<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $project->title => array('/rating/project/' . $project->id),
    Yii::t('translations', 'Голосование за проект {name}', array('{name}' => CHtml::encode($project['title'])))
);
?>

<div
    class="pageTitle"><?php echo Yii::t('translations', 'Голосование за проект {name}', array('{name}' => CHtml::encode($project['title']))); ?></div>
<div class="SEye"></div>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <div class="form-group">
        <input name="nickname" class="form-control"
               placeholder="<?php echo Yii::t('translations', 'Ваш ник на проекте') ?>">
    </div>

    <div class="vote_button">
        <input type="submit" class="btn btn-success btn-lg curled"
               value="<?php echo Yii::t('translations', 'Проголосовать'); ?>" "/>
    </div>

    <?php $this->endWidget(); ?>


</div>

<script>
    $(document).ready(function () {
        $('div.SEye').qtip({
            style: {
                classes: 'qtip-dark qtip-shadow',
                tip: {
                    corner: false
                }
            },
            content: {
                text: '<?php echo Users::model()->findByPk(Yii::app()->user->id)->name;?>, I\'m watching you.'
            },
            position: {
                corner: {
                    target: 'topRight',
                    tooltip: 'bottomLeft'
                },
                my: 'bottom right',
                at: 'top left'
            },
            show: {
                effect: function () {
                    $(this).fadeTo(500, 1);
                }
            },
            hide: {
                effect: function () {
                    $(this).slideUp();
                }
            }
        })
    });

</script>