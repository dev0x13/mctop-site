<div class="advert">
    <div class="row stats_table">
        <div class="col-md-3">
            <div class="title">
                <a href="/advert/edit/<?php echo $advert->id ?>"><?php echo $advert->name; ?></a>
            </div>
        </div>
        <div
            class="col-md-2"><?php echo $advert->displayed ? Yii::t('translations', 'Запущено') : Yii::t('translations', 'Приостановлено') ?></div>
        <div
            class="col-md-1"><?php echo $advert->redisRecord->get_ctr();; ?>
            %
        </div>
        <div class="col-md-2"><?php echo $advert->redisRecord->get_clicks();?></div>
        <div class="col-md-2"><?php echo $advert->redisRecord->get_views();?></div>
        <div class="col-md-2" id="money_<?php echo $advert->id; ?>"><?php echo round($advert->redisRecord->get_balance(),3);?></div>
    </div>
</div>