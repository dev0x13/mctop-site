<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::t('translations', 'style'); ?>">
    <link rel="stylesheet" type="text/css" href="/static/css/chosen.css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="/static/css/qunit.css">
    <link rel="stylesheet" type="text/css" href="/static/css/jquery.qtip.min.css">
    <link rel="stylesheet" type="text/css" href="/static/css/jquery-ui-1.10.4.custom.css">
    <link rel="stylesheet" type="text/css" href="/static/css/common.css"/>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <script src="/static/js/jquery.min.js"></script>
    <?php Yii::app()->getClientScript()->registerCoreScript('jquery.ui') ?>
    <title><?php echo CHtml::encode(Yii::app()->name . '. ' . $this->pageTitle); ?></title>
</head>

<body>
    <div class="transparent page_content_wrapper">
<div class="container" id="page">
    <div class="mainmenu">
        <div class="logo">

            <a href="/"><img src="/static/img/istok.jpg" style="width:40px"></a>
			<div style="position:relative;left:18px;display:inline-block;">MCTop</div>
        </div>
        <div class="space"></div>
        <div class="a_with_box_shadow">
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => Yii::t('translations', 'Новости'), 'url' => array('/news')),
                    array('label' => Yii::t('translations', 'Серверы'), 'url' => array('/search')),
                    array('label' => Yii::t('translations', 'Рейтинг'), 'url' => array('/rating')),
                    array('label' => Yii::t('translations', 'Мой профиль'), 'url' => array('/u'.Yii::app()->user->id), 'visible' => !Yii::app()->user->isGuest),
                    array('label' => Yii::t('translations', 'Личный кабинет'), 'url' => array('/cabinet'), 'visible' => !Yii::app()->user->isGuest),
                    array('label' => Yii::t('translations', 'Вход'), 'url' => array('/s/login'), 'visible' => Yii::app()->user->isGuest, 'itemOptions' => array('class' => 'login')),
                    array('label' => Yii::t('translations', 'Office'), 'url' => Yii::app()->params['admin_site_url'] . 'site/login', 'visible' => !Yii::app()->user->isGuest & AdminSiteRights::model()->exists('user=:user', array(':user' => Yii::app()->user->id))),
                    array('label' => Yii::t('translations', 'Выход'), 'url' => array('/s/logout'), 'visible' => !Yii::app()->user->isGuest, 'itemOptions' => array('class' => 'logout')),
                    array('label' => Yii::t('translations', 'Регистрация'), 'url' => array('/s/register'), 'visible' => Yii::app()->user->isGuest, 'itemOptions' => array('class' => 'logout'))
                ),
            )); ?>
        </div>
    </div>
    <!-- mainmenu -->

    <?php //$this->widget('WAdvert', array('type' => Adverts::POSITION_HEAD)); ?>

    <?php if (isset($this->breadcrumbs)):

    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $this->breadcrumbs,
        'homeLink' => false,
        'tagName' => 'ul',
        'separator' => '',
        'activeLinkTemplate' => '<li><a href="{url}">{label}</a> <span class="divider"></span></li>',
        'inactiveLinkTemplate' => '<li><span>{label}</span></li>',
        'htmlOptions' => array('class' => 'breadcrumb')
    )); ?><!-- breadcrumbs -->
<?php endif; ?>

    <div style="background-color:#fff;padding:3px; text-align:center">
        Следи за новостями MCTop во <a href="http://vk.com/mctop_company.public"><u>ВКонтакте</u></a><br>
        MCTop Team: Сегодня поправим рекламу, сделаем мануал по сайту и еще несколько плюшек
    </div><br><br>
    <?php echo $content; ?>


    <div class="clear"></div>

    <div align="center" style="margin-top:10px;margin-bottom: 10px; display: none;">
        <!--LiveInternet counter-->
        <script
            type="text/javascript">document.write("<a href='http://www.liveinternet.ru/click' target=_blank><img src='//counter.yadro.ru/hit?t14.13;r" + escape(document.referrer) + ((typeof(screen) == "undefined") ? "" : ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ? screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) + ";" + Math.random() + "' border=0 width=88 height=31 alt='' title='LiveInternet: показано число просмотров за 24 часа, посетителей за 24 часа и за сегодня'><\/a>")</script>
        <!--/LiveInternet-->


        <!-- Yandex.Metrika informer -->
        <a href="https://metrika.yandex.ru/stat/?id=4081210&amp;from=informer"
           target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/4081210/3_0_54EB8BFF_34CB6BFF_0_pageviews"
                                               style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика"
                                               title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)"
                                               onclick="try{Ya.Metrika.informer({i:this,id:4081210,lang:'ru'});return false}catch(e){}"/></a>
        <!-- /Yandex.Metrika informer -->

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function () {
                    try {
                        w.yaCounter4081210 = new Ya.Metrika({id: 4081210,
                            webvisor: true,
                            clickmap: true,
                            trackLinks: true});
                    } catch (e) {
                    }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () {
                        n.parentNode.insertBefore(s, n);
                    };
                s.type = "text/javascript";
                s.async = true;
                s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else {
                    f();
                }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript>
            <div><img src="//mc.yandex.ru/watch/4081210" style="position:absolute; left:-9999px;" alt=""/></div>
        </noscript>
        <!-- /Yandex.Metrika counter -->
    </div>

    <!-- footer -->

</div>
<!-- page -->

<script src="/static/js/highcharts.src.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script src="/static/js/qunit.js"></script>
<script src="/static/js/jquery.qtip.min.js"></script>
<script src="/static/js/bootstrap-maxlength.js"></script>
<script src="/static/js/chosen.jquery.js"></script>
<script src="/static/js/mctop.js"></script>
<script type="text/javascript">

    window.addEventListener("keydown", function (e) {
        if (e.keyCode === 39 && document.activeElement !== 'text') {
            history.forward();
        }
    });

    window.addEventListener("keydown", function (e) {
        if (e.keyCode === 37 && document.activeElement !== 'text') {
            history.back();
        }
    });

    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    };
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-51962577-1', 'mctop.im');
    ga('send', 'pageview');

</script>
<div class="push_footer"></div>
</div>
    <div class="footer">
        <div class="menu">
            <a href="/s/rules">
                <?php echo Yii::t('translations', 'Правила') ?>
            </a>
            <a href="/s/about">
                MCTop
            </a>
            <a class="last" href="/s/team">
                <?php echo Yii::t('translations', 'Kоманда') ?>
            </a>
        </div>

        <div class="wip">
            <br>
            MCTop &copy 2011-2014<br>
        </div>
    </div>
</body>
</html>
