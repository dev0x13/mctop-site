<?php /* @var $server Servers */ ?>
<div id="server_<?php echo $server->id ?>" class="server">
    <a href="/rating/server/<?php echo $server['id']; ?>"><?php echo $server['title']; ?></a>
</div>


<script>
    $(function () {
        $('#server_<?php echo $server->id?>').qtip({
            style: {
                classes: 'qtip-orange qtip-shadow',
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
                            if (data.mods)
                                content += '<b><?php echo Yii::t('translations','Моды')?></b>: ' + data.mods + '<br>';
                            if (data.online)
                                content += '<b><?php echo Yii::t('translations','Игроки')?></b>: ' + data.online +'/'+ data.slots + '<br>';
                            if (data.avg_online)
                                content += '<b><?php echo Yii::t('translations','Средний онлайн')?></b>: ' + data.avg_online + '<br>';

                            if (data.uptime)
                                content += 'Uptime: ' + data.uptime + '%<br>';
                            // Now we set the content manually (required!)
                            api.set('content.title', data.title);
                            api.set('content.text', content);
                        }, function (xhr, status, error) {
                            // Upon failure... set the tooltip content to the status and error value
                            api.set('content.text', status + ': ' + error);
                        });

                    return 'Loading...' // Set some initial loading text
                }
            }
        });
    });
</script>