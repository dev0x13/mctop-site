<?php /* @var $server Servers */ ?>
<div id="server_<?php echo $server->id; ?>" class="result"
     onclick="javascript:window.location = '/rating/server/<?php echo $server->id; ?>'">
    <div class="country"><img src="/static/img/flags/<?php echo $countries[$server->project0->country - 1]; ?>.png">
    </div>
    <a href="/rating/server/<?php echo $server->id; ?>"><?php echo $server['title']; ?></a><br>
    <?php //avg_online: <?php echo $server->avg_online?>
    <?php //echo Yii::t('translations','Статус')?> <?php //echo $server->getStatus()?>
</div>

<script>
    $(function () {
        $('#server_<?php echo $server->id?>').qtip({
            style: {
                classes: 'qtip-dark qtip-shadow',
                tip: {
                    corner: false
                }
            },
            content: {
                text: function (event, api) {
                    $.ajax({
                        url: '/api/getserver/<?php echo $server->id?>', // URL to the JSON file
                        type: 'GET', // POST or GET
                        dataType: 'json' // Tell it we're retrieving JSON
                    })
                        .then(function (data) {
                            /* Process the retrieved JSON object
                             *    Retrieve a specific attribute from our parsed
                             *    JSON string and set the tooltip content.
                             */
                            var content = '<b><?php echo Yii::t('translations','Версия')?></b>: ' + data.version + '<hr>';
                            content += '<b><?php echo Yii::t('translations','Типы')?></b>: ' + data.type + '<br>';
                            if (data.mods.length > 0)
                                content += '<b><?php echo Yii::t('translations','Моды')?></b>: ' + data.mods + '<br>';
                            if (data.online)
                                content += '<b><?php echo Yii::t('translations','Игроки')?></b>: ' + data.online +'/'+ data.slots + '<br>';
                            if (data.online)
                                content += '<b><?php echo Yii::t('translations','Онлайн')?></b>: ' + data.online + '<br>';
                            if (data.avg_online)
                                content += '<b><?php echo Yii::t('translations','Средний онлайн')?></b>: ' + data.avg_online + '<br>';
                            // Now we set the content manually (required!)
                            api.set('content.title', data.title);
                            api.set('content.text', content);
                        }, function (xhr, status, error) {
                            // Upon failure... set the tooltip content to the status and error value
                            api.set('content.text', status + ': ' + error);
                        });

                    return 'Loading...' // Set some initial loading text
                }
            },
            position: {
                my: 'left top'
            }
        });
    });
</script>