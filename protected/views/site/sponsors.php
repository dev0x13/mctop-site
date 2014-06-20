<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle .= ' - ' . Yii::t('translations', 'Спонсоры MCTop.');
?>

<div class="pageTitle"><?php echo Yii::t('translations', 'Спонсоры MCTop.'); ?></div>

<div class="form">

    <a class="btn"
       href="https://boomstarter.ru/projects/151261/26864"><?php echo Yii::t('translations', 'Поддержать проект!'); ?></a>
    <hr>

    <?php
    $q = new CDbCriteria();
    $q->order = 'date desc';
    $sponsors = Sponsors::model()->findAll($q);

    /*
        $sponsor = new Sponsors();
        $sponsor->setName("Dmitry Kiselev");
        $sponsor->setDate("2014.06.02");
        $sponsor->setSumm(600);
        //$sponsor->save();
    */
    ?>
    <ul style="list-style: none">
        <?php
        if (isset($sponsors) and sizeof($sponsors) > 0) {
            $count = 0;
            foreach ($sponsors as $key => $sponsor) {
                echo "
                        <li style='border-bottom: 1px solid #cacaca; position:relative; left:-45px;'>
                            <span style='position:relative;padding:15px;padding-right:10px;' class='glyphicon glyphicon-user'></span>
                            $sponsor->name. (<span style='padding:3px;' class='glyphicon glyphicon-calendar'></span>" . date("d/m/Y", strtotime($sponsor->date)) . ")
                        </li>
                    ";
                $count += $sponsor->summ;
            }
            $percentage = round($count / 70000 * 100, 2);
        }
        ?>

        <div class="progress progress-striped active" style="margin-top: 10px;position: relative;left:-10px;">
            <div class="progress-bar" role="progressbar"
                 aria-valuenow="<?php if (isset($percentage)) echo $percentage ?>" aria-valuemin="0" aria-valuemax="100"
                 style="width: <?php if (isset($percentage)) echo $percentage; ?>%">
                <span><?php if (isset($percentage)) echo $percentage ?>%</span>
            </div>
        </div>
    </ul>

</div>