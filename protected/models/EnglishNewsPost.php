<?php

/**
 * This is the model class for table "english_news_post".
 *
 * The followings are the available columns in table 'english_news_post':
 * @property string $post
 * @property string $title
 * @property string $few_words
 * @property string $full
 * @property string $tags
 *
 * The followings are the available model relations:
 * @property News $post0
 */
class EnglishNewsPost extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'english_news_post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('post, title, few_words, full, tags', 'required'),
            array('post', 'length', 'max' => 10),
            array('title, few_words, tags', 'length', 'max' => 255),
            array('post, title, few_words, full, tags', 'safe', 'on' => 'search'),
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
            'original_post' => array(self::BELONGS_TO, 'News', 'post'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'post' => 'Post',
            'title' => 'Title',
            'few_words' => 'Few Words',
            'full' => 'Full',
            'tags' => 'Tags',
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

        $criteria->compare('post', $this->post, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('few_words', $this->few_words, true);
        $criteria->compare('full', $this->full, true);
        $criteria->compare('tags', $this->tags, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EnglishNewsPost the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function findByPk($pk, $condition = '', $params = array())
    {
        Yii::trace(get_class($this) . '.findByPk()', 'system.db.ar.CActiveRecord');
        $prefix = $this->getTableAlias(true) . '.';
        $criteria = $this->getCommandBuilder()->createPkCriteria($this->getTableSchema(), $pk, $condition, $params, $prefix);
        $result = $this->query($criteria);
        if (is_null($result))
            return new EnglishNewsPost();
        else
            return $result;
    }
}
