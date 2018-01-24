<?php

namespace app\controllers;


use app\models\Profile;
use app\models\ProfileForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ProfileController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    public function actionIndex() {
        $model = new Profile();

        return $this->render('index', ['model' => $model]);
    }

    public function actionUpdate() {
        $model = new ProfileForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           return $this->goBack(['profile/index']);
        }

        return $this->render('update', ['model' => $model]);
    }
}