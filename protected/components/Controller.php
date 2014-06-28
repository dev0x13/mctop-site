<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */

class Controller extends CController
{

    public $pageTitle;

    public $lang;

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function init()
    {

        if (!Yii::app()->user->isGuest) {

                $last_update = date('Y-m-d H:i:s', time());
                Yii::app()->session['last_update'] = $last_update;

				$user = Users::model()->findByPk(Yii::app()->user->id);
				$user->last_update = new CDbExpression('NOW()');
				$user->save();
                           
        } else {
            $user_country = Yii::app()->SxGeo->getCountry($_SERVER['REMOTE_ADDR']);
            if ($user_country != 'ru' and $user_country != 'ua' and $user_country != 'by')
                Yii::app()->language = 'en';
        }

        if (isset(Yii::app()->session['lang'])) {
            Yii::app()->language = Yii::app()->session['lang'];
        }

        parent::init();
    }

    public function core()
    {
        return $this->core;
    }

}