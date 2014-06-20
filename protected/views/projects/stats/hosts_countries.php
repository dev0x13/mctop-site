<?php

if (isset($unique_hosts_month))
    if (gettype($unique_hosts_month) == 'object') {
        $countries_global = [];

        foreach ($unique_hosts_month as $day => $countries)
            foreach ($countries as $key => $value)
                if (!array_key_exists($key, $countries_global))
                    $countries_global[$key] = 0;

        foreach ($unique_hosts_month as $day => $countries)
            foreach ($countries as $country => $values)
                $countries_global[$country] += $values;

        foreach ($countries_global as $key => $value) {
            $new_value = array($key, $value);
            $countries_global_new[] = $new_value;
        }
    } else
        echo Yii::t('translations', 'Нет данных для построения графиков, по критерию: Страны посетителей, посещавщих проект'); //todo Translate
?>

<?php if (isset($countries_global)): ?>
    <div class="pageTitle"><?php echo Yii::t('translations', 'Страны посетителей (за месяц)') ?></div>
<?php endif; ?>

<?php

if (isset($countries_global)) {
    $this->Widget('ext.highcharts.HighchartsWidget', array(
        'options' => array(
            'title' => array('text' => ''),
            'series' => array(
                array(
                    'name' => Yii::t('translations', 'Из этой страны'),
                    'data' => $countries_global_new,
                    'type' => 'pie'
                ),
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
}


?>