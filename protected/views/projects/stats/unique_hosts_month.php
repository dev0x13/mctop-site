<?php if (isset($unique_hosts_month) && gettype($unique_hosts_month) == 'object'): ?>
    <div class="pageTitle"><?php echo Yii::t('translations', 'История переходов (за месяц)') ?></div>
<?php endif; ?>

<?php
$days = [];
$hosters_global = [];
$day = date('d', time());
if (isset($unique_hosts_month) && gettype($unique_hosts_month) == 'object') {
    $hack = (object)array();
    for ($i = 1; $i <= date('d', time()); $i++) {
        if ($i > 9)
            $index = $i;
        else
            $index = "0{$i}";
        if (!property_exists($unique_hosts_month, $index))
            $hack->$i = array();
        else
            $hack->$i = $unique_hosts_month->$index;
    }

    foreach ($hack as $day => $hosters_for_day) {
        $hosters_count = 0;
        foreach ($hosters_for_day as $country => $hosters)
            $hosters_count += $hosters;

        $hosters_global[] = $hosters_count;
        $days[] = $day;
    }
    $this->Widget('ext.highcharts.HighchartsWidget', array(
        'options' => array(
            'title' => array('text' => ''),
            'xAxis' => array(
                'categories' => $days
            ),
            'yAxis' => array(
                'title' => array('text' => Yii::t('translations', 'Переходы на сайт'))
            ),
            'series' => array(
                array('name' => Yii::t('translations', 'Переходы на сайт'), 'data' => $hosters_global)
            ),
            'legend' => array(
                'layout' => 'vertical',
                'align' => 'right',
                'verticalAlign' => 'middle',
                'borderWidth' => 0
            ),
            'plotOptions' => array(
                'line' => array(
                    'dataLabels' => array(
                        'enabled' => true
                    ),
                    'enableMouseTracking' => 'false',
                )
            )
        )
    ));
    unset($data);
} else
    echo Yii::t('translations', 'Нет данных для построения графиков, по критерию: уникальные посещения проекта за месяц') . '<hr>'; //todo Translate


?>