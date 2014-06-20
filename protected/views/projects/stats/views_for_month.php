<?php
$days = [];
$viewers_global = [];
if (isset($page_views_month)) {
    if (gettype($page_views_month) == 'object') {
        $hack = (object)array();
        for ($i = 1; $i <= date('d', time()); $i++) {
            if ($i > 9)
                $index = $i;
            else
                $index = "0{$i}";
            if (!property_exists($page_views_month, $index))
                $hack->$i = array();
            else
                $hack->$i = $page_views_month->$index;
        }

        foreach ($hack as $day => $viewers_for_day) {
            reset($page_views_month);
            $first_key = key($page_views_month);
            $viewers_count = 0;
            foreach ($viewers_for_day as $country => $viewers)
                $viewers_count += $viewers;

            $viewers_global[] = $viewers_count;
            $days[] = $day;
        }


        $this->Widget('ext.highcharts.HighchartsWidget', array(
            'options' => array(
                'title' => array('text' => Yii::t('translations', 'История просмотров (за месяц)')),
                'xAxis' => array(
                    'categories' => $days
                ),
                'yAxis' => array(
                    'title' => array('text' => Yii::t('translations', 'Просмотры'))
                ),
                'series' => array(
                    array('name' => Yii::t('translations', 'Просмотры'), 'data' => $viewers_global)
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
        echo Yii::t('translations', 'Нет данных для построения графиков, по критерию: количество просмотров страницы проекта в день') . '<hr>'; //todo Translate
}

?>