<?php /* @var $image Images */ ?>
<?php
if ($additional == 1)
    $class = 'image_one';
elseif ($additional == 2)
    $class = 'image_two';
else
    $class = 'image';
?>
<div class="<?php echo $class ?>">
    <a href="<?php echo $image->getValidLinkForSRC(); ?>" title="<?php echo $image->name; ?>" data-dialog>
        <?php echo '<img ' . 'class="img-responsive"' . ' src="' . $image->getValidLinkForSRC() . '"/>'; ?>
    </a>
</div>