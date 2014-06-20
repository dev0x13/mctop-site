<?php

Class LazyEntities extends CWidget
{

    public $view;
    public $entity_name;
    public $entities;
    public $additional;

    public function run()
    {
        if (!empty($this->entities)) {
            foreach ($this->entities as $entitiy) {
                Yii::app()->getController()->renderPartial($this->view, array(
                    $this->entity_name => $entitiy,
                    'additional' => $this->additional
                ));
            }
        }
    }

}