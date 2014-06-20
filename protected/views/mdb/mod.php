<?php /* @var $mod Mdb */ ?>
<?php /* @var $english_mod EnglishMdb */ ?>

<?php

if (!is_null($english_mod) && Yii::app()->language == 'en') {
    $mod->name = $english_mod->name;
    $mod->description = $english_mod->description;
}

$this->breadcrumbs = array(
    Yii::t('translations', 'Мдб Вики') => array('/wiki'),
    Yii::t('translations', 'Моды') => array('/wiki/mods/list'),
    $mod->name
);
?>

<div class="pageTitle"><?php echo CHtml::encode($mod['name']) ?></div>

<div class="mdb">

    <div class="entity_menu">
        <ul>
            <li>
                <a href="#description"><?php echo Yii::t('translations', 'Описание') ?></a>
            </li>
            <li>
                <a href="#installation"><?php echo Yii::t('translations', 'Установка') ?></a>
            </li>
            <li>
                <a href="#commands"><?php echo Yii::t('translations', 'Команды') ?></a>
            </li>
        </ul>
    </div>

    <div class="entity">

        <div class="pre">
            <p>
                <b><?php echo Yii::t('translations', 'Последняя версия') ?></b>:
                <?php echo $mod->getLast_version(); ?>
            </p>

            <a class="btn" href="<?php echo $mod->getDownload_url(); ?>">
                <?php echo Yii::t('translations', 'Скачать') ?>
            </a>

        </div>

        <div id="description" class="description">
            <h1><?php echo Yii::t('translations', 'Описание') ?></h1>
            <?php echo nl2br(CHtml::encode($mod->getDescription())); ?>
        </div>

        <div id="installation" class="setup">
            <h1><?php echo Yii::t('translations', 'Установка') ?></h1>
            <?php echo nl2br(CHtml::encode($mod->getHowtoInstall())); ?>
        </div>

        <h1><?php echo Yii::t('translations', 'Команды'); ?></h1>

        <div id="commands" class="permissions">
            <div class="table">
                <table border="0">
                    <tr>
                        <td class="head"><?php echo Yii::t('translations', 'Команда'); ?></td>
                        <td class="head"><?php echo Yii::t('translations', 'Параметр'); ?></td>
                        <td class="head"><?php echo Yii::t('translations', 'Право'); ?></td>
                        <td class="head"><?php echo Yii::t('translations', 'Описание'); ?></td>
                    </tr>
                    <?php
                    if (!is_null($commands))
                        foreach ($commands as $key => $value) {
                            $this->renderPartial('_permissions_line', array(
                                'command' => $value
                            ));
                        }
                    ?>
                </table>
            </div>
        </div>

    </div>

</div>
