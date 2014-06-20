<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Банк')
);
?>

<p>
<h2>
    <b><?php echo Yii::t('translations', 'Банк') ?></b>
</h2>
</p>
<hr>

<div>
    <?php echo Yii::t('translations', 'Ваш баланс') . ': ' . $bank_account->balance; ?> rub.<br>
    <a href="/cabinet/bank_replenish" class="btn btn-primary"><?php echo Yii::t('translations', 'Пополнить счет') ?></a>
</div>