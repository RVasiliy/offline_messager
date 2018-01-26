<?php

namespace app\controllers;


use app\models\User;
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

        return $this->render('view', ['recipient' => $recipient]);
    }
}