<?php /* @var $result Mdb */ ?>
<?php
if ($result->type == Mdb::TYPE_MOD)
    $type = 'mods';
else
    $type = 'plugins';
?>

<div class="result" onclick="javascript:window.location = '/wiki/<?php echo $type; ?>/<?php echo $result->id; ?>'">

    <div class="name">
        <?php echo $result->name; ?>
    </div>

</div>
