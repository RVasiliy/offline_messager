<?php

namespace app\controllers;


use app\models\MessageForm;
use Yii;
use app\models\User;
use app\models\UserMessage;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class MessageController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionView($recipient_id) {
        if (Yii::$app->user->id == $recipient_id) {
            $this->redirect(['message/index']);
        }

        $recipient = User::find()
            ->select(['id', 'email'])
            ->where(['id' => $recipient_id])
            ->one();

        $messages = UserMessage::find()
            ->where([
                'user_id' => [Yii::$app->user->id, $recipient_id]
            ]);

        $model = new MessageForm();

        return $this->render('view', [
            'recipient' => $recipient,
            'messages' => $messages,
            'model' => $model,
        ]);
    }

    public function actionAdd() {
        $model = new MessageForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return 'error';
    }
}