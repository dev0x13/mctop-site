<?php

Class CommentsWidget extends CWidget
{

    public $view;
    public $entity_name;
    public $entities;
    public $additional;

    public function run()
    {

        Yii::app()->getController()->renderPartial('../_comments/form', array(
            'model' => $this->additional
        ));

        if (!empty($this->entities)) {
            echo '<div class="comments">';
            foreach ($this->entities as $entity) {
                Yii::app()->getController()->renderPartial('../_comments/comment', array(
                    'comment' => $entity,
                    'additional' => $this->additional
                ));
            }
            echo '</div>';
        }
    }
}
