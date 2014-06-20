<?php
/* @var $this ProjectsController */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Редактирование объявления');

$this->breadcrumbs = array(
    Yii::t('translations', 'Личный кабинет') => array('/cabinet'),
    Yii::t('translations', 'Реклама') => array('/cabinet'),
    Yii::t('translations', 'Редактирование объявления'),
);
?>

<div class="pageTitle"><?php echo Yii::t('translations', 'Редактирование объявления'); ?></div>

<?php
$view = $model->payer_type == Adverts::PAYER_PROJECT ? 'edit_project_form' : 'edit_site_form';
$this->renderPartial($view, array(
    'model' => $model,
));
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


    $(function () {
        Calculation();
    });


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