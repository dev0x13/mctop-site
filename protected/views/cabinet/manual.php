<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    '' . Yii::t('translations', 'MCTop.Manual')
);
?>

<h1>MCTop.Manual</h1>

<?php echo Yii::t('translations', 'MCTop.Manual - руководство по использованию сайта, в нем вы сможете найти ответы на многие вопросы'); ?>.
<hr>

<div class="faq">
    <div class="categories">
        <ol>
            <?php
            if (isset($categories)) {
                foreach ($categories as $key => $category)
                    $this->renderPartial('manual_category', array(
                        'category' => $category
                    ));
            }
            ?>
        </ol>
    </div>
</div>
