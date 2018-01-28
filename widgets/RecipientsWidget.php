<?php

namespace app\widgets;


use app\models\User;
use app\models\UserRecipient;
use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Список пользователей системы
 * Запись аутентифицированного пользователя не выводится
 *
 * @package app\widgets
 */
class RecipientsWidget extends Widget {

    public function run() {
        return GridView::widget([
            'dataProvider' => $this->getDataProvider(),
            'layout' => "{items}\n{pager}",
            'columns' => [
                [
                    'class' => SerialColumn::className(),
                    'header' => '№',
                ],
                [
                    'label' => 'Имя',
                    'content' => function ($model) {
                        return $model->detail->nickname;
                    }
                ],
                'email',
                [
                    'class' => ActionColumn::className(),
                    'template' => '{add} {message} {delete}',
                    'buttons' => [
                        'add' => function ($url) {
                            $options = [
                                'title' => 'Добавить',
                                'aria-label' => 'Добавить',
                                'data-pjax' => '0',
                            ];

                            $icon = Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']);

                            return Html::a($icon, $url, $options);
                        },
                        'message' => function ($url, $model) {
                            $options = [
                                'title' => 'Написать',
                                'aria-label' => 'Написать',
                                'data-pjax' => '0',
                            ];

                            $icon = Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']);

                            return Html::a($icon, Url::to(['message/view', 'recipient_id' => $model->id]), $options);
                        },
                    ],
                    'visibleButtons' => [
                        'add' => function ($model) {
                            $user = Yii::$app->user;

                            return !$user->isGuest && !$this->isRecipient($user, $model);
                        },
                        'message' => function ($model) {
                            $user = Yii::$app->user;

                            return !$user->isGuest && $this->isRecipient($user, $model);
                        },
                        'delete' => function ($model) {
                            $user = Yii::$app->user;

                            return !$user->isGuest && $this->isRecipient($user, $model);
                        },
                    ],
                ],
            ],
        ]);
    }

    protected function getDataProvider() {
        $userId = Yii::$app->getUser()->id ? Yii::$app->getUser()->id : 0;

        return new ActiveDataProvider([
            'query' => User::find()
                ->select(['id', 'email'])
                ->where(['<>', 'id', $userId]),
        ]);
    }

    private function isRecipient($user, $candidate) {
        return boolval(UserRecipient::findOne([
            'user_id' => $user->id,
            'recipient_id' => $candidate->id
        ]));
    }
}