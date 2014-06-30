<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property string $id
 * @property string $user
 * @property string $name
 * @property string $filename
 * @property string $size
 * @property string $width
 * @property string $height
 *
 * @property CUploadedFile $image
 *
 * The followings are the available model relations:
 * @property Users $user0
 */
class Images extends CActiveRecord
{

    const USING_NONE = 0;
    const USING_AS_PROJECT_BANNER = 1;
    const USING_AS_ADVERT_BANNER = 2;
    const USING_IN_GALLERY = 3;

    public $image;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'images';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user, name, filename', 'required'),
            array('user', 'length', 'max' => 10),
            array('image', 'file', 'types' => 'jpg, gif, png', 'on' => 'add'),
            array('name', 'length', 'max' => 30),
            array('filename', 'length', 'max' => 255),
            // The following rule is used by search().
            array('id, user, name, filename', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user0' => array(self::BELONGS_TO, 'Users', 'user'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user' => 'User',
            'name' => 'Name',
            'filename' => 'Filename',
            'width' => 'width',
            'height' => 'height',
            'size' => 'size',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user', $this->user, true);
        $criteria->compare('name', $this->filename, true);
        $criteria->compare('filename', $this->filename, true);
        $criteria->compare('width', $this->filename, true);
        $criteria->compare('height', $this->filename, true);
        $criteria->compare('size', $this->filename, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Images the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getValidLinkForSRC()
    {
        return '/static/uploaded/u' . $this->user . '/' . $this->filename;
    }

    public function beforeValidate()
    {

        if (!file_exists(root . '/static/uploaded/u' . Yii::app()->user->id))
            mkdir(root . '/static/uploaded/u' . Yii::app()->user->id, 0777);

        $this->user = Yii::app()->user->id;

        if (isset($this->image)) {
            $this->name = $this->image->name;
            $this->filename = md5(time() . 'image:' . $this->image->name) . '.' . $this->getImageExtension();
            if (empty(Yii::app()->session['provider']))
                $size = getimagesize($this->image->tempName);
            else
                $size = 0;
            $this->width = $size[0];
            $this->height = $size[1];
            if (empty(Yii::app()->session['provider']))
                $this->size = filesize($this->image->tempName);
            else
                $size = 0;
        }

        if (strlen($this->name) > 30)
            $this->name = substr($this->name, 0, 30);

        if (!empty(Yii::app()->session['provider']))
            $this->user = Yii::app()->session['mctop_register_user_id'];

        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        return parent::afterValidate();
    }


    public static function getUserImagesWithPages($user)
    {
        $ret = array();
        $criteria = new CDbCriteria();
        $criteria->condition = 'user=:user';
        $criteria->order = 'id desc';
        $criteria->params = array(':user' => $user);
        $pages = new CPagination(Images::model()->count($criteria));
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $ret['pages'] = $pages;
        $ret['images'] = Images::model()->findAll($criteria);
        return $ret;
    }

    public static function getUserImage($user, $image_id)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'user=:user and id=:id';
        $criteria->params = array(':user' => $user, ':id' => $image_id);
        return Images::model()->find($criteria);
    }

    public static function isUsingAsBanner(Images $image)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'banner=:banner';
        $criteria->params = array(':banner' => '/static/uploaded/u' . $image->user . '/' . $image->filename);
        $check = Projects::model()->exists($criteria);
        return $check;
    }

    public static function isAlreadyUsingInGallery(Images $image, $server = null, $image_ids_to_check = null)
    {
        if (is_null($image_ids_to_check) && $server != null)
            $image_ids_to_check = Images::getServerImagesIds($server);

        if (!is_null($image_ids_to_check))
            if (in_array($image->id, $image_ids_to_check))
                return true;
            else
                return false;

    }

    public function isUsingInGallery()
    {
        $connection = Yii::app()->db;
        $command = $connection->createCommand("select * from servers where images like '%:" . (int)$this->id . "%'");
        $check = $command->queryAll();
        if (sizeof($check) == 0)
            return false;
        else
            return true;
    }

    public static function isUsingAsAdvertBanner(Images $image)
    {
        die();
        $criteria = new CDbCriteria();
        $criteria->condition = 'image=:image';
        $criteria->params = array(':image' => '/static/uploaded/u' . $image->user . '/' . $image->filename);
        $check = Adverts::model()->exists($criteria);
        return $check;
    }

    public static function findWhereUsing(Images $image, $select = '*')
    {
        $connection = Yii::app()->db;
        $command = $connection->createCommand("select " . $select . " from servers where images like '%:" . (int)$image->id . "%'");
        $servers = $command->queryAll();
        return $servers;
    }


    public static function getByIds($array_of_ids)
    {
        $images = array();
        foreach ($array_of_ids as $image) {
            $images[] = Images::model()->findByPk($image);
        }
        return $images;
    }

    public static function getServerImages(Servers $server)
    {
        return Images::getByIds(HUtils::Parse($server->images));
    }

    public static function getServerImagesARRAY($server)
    {
        return Images::getByIds(HUtils::Parse($server['images']));
    }

    public static function getServerImagesIds(Servers $server)
    {
        return HUtils::Parse($server->images);
    }

    public static function rename($image_id, $new_name)
    {

        $image = Images::model()->findByPk($image_id);

        if (is_null($image) or $image->user != Yii::app()->user->id)
            throw new CHttpException(404, Yii::t('translations', 'entity не найдено', array('entity' => Yii::t('translations', 'Изображение'))));

        $image->name = $new_name;

        if ($image->save()) {
            Yii::app()->end();
        } else {
            //Stops the request from being sent.
            throw new CHttpException(404, 'Model has not been saved');
        }
    }

    public static function deleteFromGalleries(Images $image)
    {
        $servers = Images::findWhereUsing($image, 'id');
        $deletions = 0;
        foreach ($servers as $server) {
            $server = Servers::model()->findByPk($server);
            $server_images = HUtils::Parse($server->images);
            unset($server_images[array_search($image->id, $server_images)]);
            $server->images = HUtils::TransformToString($server_images);
            $server->save();
            unlink(root . '/static/uploaded/u' . $image->user . '/' . $image->filename);
            $image->delete();
            $deletions++;
        }
        if ($deletions == sizeof($servers))
            return 1;
        else
            throw new CHttpException(500, Yii::t('translations', 'Что-то пошло не так. Сообщите администрации рейтинга об этой ошибке.'));
    }

    public function getImageExtension()
    {
        return substr($this->name, strlen($this->name) - 3, 4);
    }

    public static function getImageSize($size, $type)
    {

        if ($type == 'kb')
            return round($size / 1024, 2) . Yii::t('translations', 'Кб');
        if ($type == 'mb')
            return round($size / 1024 / 1024, 2) . Yii::t('translations', 'Мб');

    }

    public function canBeBanner()
    {
        if (empty(Yii::app()->session['provider'])) {
            if ($this['image'] instanceof CUploadedFile) {
                $size = getimagesize($this['image']->tempName);
                return ($size[0] == 468 && $size[1] == 60 && $this['image']->getSize() <= Yii::app()->params['images']['maxBannerWeight']);
            } else
                if (gettype($this['image']) == 'object')
                    return ($this->width == 468 && $this->height == 60 && $this['image']->size <= Yii::app()->params['images']['maxBannerWeight']);
        }

        return 1;

    }

    public function checkForBannerSetPossibilityInImageList()
    {
        return ($this->width == 468 && $this->height == 60);
    }

    public function canBeAdvertBanner($type)
    {
        if (get_class($this->image) == 'CUploadedFile') {
            $size = getimagesize($this->image->tempName);
            if ($type == Adverts::POSITION_HEAD)
                return ($size[0] == 728 && $size[1] == 90) ? 1 : 0;
            else
                return ($size[0] == 468 && $size[1] == 60) ? 1 : 0;
        } else
            if ($type == Adverts::POSITION_HEAD)
                return ($this->width == 728 && $this->height == 90) ? 1 : 0;
            else
                return ($this->width == 468 && $this->height == 60) ? 1 : 0;

    }

    public function deleteImage()
    {
        if(file_exists((root . '/static/uploaded/u' . Yii::app()->user->id . '/' . $this->filename)))
        {
            unlink(root . '/static/uploaded/u' . Yii::app()->user->id . '/' . $this->filename);
        }
        $this->delete();
        return 1;
    }

    public function makeBannerToProject($user)
    {

        $projects = Projects::getUserProjects($user);

        if (!empty($projects)) {
            $_projects = array();
            foreach ($projects as $project) {
                if ($project->checkUserRights($user, 'project_edit'))
                    $_projects[] = $project;
            }

            Yii::app()->getController()->renderPartial('_makeBanner', array(
                'projects' => $_projects,
                'image' => $this
            ));
        }

    }

    public function addToServerGallery($user)
    {
        $projects = Projects::getUserProjects($user);

        if (!empty($projects)) {
            $_projects = array();
            foreach ($projects as $project) {
                if ($project->checkUserRights($user, 'project_edit'))
                    $_projects[] = $project;
            }

            Yii::app()->getController()->renderPartial('_addToServerGallery', array(
                'projects' => $_projects,
                'image' => $this
            ));
        }
    }


}
