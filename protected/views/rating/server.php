<?php /* @var $server Servers */ ?>

<?php
$this->breadcrumbs = array(
    Yii::t('translations', 'Рейтинг') => array('/rating'),
    $server->project0->title => array('/rating/project/' . $server->project0->id),
    $server->title
);
?>

<div class="pageTitle"><?php echo CHtml::encode($server['title']) ?></div>

<div class="project">

<a href="/rating/out/<?php echo $server->project0->id ?>"><?php echo $server->project0->site ?></a>

<div class="description">
    <?php
    if (Yii::app()->language == 'en')
        $english_description = EnglishServer::model()->findByPk($server->id);

    if (isset($english_description)) {
        if (isset($english_description) and Yii::app()->language == 'en')
            echo CHtml::encode($english_description->description);
    } else
        echo CHtml::encode($server['description']);
    ?>
</div>

<div class="buttons">
    <a class="btn btn-success"
       href="/rating/vote/<?php echo $server->project ?>"><?php echo Yii::t('translations', 'Проголосовать'); ?></a>

    <a class="btn btn-info"
       href="/rating/server/<?php echo $server->id ?>/gallery"><?php echo Yii::t('translations', 'Галерея сервера') ?></a>

    <div id="qtip-growl-container"></div>

    <?php if (!Yii::app()->user->isGuest): ?>
    <a class="btn btn-info" id="favoriteBtn"
       onclick="createGrowl()"><?php echo $server->inFavorites() ? Yii::t('translations', 'Удалить сервер из избранных') : Yii::t('translations', 'Добавить сервер в избранные') ?></a>
</div>


<script>
    var ServerFavorited = <?php echo ($server->inFavorites())? 1 : 0;?>;
    var title = '';

    window.createGrowl = function (persistent) {

        if (!ServerFavorited) {
            title = "<?php echo Yii::t('translations','Сервер добавлен в список избранных');?>";
            $("#favoriteBtn").text("<?php echo Yii::t('translations','Удалить сервер из избранных');?>");
            $.ajax({
                type: "POST",
                url: "/rating/server/<?php echo $server->id ?>/favoriteit",
            });
        }

        else {
            title = "<?php echo Yii::t('translations','Сервер удален из списка избранных');?>";
            $("#favoriteBtn").text("<?php echo Yii::t('translations','Добавить сервер в избранные');?>");
            $.ajax({
                type: "POST",
                url: "/rating/server/<?php echo $server->id ?>/unfavoriteit",
            });
        }


        ServerFavorited = !ServerFavorited;
        var target = $('.qtip.jgrowl:visible:last');

        $('<div/>').qtip({
            content: {
                text: title,
                title: {
                    text: '<span class="glyphicon glyphicon-envelope"></span> <?php echo Yii::t('translations','Уведомление');?>',
                    button: true
                }
            },
            position: {
                target: [0, 0],
                container: $('#qtip-growl-container')
            },
            show: {
                event: false,
                ready: true,
                effect: function () {
                    $(this).stop(0, 1).animate({ height: 'toggle' }, 400, 'swing');
                },
                delay: 0,
                persistent: persistent
            },
            hide: {
                event: false,
                effect: function (api) {
                    $(this).stop(0, 1).animate({ height: 'toggle' }, 400, 'swing');
                }
            },
            style: {
                width: 250,
                classes: 'jgrowl',
                tip: false
            },
            events: {
                render: function (event, api) {

                    if (!api.options.show.persistent) {
                        $(this).bind('mouseover mouseout', function (e) {
                            var lifespan = 5000;

                            clearTimeout(api.timer);
                            if (e.type !== 'mouseover') {
                                api.timer = setTimeout(function () {
                                    api.hide(e)
                                }, lifespan);
                            }
                        })
                            .triggerHandler('mouseout');
                    }
                }
            }
        });
    }

</script>

<?php endif ?>

<hr>

<div class="servers">

    <div class="main_info">

        <table border="1">
            <tr>
                <td><?php echo Yii::t('translations', 'Адрес') ?></td>
                <td>
                    <div class="form-group has-success has-feedback">
                        <input type="text" class="form-control" id="server_<?php echo $server->id ?>"
                               value="<?php echo $server->address; ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td>Whitelist</td>
                <td><?php echo $server->whitelist(); ?></td>
            </tr>
            <tr>
                <td><?php echo Yii::t('translations', 'Онлайн на сервере') ?></td>
                <td><?php echo $server_redis->get_players_online();?></td>
            </tr>
            <tr>
                <td><?php echo Yii::t('translations', 'Клиент') ?></td>
                <td><?php echo $server->own_client() ?></td>
            </tr>
            <tr>
                <td><?php echo Yii::t('translations', 'Лицензия') ?></td>
                <td><?php echo $server->license() ?></td>
            </tr>
            <tr>
                <td><?php echo Yii::t('translations', 'Версия') ?></td>
                <td><?php echo $server->version() ?></td>
            </tr>

        </table>

    </div>


    <div class="label"><?php echo Yii::t('translations', 'Типы') ?></div>
    <div class="types">
        <?php

        $types = HUtils::Parse($server->type);

        if (!empty($types)) {
            foreach ($types as $key => $type) {
                $types[$key] = ServersTypes::model()->findByPk($type);
            }

            $this->beginWidget('LazyEntities', array(
                'view' => 'server_type',
                'entity_name' => 'type',
                'entities' => $types,
            ));
            $this->endWidget();
        }

        ?>
    </div>

    <div class="label"><?php echo Yii::t('translations', 'Моды') ?></div>

    <div class="mods">
        <?php

        $mods = HUtils::Parse($server->mods);

        if (!empty($mods)) {
            foreach ($mods as $key => $mod) {
                $mods[$key] = ServersMods::model()->findByPk($mod);
            }
            $this->beginWidget('LazyEntities', array(
                'view' => 'server_mod',
                'entity_name' => 'mod',
                'entities' => $mods,
            ));
            $this->endWidget();
        } else
            echo Yii::t('translations', 'Сервер не имеет модов');


        ?>
    </div>

</div>

<?php $this->beginWidget('CommentsWidget', array(
    'entities' => $comments,
    'additional' => $model
));
$this->endWidget();?>


</div>