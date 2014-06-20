<link rel="stylesheet" href="/static/css/timer.css" type="text/css" media="all"/>
<?php
$this->renderPartial('../script');
?>

<script type="text/javascript">
    $(document).ready(function () {
        JBCountDown({
            secondsColor: "#000",
            secondsGlow: "#FFFFFF",

            minutesColor: "#000",
            minutesGlow: "#FFFFFF",

            hoursColor: "#000",
            hoursGlow: "#FFFFFF",

            daysColor: "#000",
            daysGlow: "#FFFFFF",

            startDate: "<?php echo time()?>",
            endDate: "1401624840",
            now: "<?php echo time()?>"
        });
    });
</script>

<div class="message">
    <h1>
        <?php echo Yii::t('translations', 'До запуска Открытого Бета тестирования MCTop.Leo осталось') ?>
    </h1>
</div>

<div align="center">

    <img style="height:30%; width:10%;height: 53%;width: 14%;margin: 17px;padding-right: 15px;"
         src="/static/img/istok.png"/>
</div>


<div class="clock">

    <!-- Days -->
    <div class="clock_days">
        <div class="bgLayer">
            <div class="topLayer"></div>
            <canvas id="canvas_days" width="188" height="188">
            </canvas>
            <div class="text">
                <p class="val">0</p>

                <p class="type_days"><?php echo Yii::t('translations', 'Дн.'); ?></p>
            </div>
        </div>
    </div>
    <!-- Days -->
    <!-- Hours -->
    <div class="clock_hours">
        <div class="bgLayer">
            <div class="topLayer"></div>
            <canvas id="canvas_hours" width="188" height="188">
            </canvas>
            <div class="text">

                <div class="type_hours">
                    <p class="val">0</p>
                    <?php echo Yii::t('translations', 'Час.'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Hours -->
    <!-- Minutes -->
    <div class="clock_minutes">
        <div class="bgLayer">
            <div class="topLayer"></div>
            <canvas id="canvas_minutes" width="188" height="188">
            </canvas>
            <div class="text">
                <div class="type_minutes">
                    <p class="val">0</p>
                    <?php echo Yii::t('translations', 'Мин.'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Minutes -->
    <!-- Seconds -->
    <div class="clock_seconds">
        <div class="bgLayer">
            <div class="topLayer"></div>
            <canvas id="canvas_seconds" width="188" height="188">
            </canvas>
            <div class="text">
                <div class="type_seconds">
                    <p class="val">0</p>
                    <?php echo Yii::t('translations', 'Сек.'); ?>
                </div>
            </div>
        </div>
    </div>
    <!--LiveInternet counter-->
    <script
        type="text/javascript">document.write("<a href='http://www.liveinternet.ru/click' target=_blank><img src='//counter.yadro.ru/hit?t26.13;r" + escape(document.referrer) + ((typeof(screen) == "undefined") ? "" : ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ? screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) + ";h" + escape(document.title.substring(0, 80)) + ";" + Math.random() + "' border=0 width=88 height=15 alt='' title='LiveInternet: показано число посетителей за сегодня'><\/a>")</script>
    <!--/LiveInternet-->
    <br>
    <!-- Seconds -->
</div>

<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-51273132-1', 'mctop.im');
    ga('require', 'displayfeatures');
    ga('send', 'pageview');

</script>