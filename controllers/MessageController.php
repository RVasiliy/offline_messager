<?php

namespace app\controllers;


use app\models\MessageForm;
use Yii;
use app\models\User;
use app\models\UserMessage;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Контроллер для работы с сообщениями
 *
 * @package app\controllers
 */
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
                    'get' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Страница чата между двумя пользователями
     *
     * @param integer $recipient_id Id получателя
     * @return string
     */
    public function actionView($recipient_id) {
        if (Yii::$app->user->id == $recipient_id) {
            $this->redirect(['message/index']);
        }

        $recipient = User::find()
            ->select(['id', 'email'])
            ->where(['id' => $recipient_id])
            ->one();

        $model = new MessageForm();

        return $this->render('view', [
            'recipient' => $recipient,
            'model' => $model,
        ]);
    }

    /**
     * Действие добавления нового сообщения в чат
     *
     * @return string
     */
    public function actionAdd() {
        $model = new MessageForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return 'error';
    }

    /**
     * Действие для получения новых сообщений в чат
     *
     * @return \yii\web\Response
     */
    public function actionGet() {
        $post = Yii::$app->request->post();

        // Id получателя
        $recipient_id = intval($post['recipient_id']);
        // Id последнего полученного сообщения
        $last_id = intval($post['last_id']);

        if (Yii::$app->user->id == $recipient_id) {
            return $this->asJson([]);
        }

        $messages = UserMessage::find()
            ->where([
                'user_id' => [Yii::$app->user->id, $recipient_id],
            ])
            ->andWhere(['>', 'id', $last_id]);

        return $this->asJson($messages->all());
    }

    /**
     * Действие для просмотра входящих сообщений
     *
     * @return string
     */
    public function actionInbox() {
        return $this->render('inbox');
    }
}