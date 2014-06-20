<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="/static/css/chosen.css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="/static/css/qunit.css">
    <link rel="stylesheet" type="text/css" href="/static/css/jquery.qtip.min.css">
    <link rel="stylesheet" type="text/css" href="/static/css/jquery-ui-1.10.4.custom.css">
    <link rel="stylesheet" type="text/css" href="/static/css/common.css"/>

    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/jquery-ui-1.10.4.custom.min.js"></script>
    <title><?php echo CHtml::encode(Yii::app()->name . $this->pageTitle); ?></title>
</head>
<body>
<?php echo $content ?>
</body>
</html>
