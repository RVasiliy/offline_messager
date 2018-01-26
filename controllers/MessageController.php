<?php

namespace app\controllers;


use Yii;
use app\models\User;
use app\models\UserMessage;
use yii\filters\AccessControl;
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
        ];
    }

    public function actionView($recipient_id) {
        $recipient = User::find()
            ->select(['id', 'email'])
            ->where(['id' => $recipient_id])
            ->one();

        $messages = UserMessage::find()
            ->where([
                'user_id' => [Yii::$app->user->id, $recipient_id]
            ]);

        return $this->render('view', [
            'recipient' => $recipient,
            'messages' => $messages,
        ]);
    }
}