<?php
/* @var $transaction BankTransactions */

$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Банк') => array('/cabinet/bank'),
    Yii::t('translations', 'Пополнить счет'),
);
?>

<p>
<h2>
    <b><?php echo Yii::t('translations', 'Пополнить счет') ?></b>
</h2>
</p>

<div class="form">
    <form action="https://unitpay.ru/pay/4245-82725" method="post">
        <input type="hidden" name="account" value="<?php echo Yii::app()->user->id ?>">
        <input type="hidden" name="language" value="<?php echo Yii::app()->language; ?>">

        <div class="form-group">
            <label for="sum"><?php echo Yii::t('translations', 'Сумма платежа'); ?></label> <input class="form-control"
                                                                                                   type="text"
                                                                                                   name="sum"
                                                                                                   value="50">
        </div>

        <input type="hidden" name="desc" value="Пополнение счета в личном кабинете">
        <input class="btn btn-success" type="submit" value="<?php echo Yii::t('translations', 'Оплатить'); ?>">
    </form>


</div>

