<?php /* @var $plugin Mdb */ ?>
<?php /* @var $english_plugin EnglishMdb */ ?>

<?php

if (!is_null($english_plugin) && Yii::app()->language == 'en') {
    $plugin->name = $english_plugin->name;
    $plugin->description = $english_plugin->description;
}

$this->breadcrumbs = array(
    Yii::t('translations', 'Мдб Вики') => array('/wiki'),
    Yii::t('translations', 'Плагины') => array('/wiki/plugins/list'),
    $plugin->name
);

?>

<div class="pageTitle">
    <?php
    echo CHtml::encode($plugin['name'])
    ?>
</div>

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
                <?php echo $plugin->getLast_version(); ?>
            </p>

            <a class="btn" href="<?php echo $plugin->getDownload_url(); ?>">
                <?php echo Yii::t('translations', 'Скачать') ?>
            </a>

        </div>

        <div id="description" class="description">
            <h1><?php echo Yii::t('translations', 'Описание') ?></h1>
            <?php echo nl2br(CHtml::encode($plugin->getDescription())); ?>
        </div>

        <div id="installation" class="setup">
            <h1><?php echo Yii::t('translations', 'Установка') ?></h1>
            <?php echo nl2br(CHtml::encode($plugin->getHowtoInstall())); ?>
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
                    if (isset($commands))
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
