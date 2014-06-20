<?php

/**
 * This is the model class for table "balance_users".
 *
 * The followings are the available columns in table 'balance_users':
 * @property string $id
 * @property double $balance
 *
 * The followings are the available model relations:
 * @property Users $u
 */
class BalanceUsers extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'balance_users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, balance', 'required'),
            array('balance', 'numerical'),
            array('id', 'length', 'max' => 10),
            // The following rule is used by search().
            array('id, balance', 'safe', 'on' => 'search'),
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
            'u' => array(self::BELONGS_TO, 'Users', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'id',
            'balance' => 'Balance',
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
        $criteria->compare('balance', $this->balance);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BalanceUsers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function findByPk($pk, $condition = '', $params = array())
    {
        if (BalanceUsers::model()->exists('id=:id', array(':id' => $pk))) {
            Yii::trace(get_class($this) . '.findByPk()', 'system.db.ar.CActiveRecord');
            $prefix = $this->getTableAlias(true) . '.';
            $criteria = $this->getCommandBuilder()->createPkCriteria($this->getTableSchema(), $pk, $condition, $params, $prefix);
            return $this->query($criteria);
        }
        $account = new BalanceUsers();
        $account->id = $pk;
        $account->balance = 0;
        $account->save();
        return $account;
    }

    public static function getUserBankAccount($user = null)
    {
        if (is_null($user))
            $user = Yii::app()->user->id;
        return BalanceUsers::model()->findByPk($user);
    }

}
