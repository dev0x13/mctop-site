<?php

/**
 * This is the model class for table "guilds_news".
 *
 * The followings are the available columns in table 'guilds_news':
 * @property string $pid
 * @property string $author
 * @property string $name
 * @property string $text
 * @property string $tags
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Users $author0
 * @property Projects $p
 */
class GuildsNews extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'guilds_news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pid, author, name, text, tags, date', 'required'),
            array('pid, author', 'length', 'max' => 10),
            array('name', 'length', 'max' => 255),
            array('tags', 'length', 'max' => 512),
            // The following rule is used by search().
            array('pid, author, name, text, tags, date', 'safe', 'on' => 'search'),
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
            'p' => array(self::BELONGS_TO, 'Projects', 'pid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pid' => 'Pid',
            'author' => Yii::t('translations', 'Автор'),
            'name' => Yii::t('translations', 'Название'),
            'text' => Yii::t('translations', 'Содержание новости'),
            'tags' => Yii::t('translations', 'Теги новости'),
            'date' => Yii::t('translations', 'Дата публикации'),
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

        $criteria->compare('pid', $this->pid, true);
        $criteria->compare('author', $this->author, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('tags', $this->tags, true);
        $criteria->compare('date', $this->date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GuildsNews the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function beforeValidate()
    {
        if (isset($_POST['GuildsNews']['tags'])) {
            $this->tags = HUtils::TransformToString(HUtils::Parse($_POST['GuildsNews']['tags']));
        }

        if ($this->isNewRecord)
            $this->date = date('Y-m-d H:i:s', time());

        return parent::beforeValidate();
    }
}
