<?php

/**
 * This is the model class for table "adverts".
 *
 * The followings are the available columns in table 'adverts':
 * @property string $id
 * @property string $user
 * @property string $name
 * @property integer $position
 * @property integer $type
 * @property integer $pay_type
 * @property integer $active
 * @property integer $payer_id
 * @property integer $payer_type
 * @property integer $displayed
 *
 * The followings are the available model relations:
 * @property Users $user0
 */
class Adverts extends CActiveRecord
{
    protected $account;

    private $original_record;
    public $additional_info = array();

    public $cost;
    public $payer;
    public $recalculate = false;
    public $itIsAdvertViewing = false;

    public $banner_image;
    public $site;

    public $ordered;
    public $balance;
    public $image;
    public $views;
    public $clicks;
    public $redisRecord;

    const PAY_TYPE_CLICKS = 0;
    const PAY_TYPE_VIEWS = 1;

    const POSITION_HEAD = 0;
    const POSITION_RIGHT_COLUMN = 1;

    const PAYER_PROJECT = 0;
    const PAYER_USER = 1;

    const ADVERT_WAITING_MODERATION = 0;
    const ADVERT_CAN_BE_DISPLAYED = 1;
    const ADVERT_ARCHIVED = 2;
    const ADVERT_BALANCE_EXHAUSTED = 3;

    const ADVERT_DISPLAYING = 1;
    const ADVERT_NOT_DISPLAYED = 0;

    public function tableName()
    {
        return 'adverts';
    }

    public function rules()
    {
        return array(
            array('user, name, balance, pay_type, type, ordered', 'required'),
            array('type, pay_type, active', 'numerical', 'integerOnly' => true),
            array('user', 'length', 'max' => 10),
            array('name', 'length', 'max' => 30),
            array('id, user, name, type, pay_type, clicks, ordered, balance, active', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'user0' => array(Adverts::BELONGS_TO, 'Users', 'user'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user' => 'User',
            'name' => 'Name',
            'type' => 'Type',
            'pay_type' => 'Pay Type',
            'views' => 'Views',
            'clicks' => 'Clicks',
            'ordered' => 'Ordered',
            'balance' => 'Balance',
            'active' => 'Active',
        );
    }

    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user', $this->user, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('pay_type', $this->pay_type);
        $criteria->compare('active', $this->active);
        $criteria->compare('payer_id', $this->payer_id);
        $criteria->compare('payer_type', $this->payer_type);
        $criteria->compare('displayed', $this->displayed);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getUrl()
    {
        return '/advert/out/' . $this->id;
    }

    public function getImage()
    {
        return $this->redisRecord->get_image();
    }

    public function registerPayer($payer)
    {
        $payer_info = array();

        $this->getPayerType($payer) == Adverts::PAYER_PROJECT ? $payer_info['type'] = Adverts::PAYER_PROJECT : $payer_info['type'] = Adverts::PAYER_USER;

        $payer_info['id'] = $this->parsePayerId($payer);

        $this->payer = $payer_info;
    }

    public function registerAdvert()
    {

        $this->getPayerAccount();
        $this->countCost();
        $this->balance = $this->cost;
        $this->redisRecord = new RedisAdverts();
        $this->redisRecord->set_creator_id(Yii::app()->user->id);
        $this->redisRecord->set_balance($this->balance);
        $this->redisRecord->set_views(0);
        $this->redisRecord->set_clicks(0);
        $this->redisRecord->set_registered(Time::now());
        if($this->payer_type == Adverts::PAYER_PROJECT)
        {
            $project = Projects::model()->findByPk($this->payer['id']);
            $this->redisRecord->set_site($project->site);
        }
        if(isset($_POST['Adverts']['site']))
            $this->redisRecord->set_site($_POST['Adverts']['site']);


        if ($this->save()) {
            $this->redisRecord->set_id($this->id);
            $this->redisRecord->save();
            return true;
        } else
            return false;
    }

    public function countCost()
    {
        switch ($this->pay_type) {
            case Adverts::PAY_TYPE_CLICKS:
                $this->position == Adverts::POSITION_HEAD ? $this->cost = $this->ordered * 5 : $this->cost = $this->ordered * 1;
                break;

            case Adverts::PAY_TYPE_VIEWS:
                $this->position == Adverts::POSITION_HEAD ? $this->cost = $this->ordered / 1000 * 25 : $this->cost = $this->ordered / 1000 * 15;
                break;
        }
    }

    public function afterFind()
    {
        $this->fillOriginalRecordField();
        $this->fillModelRedisFields($this);
        if($this->isNewRecord)
            $model = $this->payer['type'] == Adverts::PAYER_PROJECT ? BalanceProjects::model() : BalanceUsers::model();
        else
        {
            $model = $this->payer_type == Adverts::PAYER_PROJECT ? BalanceProjects::model() : BalanceUsers::model();
        }
        $this->isNewRecord ? $account = $model->findByPk($this->payer['id']) : $account = $model->findByPk($this->payer_id);

        return parent::afterFind();
    }

    public function beforeValidate()
    {

        if ($this->isNewRecord) {
            $this->checkSiteUrl();
            $this->checkAdvertBanner();
            $this->checkMoneyEnough();
            $this->checkMinimumSum();

            $this->payer_type = $this->payer['type'];
            if (isset($_GET['id']))
                $this->payer_id = $_GET['id'];
            else
                $this->payer_id = $this->payer['id'];

        }

        $this->doActionByType();

        return parent::beforeValidate();
    }

    public function afterValidate()
    {

        if (($this->isNewRecord) or ($this->recalculate))
            if ($this->isCanWithdrawMoney())
                $this->withdrawMoney();

        return parent::afterValidate();
    }

    public function fillOriginalRecordField()
    {
        $this->original_record = new Adverts();

        foreach ($this->attributes as $key => $value)
            if ($key != 'db')
                $this->original_record->$key = $value;

        $this->fillModelRedisFields($this->original_record);
    }

    public function checkSiteUrl()
    {
        if (isset($_POST['Adverts']['site'])) {
            if (!HUtils::isItValidLink($_POST['Adverts']['site']))
                $this->addError('site', 'error');
        } else
            if ($_POST['type'] != 'project')
                $this->addError('site', 'error');
    }


    public function checkAdvertBanner()
    {

        if ($this->isNewRecord)
            if (is_null($this->banner_image))
                $this->addError('image', Yii::t('translations', 'Вы не выбрали изображение баннера'));

        if (!is_null($this->banner_image)) {
            if ($this->banner_image->canBeAdvertBanner($this->type)) {
                $this->banner_image->using = Images::USING_AS_ADVERT_BANNER;
                $this->banner_image->save();
                $this->banner_image->image->saveAs(root . '/static/uploaded/u' . Yii::app()->user->id . '/' . $this->banner_image->filename);
                $this->redisRecord->set_image('/static/uploaded/u' . Yii::app()->user->id . '/' . $this->banner_image->filename);
                if (!$this->isNewRecord)
                    $this->redisRecord->save();

            } else
                $this->addError('image', Yii::t('translations', 'Изображение баннера должно быть size пикселей', $this->type == Adverts::POSITION_HEAD ? array('size' => '728x90') : array('XxX')));
        }
    }

    public function recalculate()
    {
        $account = $this->getUsedBankAccount();
        $this->calculateResidue();
        $new_balance = $account->balance - $this->cost;
        $this->additional_info['new_balance'] = $new_balance;
        $this->pay_type = $_POST['Adverts']['pay_type'];
        $this->type = $_POST['Adverts']['type'];
        $this->ordered = $_POST['Adverts']['ordered'];
        $this->calculateCost();
        $this->checkMoneyEnough($new_balance);
        $this->checkMinimumSum();
    }

    public function checkMoneyEnough($balance = null)
    {
        if($this->isNewRecord)
            $model = $this->payer['type'] == Adverts::PAYER_PROJECT ? BalanceProjects::model() : BalanceUsers::model();
        else
        {
            $model = $this->payer_type == Adverts::PAYER_PROJECT ? BalanceProjects::model() : BalanceUsers::model();
        }
        $this->isNewRecord ? $this->account = $model->findByPk($this->payer['id']) : $this->account = $model->findByPk($this->payer_id);

        if (!$this->isMoneyEnough($this->account->balance))
        {
            if(isset($_GET['id']))
                $this->addError('ordered', YIi::t('translations', 'На балансе вашего проекта не хватает THE_AMOUNT руб.', array('THE_AMOUNT' => $this->account->balance-$this->cost)));
            else
                $this->addError('ordered', YIi::t('translations', 'Вам не хватает THE_AMOUNT руб.', array('THE_AMOUNT' => $this->account->balance-$this->cost)));
        }

    }

    public function isMoneyEnough($user_money_count = null)
    {

        $this->calculateCost();

        if (is_null($user_money_count)) {
            $this->payer['type'] == Adverts::PAYER_PROJECT ? $this->account = BalanceProjects::model()->findByPk($this->payer['id']) : $this->account = BalanceUsers::model()->findByPk($this->payer['id']);
            $user_money_count = $this->account->balance;
        }

        if (($user_money_count - $this->cost) >= 0)
            return true;
        else
            return false;

    }

    public function checkMinimumSum()
    {
        if (isset($this->cost) and isset($this->itIsAdvertViewing) and isset($this->original_record->balance))
            if (!($this->cost >= 100) and !($this->itIsAdvertViewing) and ($this->original_record->balance != $this->ordered))
                $this->addError('ordered', YIi::t('translations', 'Минимальная сумма заказа 100 рублей. Ваша сумма: SUM', array('SUM' => $this->cost)));
    }

    public function isNeedsToRecalculate()
    {
        if (isset($_POST['Adverts'])) {
            switch ($this->pay_type) {
                case Adverts::PAY_TYPE_CLICKS:
                    $this->position == Adverts::POSITION_HEAD ? $this->cost = $this->balance / 5 : $this->cost = $this->balance / 1;
                    break;

                case Adverts::PAY_TYPE_VIEWS:
                    $this->position == Adverts::POSITION_HEAD ? $this->cost = $this->balance / 25 * 1000 : $this->cost = $this->balance / 15 * 1000;
                    break;
            }

            if (($_POST['Adverts']['ordered'] != $this->cost) || $_POST['Adverts']['type'] != $this->type || $_POST['Adverts']['pay_type'] != $this->pay_type) {
                if ($this->displayed)
                    $this->addError('displayed', Yii::t('translations', 'Для изменения количества показов / кликов Вы должны остановить объявление'));
                else {
                    $this->recalculate = true;
                    return 1;
                }

            } else
                return 0;
        } else
            return 0;

    }

    public function isCanWithdrawMoney()
    {
        return sizeof($this->getErrors()) == 0 ? true : false;
    }

    public function withdrawMoney()
    {

        $bank_transaction = new BankTransactions();
        $bank_transaction->user = Yii::app()->user->id;
        $bank_transaction->type = BankTransactions::TYPE_OUT;

        if ($this->isNewRecord)
            $model = $this->payer['type'] == Adverts::PAYER_PROJECT ? BalanceProjects::model() : BalanceUsers::model();
        else {
            $model = $this->payer_type == Adverts::PAYER_PROJECT ? BalanceProjects::model() : BalanceUsers::model();
        }

        $transaction = $model->dbConnection->beginTransaction();
        try {
            $this->isNewRecord ? $account = $model->findByPk($this->payer['id']) : $account = $model->findByPk($this->payer_id);

            $balance_before = $account->balance;

            if ($this->isItRecalculation())
                $this->updateBalances($account);
            else
                $account->balance -= $this->cost;

            $balance_after = $account->balance;

            if ($account->save()) {
                $its_successful = true;

                switch ($this->pay_type) {
                    case Adverts::PAY_TYPE_CLICKS:
                        $this->type == Adverts::POSITION_HEAD ? $this->redisRecord->set_balance($this->ordered * 5) : $this->redisRecord->set_balance($this->ordered * 1);
                        break;

                    case Adverts::PAY_TYPE_VIEWS:
                        $this->type == Adverts::POSITION_HEAD ? $this->redisRecord->set_balance($this->ordered / 1000 * 25) : $this->redisRecord->set_balance($this->ordered / 1000 * 15);
                        break;
                }

                if (!$this->isNewRecord)
                    $its_successful = $this->redisRecord->save($this->id) == 1 ? true : false;


                if ($its_successful) {
                    $transaction->commit();
                    $bank_transaction->description = BankTransactions::generateProjectTransactionDescription($this, $balance_before, $balance_after, $this->generateConvertInfo());
                    $bank_transaction->result = 1;
                    $bank_transaction->time = HUtils::getCurrentTimestamp();
                    $bank_transaction->system = BankTransactions::PaymentSystemMCTop;
                    $bank_transaction->id_in_system = BankTransactions::PaymentSystemMCTop;
                    $bank_transaction->ip = $_SERVER['REMOTE_ADDR'];
                    //if some errors
                    // $bank_transaction->validate()
                    // var_dump($bank_transaction->getErrors());
                    $bank_transaction->save() or $transaction->rollback();
                }

            } else
                $transaction->rollback();
        } catch (Exception $e) {

            $transaction->rollback();
            $bank_transaction->result = 0;
            $bank_transaction->save();
            throw $e;
        }
    }

    public function transferMoneyToUser()
    {

        $bank_transaction = new BankTransactions();
        $bank_transaction->user = Yii::app()->user->id;
        $bank_transaction->type = BankTransactions::TYPE_IN;

        $model = $this->payer_type == Adverts::PAYER_PROJECT ? BalanceProjects::model() : $model = BalanceUsers::model();

        $transaction = $model->dbConnection->beginTransaction();
        try {
            $account = $model->findByPk($this->payer_id);
            $balance_before = $account->balance;
            if (!empty($this->additional_info['new_balance'])) {
                $account->balance = $this->additional_info['new_balance'];
                $this->balance = $this->ordered;
            }
            if ($this->cost < 0)
                $this->cost *= -1;

            $account->balance += $this->cost;

            $balance_after = $account->balance;
            if ($account->save()) {
                $transaction->commit();
                $bank_transaction->description = BankTransactions::generateTransactionToReturn($this, $balance_before, $balance_after, $this->generateConvertInfo(), $this->payer_type == Adverts::PAYER_PROJECT ? 'project' : 'user');
                $bank_transaction->result = 1;
                $bank_transaction->time = HUtils::getCurrentTimestamp();
                if ($bank_transaction->save() or (die(var_dump($bank_transaction->getErrors())))) ;
                return true;
            } else
                $transaction->rollback();
        } catch (Exception $e) {
            $transaction->rollback();
            $bank_transaction->result = 0;
            $bank_transaction->save();
            throw $e;
        }
    }

    public function calculateResidue()
    {

        $delta = $_POST['Adverts']['ordered'] - $this->ordered;

        if (Yii::app()->getController()->action->id != 'move')
            if ($delta < 0)
                $delta *= -1;

        switch ($this->pay_type) {
            case Adverts::PAY_TYPE_CLICKS:
                $this->type == Adverts::POSITION_HEAD ? $this->cost = $delta * 5 : $this->cost = $delta * 1;
                break;

            case Adverts::PAY_TYPE_VIEWS:
                $this->type == Adverts::POSITION_HEAD ? $this->cost = $delta / 1000 * 25 : $this->cost = $delta / 1000 * 15;
                break;
        }
    }

    public function calculateCost()
    {
        switch ($this->pay_type) {
            case Adverts::PAY_TYPE_CLICKS:
                $this->type == Adverts::POSITION_HEAD ? $this->cost = $this->ordered * 5 : $this->cost = $this->ordered * 1;
                break;

            case Adverts::PAY_TYPE_VIEWS:
                $this->type == Adverts::POSITION_HEAD ? $this->cost = $this->ordered / 1000 * 25 : $this->cost = $this->ordered / 1000 * 15;
                break;
        }
    }

    public function getPayerType($payer)
    {
        return substr($payer, 0, 1) == 'p' ? Adverts::PAYER_PROJECT : Adverts::PAYER_USER;
    }

    public function parsePayerId($string)
    {
        return substr($string, 1, strlen($string) - 1);
    }

    public function getUsedBankAccount()
    {
        if ($this->payer_type == Adverts::PAYER_PROJECT)
            $model = BalanceProjects::model();
        else
            $model = BalanceUsers::model();

        return $model->findByPk($this->payer_id);
    }

    public static function getUserAdverts($user)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'user=:user and active<>:archived';
        $criteria->params = array(':user' => $user, ':archived' => Adverts::ADVERT_ARCHIVED);
        $criteria->order = 'id desc';
        return Adverts::model()->findAll($criteria);
    }

    public static function getUserBankAccount($user)
    {
        return BalanceUsers::model()->findByPk($user);
    }

    public static function getPossibleBankAccountsForUser($user)
    {
        $bankAccounts = array();
        foreach (ProjectsRoles::getUserRoles($user) as $project_role)
            if (($project_role->project0->checkUserRights($user, 'project_financer_pay_money')))
                $bankAccounts[] = BalanceProjects::model()->findByPk($project_role->project0->id);
        return $bankAccounts;
    }

    /**
     * @param $type
     * @return Adverts
     */
    public function getAdvertByType($type)
    {
        $q = new CDbCriteria();
        $q->condition = 'type=:type and displayed=1 and active=:active';
        $q->params = array(':type' => $type, ':active' => Adverts::ADVERT_CAN_BE_DISPLAYED);
        $q->order = 'RAND()';
        $advert = Adverts::model()->find($q);

        if(is_null($advert))
            return null;

        $advert->redisRecord = RedisAdverts::model()->get($advert->id);

        if (!is_null($advert)) {

            $calc = 0;
            $advert->itIsAdvertViewing = true;

            if ($advert->pay_type == Adverts::PAY_TYPE_VIEWS)
                $advert->redisRecord->subtract_balance_on_view($advert->id, $advert->pay_type, $advert->type);

            if($advert->ordered == 0)
                $advert->ordered = 1;

            if ($advert->pay_type == Adverts::PAY_TYPE_CLICKS)
                $calc = round(($advert->ordered - $advert->balance) / $advert->ordered * 100, 2);

            $advert->redisRecord->increment_views();

            if ($calc == 100 or ($advert->redisRecord->get_balance() <= 0)) {
                $advert->active = Adverts::ADVERT_BALANCE_EXHAUSTED;
                $advert->displayed = Adverts::ADVERT_NOT_DISPLAYED;
                if($advert->redisRecord->get_balance()<=0)
                    $advert->balance = 0;
            }

            $advert->save();
            return $advert;
        }
    }

    public function generateConvertInfo()
    {

        //todo Repair
        if ($this->isNewRecord)
            return 0;

        $info = array();
        $info['adv_balance_before'] = $this->original_record->redisRecord->get_balance();
        $info['adv_balance_after'] = $this->redisRecord->get_balance();
        $info['adv_type_before'] = $this->original_record->type;
        $info['adv_type_after'] = $this->type;
        $info['adv_pay_type_before'] = $this->original_record->pay_type;
        $info['adv_pay_type_after'] = $this->pay_type;

        return $info;
    }

    public function returnMoney()
    {
        $this->calculateResidue();
        $this->balance = 0;
        if ($this->transferMoneyToUser(Yii::app()->user->id))
            return true;
    }

    public function out()
    {

        if ($this->isDisplays()) {
            $this->redisRecord->increment_clicks($this->id);

            if ($this->pay_type == Adverts::PAY_TYPE_CLICKS)
                $this->redisRecord->subtract_balance_on_view($this->id, $this->pay_type, $this->type);

            Yii::app()->getController()->redirect($this->redisRecord->get_site());

            $calc = 0;
            $this->itIsAdvertViewing = true;

            if ($this->pay_type == Adverts::PAY_TYPE_CLICKS) {
                $calc = round(($this->ordered - $this->balance) / $this->ordered * 100, 2);
                $this->redisRecord->IncrementViews($this->id);
            }

            if ($calc == 100) {
                $this->active = Adverts::ADVERT_BALANCE_EXHAUSTED;
                $this->displayed = Adverts::ADVERT_NOT_DISPLAYED;
            }

            $this->save();

        } else
            Yii::app()->getController()->redirect('/');

    }

    public function isDisplays()
    {
        if ($this->active == Adverts::ADVERT_CAN_BE_DISPLAYED and $this->displayed == Adverts::ADVERT_DISPLAYING)
            return true;
    }

    public function isItRecalculation()
    {
        return $this->recalculate == true ? true : false;
    }

    public function updateBalances(&$account)
    {
        $account->balance = $this->additional_info['new_balance'];
        $this->redisRecord->set_balance($this->redisRecord->ordered = $_POST['Adverts']['ordered']);
    }

    public function infoToRedis()
    {
        $info = array();
        $info['id'] = $this->id;
        $info['ordered'] = $this->ordered;
        $info['balance'] = $this->balance;
        $info['site'] = $this->payer_type == Adverts::PAYER_PROJECT ? Projects::model()->findByPk($this->payer)->site : $_POST['Adverts']['site'];
        $info['image'] = '/static/uploaded/u' . Yii::app()->user->id . '/' . $this->banner_image->filename;
        return $info;
    }

    public function fillModelRedisFields(Adverts &$advert)
    {
        $advert->redisRecord = RedisAdverts::model()->get($this->id);
    }

    public function doActionByType()
    {
        if (isset($_POST['type'])) {
            switch ($_POST['type']) {
                case 'convert':
                    if ($this->isNeedsToRecalculate())
                        $this->recalculate();
                    break;

                case 'only_banner':
                    $this->balance = $this->redisRecord->get_balance();
                    $this->ordered = $this->redisRecord->get_balance();
                    $this->checkAdvertBanner();
                    break;

                case 'only_name':
                    $this->name = $_POST['Adverts']['name'];
                    $this->balance = $this->redisRecord->get_balance();
                    $this->ordered = $this->redisRecord->get_balance();
                    break;

                case 'only_status':
                    $this->balance = $this->redisRecord->get_balance();
                    $this->ordered = $this->redisRecord->get_balance();
                    break;
            }
        }

    }

    public function getPayerAccount()
    {
        if ($this->payer['type'] == Adverts::PAYER_PROJECT)
            $this->account = BalanceProjects::model()->findByPk($this->payer['id']);
        else
            $this->account = BalanceUsers::model()->findByPk($this->payer['id']);
    }


}
