<?php

class CabinetController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function relations()
    {
        return array(
            'user0' => array(self::BELONGS_TO, 'Users', 'user'),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'manual_page', 'add', 'edit', 'roles', 'features', 'MakeRecommended', 'bank', 'bank_replenish', 'recommendedserverspay', 'recommendedserverreject', 'recommendedservers', 'favoriteserverslist', 'manual'),
                'users' => array('@'),
            ),


            array('allow',
                'actions' => array('bank_success_transaction', 'bank_failure_transaction', 'bank_result_transaction', 'ManualGroup', 'ManualPage'),
                'users' => array('*'),
            ),

            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user' => 'User',
            'type' => 'Type',
            'description' => 'Description',
            'result' => 'Result',
            'time' => 'Time',
            'id_in_system' => 'Id In System',
            'system' => 'System',
            'ip' => 'Ip',
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('user', $this->user, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('result', $this->result);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('id_in_system', $this->id_in_system, true);
        $criteria->compare('system', $this->system);
        $criteria->compare('ip', $this->ip, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function actionIndex()
    {
        $this->render('index', array(
            'bank_account' => BalanceUsers::model()->findByPk(Yii::app()->user->id)
        ));
    }

    public function actionFeatures()
    {
        $this->render('features', array(
            'bank_account' => BalanceUsers::model()->findByPk(Yii::app()->user->id),
        ));
    }

    public function actionRecommendedServers()
    {
        $servers = Servers::model()->getUserServers();

        $this->render('recommended_servers', array(
            'servers' => $servers
        ));
    }

    public function actionFavoriteServersList()
    {
        $servers = Servers::model()->getUserFavoriteServers();

        if (is_null($servers))
            $this->render('favorite_servers_list_info');
        else
            $this->render('favorite_servers_list', array(
                'servers' => $servers
            ));
    }

    public function actionManual()
    {
        $this->render('manual', array(
            'categories' => FaqCategories::model()->findAll()
        ));
    }

    public function actionManualGroup($id)
    {
        if (is_null($group = FaqCategories::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Категория'))));

        $criteria = new CDbCriteria();

        $pages = new CPagination(FaqCategories::model()->count($criteria));
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $articles = Faq::model()->findAll($criteria);

        $this->render('manual_group', array(
            'articles' => $articles,
            'category' => $group
        ));
    }

    public function actionManual_Page($id)
    {
        if(is_null($article = Faq::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найдена', array('entity' => Yii::t('translations', 'Категория'))));

        $category = FaqCategories::model()->findByPk($article->id);

        $this->render('manual_page',array(
            'article' => $article,
            'category' => $category
        ));
    }

    public function actionMakeRecommended($id)
    {
        if (is_null($server = Servers::model()->findByPk($id)))
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Проект'))));

        if (Yii::app()->request->isPostRequest) {
            $recommended = RecommendedServers::model()->getRecommendedServer($id);
            $recommended->registered = new CDbExpression('NOW()');

            if ($recommended->save())
                $this->redirect('/cabinet');
        }

        $this->render('MakeRecommended', array(
            'server' => $server
        ));
    }

    public function actionBank()
    {
        $this->render('bank', array(
            'bank_account' => BalanceUsers::model()->findByPk(Yii::app()->user->id)
        ));
    }

    public function actionBank_Replenish()
    {
        $this->render('bank_replenish');
    }


    public function actionBank_result_transaction()
    {
        if (isset($_GET['method'])) {
            $action = 'invoicePayment';
            $params = $_GET['params'];
            $method = $_GET['method'];
            $user = $params['account'];

            $secretKey = 'f60ac7b1f66d2c64ac291c808c69edca';

            $invoice = BankTransactions::model()->initInvoiceRegistration();

            if (!is_null($user_account = Users::model()->findByPk($user))) {
                if ($params['sign'] != HUnitPay::md5sign($params, $secretKey)) {
                    if (!Reports::model()->isReportExists($user, $action)) {
                        $description = [];
                        $description['user'] = $user;
                        $description['action'] = $action;
                        $report = new Reports();
                        $report->user = Yii::app()->user->id;
                        $report->description = serialize($description);
                        $report->time = new CDbExpression('NOW()');
                        $report->save();
                    }
                    HUnitPay::responseError('Некорректная цифровая подпись');
                    Yii::app()->end();
                }
                switch ($method) {
                    #-----------------
                    case 'check':
                        HUnitPay::responseSuccess('Проверка пройдена успешно');
                        break;
                    #-----------------
                    case 'pay':
                        $user_bank_account = BalanceUsers::model()->getUserBankAccount($user);
                        $user_bank_account->balance += $params['profit'];

                        $user_bank_account->save() ?
                            HUnitPay::responseSuccess('Платеж успешно проведен')
                            :
                            HUnitPay::responseError('Произошла ошибка при сохранении данных об аккаунте пользователя. Обратитесь в поддержку MCTop');
                        break;
                    #-----------------
                    case 'error':
                        HUnitPay::responseError('Произошла ошибка при сохранении данных об аккаунте пользователя. Обратитесь в поддержку MCTop');
                        break;
                    #-----------------
                    default:
                        HUnitPay::responseError('Некорректный метод, поддерживаются методы: error, check и pay');
                        exit;
                    #-----------------
                }

                $invoice->registerInvoice();

                Yii::app()->end();

            } else {
                HUnitPay::responseError('Пользователь не найден');
                Yii::app()->end();
            }

        } else
            $this->redirect('/cabinet');
    }

    public function actionRecommendedserverspay($id)
    {
        if (is_null($server = RecommendedServers::model()->findByPk($id)) or $server->payed == 1)
            throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Сервер'))));

        $bank_account = BalanceUsers::getUserBankAccount();
        $cost = $server->calculateCost();

        if ($bank_account->balance - $cost < 0)
        {
            $this->render('not_enough_money', array(
                'cost' => $cost,
                'bank_account' => $bank_account,
                'server' => $server
            ));
        }

        else {

            $cost = $server->calculateCost();
            $transaction = new BankTransactions();
            $description = array('type' => 'bank', 'text' => 'Оплата рекомендованного сервера', 'sid' => $server->sid, 'cost' => $cost);
            $transaction->description = HUtils::json_encode_cyr($description);
            $transaction->user = Yii::app()->user->id;
            $transaction->type = BankTransactions::TRANSACTION_USER_PURCHASED_RECOMMENDED_SERVER_PLACE;
            $transaction->system = BankTransactions::PaymentSystemMCTop;

            if(!is_null($_SERVER['HTTP_X_REAL_IP']))
                $transaction->ip = $_SERVER['HTTP_X_REAL_IP'];
            else
                $transaction->ip = $_SERVER['REMOTE_ADDR'];

            $bank_account->balance -= $cost;

            if ($bank_account->save()) {
                $transaction->result = 1;
                $server->payed = 1;
            } else
                $transaction->result = 0;



            $transaction->time = new CDbExpression('NOW()');
            if ($transaction->save() and $server->save())
                $this->render('successful_pay', array(
                    'server' => $server
                ));
        }
    }

    public function actionRecommendedserverreject($id)
    {
        if (!is_null($record = RecommendedServers::model()->findByPk($id)))
            if ($record->delete())
                $this->redirect('/cabinet');
    }

}