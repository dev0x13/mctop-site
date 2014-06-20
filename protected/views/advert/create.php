<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Создание объявления');

$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Реклама') => array('/advert'),
    Yii::t('translations', 'Создание объявления'),
);
?>

<div class="pageTitle"><?php echo Yii::t('translations', 'Создание объявления'); ?></div>

<?php if (!isset($_GET['type'])): ?>
    <div class="btn-group btn-group-justified">
        <a href="/advert/create/project"
           class="btn btn-primary btn-lg"><?php echo Yii::t('translations', 'Реклама проекта'); ?></a>
        <a href="/advert/create/site"
           class="btn btn-primary btn-lg"><?php echo Yii::t('translations', 'Реклама сайта'); ?></a>
    </div>
<?php endif ?>
<?php
if (isset($_GET['type'])) {
    $this->renderPartial('creation_' . $_GET['type'] . '_form',
        array(
            'model' => $model,
            'bank_account' => $bank_account,
            'selected' => $selected,
            'id' => $id
        ));
}
?>

<script>
    $(function () {
        $("input[name$='Adverts[name]'], input[name$='Adverts[ordered]']").maxlength({
            alwaysShow: true,
            warningClass: "label label-success",
            limitReachedClass: "label label-important"
        });
    });
</script>

<script>

    Calculation();
    $('#Adverts_ordered').on('keyup change', function () {
        Calculation();
    });

    $("#Adverts_type").change(Calculation);
    $("#Adverts_pay_type").change(Calculation);

    function Calculation() {
        var money, amount;
        if (!isNaN($("#Adverts_ordered").val()) && $("#Adverts_ordered").val() != "") {
            amount = Number($("#Adverts_ordered").val());
            if ($("#Adverts_pay_type").val() == "0")
                if ($("#Adverts_type").val() == "0")
                    money = amount * 5;
                else
                    money = amount;
            else if ($("#Adverts_type").val() == "0")
                money = amount / 40;
            else
                money = 3 * amount / 200;
            $("#money").text(Math.round(money).toFixed(1) + ' ' + declOfNum(Math.round(money).toFixed(1), ['<?php echo Yii::t('translations','рубль');?>', '<?php echo Yii::t('translations','рубля');?>', '<?php echo Yii::t('translations','рублей');?>']));
        }
    }

    function declOfNum(number, titles) {
        cases = [2, 0, 1, 1, 1, 2];
        return titles[ (number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5] ];
    }
</script>
