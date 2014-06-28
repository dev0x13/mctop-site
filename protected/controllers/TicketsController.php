<?php

class TicketsController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'create', 'show'),
                'users' => array('@'),
            ),

            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $data = TicketsTopics::model()->getUserTickets(Yii::app()->user->id);
        $this->render('index', array(
            'tickets' => $data['tickets'],
            'pages' => $data['pages']
        ));
    }

    public function actionCreate()
    {
        $model = new TicketsTopics();
        $message = new TicketsMessages();

        if (Yii::app()->request->isPostRequest)
            if ($_POST['TicketsTopics']['name'] != '' and $_POST['TicketsMessages']['message'] != '') {
                $model->attributes = $_POST['TicketsTopics'];
                $model->status = TicketsTopics::STATUS_OPENED;
                $model->user = Yii::app()->user->id;
                $model->time = HUtils::getCurrentTimestamp();

                if ($model->save())
                    $message->ticket = $model->id;
                $message->author = $model->user;
                $message->attributes = $_POST['TicketsMessages'];
                $message->time = HUtils::getCurrentTimestamp();

                if ($message->save())
                    $this->redirect('/tickets/show/' . $model->id);

            }

        $this->render('create', array(
            'model' => $model,
            'message' => $message,
        ));
    }


    public function actionShow($id)
    {
        $ticket = TicketsTopics::model()->findByPk($id);
        $model = new TicketsMessages();

        if ($ticket->user != Yii::app()->user->id)
          $this->redirect('/tickets');
        else
        {
          if (is_null($ticket))
              throw new CHttpException(404, Yii::t('translations', 'entity не найден', array('entity' => Yii::t('translations', 'Тикет'))));

          if (isset($_POST['close'])) {
              $ticket->status = TicketsTopics::STATUS_CLOSED;
              $ticket->save();
              $this->redirect('/tickets');
          }

          if (isset($_POST['TicketsMessages'])) {
              $model->attributes = $_POST['TicketsMessages'];
              $model->author = Yii::app()->user->id;
              $model->ticket = $id;
              $model->time = HUtils::getCurrentTimestamp();
              $ticket->status = TicketsTopics::STATUS_USER_ANSWERED;
              if ($model->save())
                  if ($ticket->save())
                      $this->redirect('/tickets/show/' . $id);
          }

          $ticket_info = TicketsTopics::getTicketInfo($ticket->id);
          $this->render('conversation', array(
              'messages' => $ticket_info['messages'],
              'pages' => $ticket_info['pages'],
              'ticket' => $ticket,
              'model' => $model,
              'user' => Users::model()->findByPk(Yii::app()->user->id)
          ));
        }
    }
}
