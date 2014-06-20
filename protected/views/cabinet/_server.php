<div class="server">
    <div class="title">
        <?php echo $server->title; ?>
    </div>
    <?php
    if ($server->isServerRecommendedOrWas()) {
        if ($server->isRecommendationIsEnded())
            echo 'ended';
    }
    echo $server->getCabinetRecommendedStatusMessage();
    ?>
</div>