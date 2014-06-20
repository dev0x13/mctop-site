<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Тикеты');

$this->breadcrumbs = array(
    Yii::t('translations', 'Тикеты'),
);
?>


<a href="/tickets/create" class="btn btn-primary"><?php echo Yii::t('translations', 'Создать тикет'); ?></a>

<div class="tickets_list">
    <?php
    if (!empty($tickets)) {
        foreach ($tickets as $ticket) {
            $this->renderPartial('_ticket', array(
                'ticket' => $ticket,
            ));
        }
    }
    ?>
</div>