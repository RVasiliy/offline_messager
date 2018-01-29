<?php

namespace app\controllers;


use app\models\UserOnline;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class OnlineController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'verbs' => ['post'],
                    ],
                ],
            ],
        ];
    }

    public function actionUpdate() {
        $userId = Yii::$app->user->id;

        if (!UserOnline::updateAll(['last_time' => time()], ['user_id' => $userId])) {
            $model = new UserOnline();
            $model->user_id = $userId;
            $model->save();
        }
    }
}