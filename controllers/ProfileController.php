<?php

namespace app\controllers;


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
        $model = new ProfileForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
        }

        return $this->render('index', ['model' => $model]);
    }
}