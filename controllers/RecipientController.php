<?php

namespace app\controllers;


use app\models\UserRecipient;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Контроллер для управления получателями (добавление/удаление)
 *
 * @package app\controllers
 */
class RecipientController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionAdd($id) {
        $userRecipient = new UserRecipient();
        $userRecipient->user_id = Yii::$app->user->id;
        $userRecipient->recipient_id = $id;
        $userRecipient->save();

        return $this->redirect(['recipient/index']);
    }

    public function actionDelete($id) {

        UserRecipient::deleteAll([
            'user_id' => Yii::$app->user->id,
            'recipient_id' => $id,
        ]);

        return $this->redirect(['recipient/index']);
    }
}