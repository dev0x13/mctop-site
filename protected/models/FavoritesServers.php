<?php

/**
 * This is the model class for table "favorites_servers".
 *
 * The followings are the available columns in table 'favorites_servers':
 * @property string $user
 * @property string $servers
 *
 * The followings are the available model relations:
 * @property Users $user0
 */
class FavoritesServers extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'favorites_servers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user', 'required'),
            array('user', 'length', 'max' => 10),
            array('user, servers', 'safe', 'on' => 'search'),
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
            'user' => 'User',
            'servers' => 'Servers',
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

        $criteria->compare('user', $this->user, true);
        $criteria->compare('servers', $this->servers, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FavoritesServers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function deleteServerFromFavorites($id)
    {
        $servers = HUtils::Parse($this->servers);
        foreach ($servers as $key => $server) {
            if ($server == $id)
                unset($servers[$key]);
        }
        $this->servers = HUtils::TransformToString($servers);
        $this->save();
    }
}
