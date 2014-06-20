<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle .= ' - Импортирование проекта и серверов с MCTop.su';
?>

<div class="pageTitle">Импортирование проекта и серверов с MCTop.su</div>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'events-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data')
    ));

    echo $form->hiddenField($project, 'register_stage', array('value' => 'finally'));
    echo CHtml::submitButton('Завершить регистрацию');

    $DBmods = ServersMods::model()->findAll();
    $DBversions = ServersVersions::model()->findAll();
    $DBtypes = ServersTypes::model()->findAll();

    foreach ($servers as $key => $server) {

        if (!Servers::model()->exists('address=:address', array(':address' => $server->address))) {
            $this->renderPartial('_server', array(
                'model' => $server,
                'DBmods' => $DBmods,
                'DBversions' => $DBversions,
                'DBtypes' => $DBtypes,
            ));
        }

    }
    ?>

    <?php
    $this->endWidget();
    ?>

    <script>
        function deleteServer(name) {
            $(function () {
                $("#" + name).remove();
            });
        }
    </script>