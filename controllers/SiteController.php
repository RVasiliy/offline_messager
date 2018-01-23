<?php

namespace app\controllers;

use Yii;
use app\models\RegisterForm;
use yii\web\Controller;

class SiteController extends Controller {
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionRegister() {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->register()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('register', ['model' => $model]);
    }
}