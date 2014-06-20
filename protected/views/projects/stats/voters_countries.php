<?php if (isset($voters_countries) && gettype($voters_countries) == 'object'): ?>
    <div class="pageTitle"><?php echo Yii::t('translations', 'Страны голосующих (за месяц)') ?></div>
<?php endif; ?>
<?php

if (gettype($voters_countries) == 'object')
    foreach ($voters_countries as $country => $votes_count) {
        $test = array($country, $votes_count);
        $data[] = $test;
    }
else
    echo Yii::t('translations', 'Нет данных для построения графиков, по критерию: Страны голосующих за проект посетителей'); //todo Translate


if (isset($data))
    $this->Widget('ext.highcharts.HighchartsWidget', array(
        'options' => array(
            'title' => array('text' => ''),
            'series' => array(
                array('name' => Yii::t('translations', 'Из этой страны'), 'data' => $data, 'type' => 'pie'),
            ),
            'scripts' => array(
                'themesgrid'
            ),
            'tooltip' => array(
                'formatter' => "js:function(){ return this.series.name+'<br><b>'+this.y + '</b>'+'<br><b>'+this.percentage.toFixed(2) + '</b> %';}"
            ),
            'plotOptions' => array(
                'pie' => array(
                    'allowPointSelect' => true,
                    'cursor' => 'pointer',
                    'showInLegend' => true,
                )
            )

        )
    ));
?>
<hr>