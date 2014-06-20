<?php
if (isset($_GET['pid']))
    $id = (int)$_GET['pid'];
if (isset($_GET['id']))
    $id = (int)$_GET['id'];
?>
<div class="tag">
    <a href="/projects/guild/<?php echo $id ?>/news_with_tag/<?php echo urlencode($tag); ?>">#<?php echo $tag; ?></a>
</div>