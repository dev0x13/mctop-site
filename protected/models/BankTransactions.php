<?php

/**
 * This is the model class for table "bank_transactions".
 *
 * The followings are the available columns in table 'bank_transactions':
 * @property string $id
 * @property string $user
 * @property integer $type
 * @property string $description
 * @property integer $result
 * @property string $time
 * @property string $id_in_system
 * @property integer $system
 * @property string $ip
 *
 * The followings are the available model relations:
 * @property Users $user0
 */
class BankTransactions extends CActiveRecord
{

    const TYPE_IN = 0;
    const TYPE_OUT = 1;

    const TRANSACTION_WITHDRAW_MONEY_FOR_ADVERT = 1;
    const TRANSACTION_ON_RETURNING_MONEY_FOR_ADVERT = 2;
    const TRANSACTION_USER_INCREMENT_BALANCE = 3;
    const TRANSACTION_USER_PURCHASED_RECOMMENDED_SERVER_PLACE = 4;

    const PaymentSystemMCTop = 1;
    const PaymentSystemUnitpay = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'bank_transactions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user, type, description, result, system, ip', 'required'),
            array('type, result', 'numerical', 'integerOnly' => true),
            array('user', 'length', 'max' => 10),
            array('description', 'length', 'max' => 512),
            // The following rule is used by search().
            array('id, user, type, description, result', 'safe', 'on' => 'search'),
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
            'type' => 'Type',
            'description' => 'Description',
            'result' => 'Result',
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
        $criteria->compare('type', $this->type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('result', $this->result);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BankTransactions the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getUserTransactions($user)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'user=:user';
        $criteria->params = array(':user' => $user);
        $criteria->order = 'id desc';
        return BankTransactions::model()->findAll($criteria);
    }

    public function isSuccessTransaction()
    {

    }

    public function beforeSave()
    {
        if (is_null($this->id_in_system = BankTransactions::model()->count()))
            $this->system = self::PaymentSystemMCTop;
        $this->ip = $_SERVER['REMOTE_ADDR'];
        return parent::beforeSave();
    }

    public static function generateProjectTransactionDescription(Adverts $advert, $balance_before, $balance_after, $convert_info)
    {
        $description = array();
        $description['type'] = self::TRANSACTION_WITHDRAW_MONEY_FOR_ADVERT;
        if (isset($advert->additional_info['new_balance']))
            $description['text'] = 'Конвертация типов';
        else
            $description['text'] = 'Оплата за рекламу проекта';

        if ($advert->isNewRecord)
            $description['pid'] = $advert->payer['id'];
        else
            $description['pid'] = $advert->payer_id;

        $description['cost'] = $advert->cost;
        $description['balance_before'] = $balance_before;
        $description['balance_after'] = $balance_after;


        if (is_array($convert_info))
            foreach ($convert_info as $key => $info)
                $description[$key] = $info;

        return HUtils::json_encode_cyr($description);
    }

    public static function generateTransactionToReturn(Adverts $advert, $balance_before, $balance_after, $convert_info, $payer_type = 'project')
    {
        $description = array();
        $description['type'] = self::TRANSACTION_ON_RETURNING_MONEY_FOR_ADVERT;
        $description['text'] = 'Возврат денег за рекламу';
        $description[$payer_type] = $advert->payer_id;
        $description['amount'] = $advert->cost;
        $description['balance_before'] = $balance_before;
        $description['balance_after'] = $balance_after;

        if (is_array($convert_info))
            foreach ($convert_info as $key => $info)
                $description[$key] = $info;

        return HUtils::json_encode_cyr($description);
    }

    public function getLastUserTransaction($user = null)
    {
        if (is_null($user))
            $user = Yii::app()->user->id;

        $criteria = new CDbCriteria();
        $criteria->order = 'time desc';
        $criteria->condition = 'user=:user';
        $criteria->params = array(':user' => $user);

        return BalanceUsers::model()->find($criteria);
    }

    public function initInvoiceRegistration()
    {
        $params = $_GET['params'];

        if (isset($_GET['method']))
            $method = $_GET['method'];

        if (isset($method))
            if ($method == 'pay') {
                $user = $params['account'];
                $date = $params['date'];
                $operator = $params['operator'];
                $paymentType = $params['paymentType'];
                $sum = $params['sum'];
                $sign = $params['sign'];
                $unitpayId = $params['unitpayId'];

                $transaction = new BankTransactions();
                $description = array(
                    'type' => 'bank',
                    'text' => 'Пополнение счета личного кабинета',
                    'operator' => $operator,
                    'paymentType' => $paymentType,
                    'sum' => $sum,
                    'unitpayId' => $unitpayId,
                    'sign' => $sign,
                );

                $transaction->description = HUtils::json_encode_cyr($description);
                $transaction->user = $user;
                $transaction->type = BankTransactions::TRANSACTION_USER_INCREMENT_BALANCE;
                $transaction->time = $date;
                return $transaction;
            }

    }

    public function registerInvoice($result = null)
    {
        $this->result = $result;
        return $this->save() ? true : false;
    }

    public function actionAfterSave()
    {
        if ($this->system == BankTransactions::PaymentSystemMCTop) {
            $this->id_in_system = $this->id;
            $this->save();
        }
        return parent::afterSave();
    }
}

