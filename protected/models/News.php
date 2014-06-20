<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property string $id
 * @property string $title
 * @property integer $category
 * @property string $few_words
 * @property string $full
 * @property string $author
 * @property string $date
 * @property string $tags
 *
 * The followings are the available model relations:
 * @property Users $author0
 * @property NewsCategories $category0
 */
class News extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, category, few_words, full, author, date', 'required'),
            array('category', 'numerical', 'integerOnly' => true),
            array('title, few_words', 'length', 'max' => 255),
            array('author', 'length', 'max' => 10),
            // The following rule is used by search().
            array('id, title, category, few_words, full, author, date, tags', 'safe', 'on' => 'search'),
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
            'author0' => array(self::BELONGS_TO, 'Users', 'author'),
            'category0' => array(self::BELONGS_TO, 'NewsCategories', 'category'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'category' => 'Category',
            'few_words' => 'Few Words',
            'full' => 'Full',
            'author' => 'Author',
            'date' => 'Date',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('category', $this->category);
        $criteria->compare('few_words', $this->few_words, true);
        $criteria->compare('full', $this->full, true);
        $criteria->compare('author', $this->author, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('tags', $this->tags, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return News the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
