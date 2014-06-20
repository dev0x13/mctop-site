<?php

class WAdvert extends CWidget
{
    public $type;

    public function run()
    {
        if (!is_null($advert = Adverts::model()->getAdvertByType($this->type)))
        {
            echo '<div class="raj">' . CHtml::link(CHtml::image($advert->getImage()), $advert->getUrl()) . '</div>';
        }

    }
}
