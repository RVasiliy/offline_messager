<?php

namespace app\widgets;


use app\models\UserMessage;
use app\models\UserOnline;
use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Список пользователей, кому были посланы сообщения
 *
 * @package app\widgets
 */
class OutboxWidget extends Widget {
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
                        $recipient = $model->recipient;
                        $isOnline = '';
                        $hasMesages = '';

                        if (UserOnline::isUserOnline($recipient->id)) {
                            $isOnline = '<span class="glyphicon glyphicon-globe"></span> ';
                        }

                        if (UserMessage::find()->where([
                            'user_id' => $recipient->id,
                            'recipient_id' => Yii::$app->user->id,
                            'is_read' => false
                        ])->count()) {
                            $hasMesages = '<span class="glyphicon glyphicon-envelope"></span> ';
                        }

                        return $isOnline . $hasMesages . $recipient->detail->nickname;
                    },
                ],
                [
                    'label' => 'Email',
                    'content' => function ($model) {
                        return $model->recipient->email;
                    },
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{message}',
                    'buttons' => [
                        'message' => function ($url, $model) {
                            $options = [
                                'title' => 'Написать',
                                'aria-label' => 'Написать',
                                'data-pjax' => '0',
                            ];

                            $icon = Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']);

                            return Html::a($icon, Url::to(['message/view', 'recipient_id' => $model->recipient_id]), $options);
                        },
                    ],
                ],
            ],
        ]);
    }

    protected function getDataProvider() {
        $query = UserMessage::find()
            ->distinct()
            ->select(['user_id', 'recipient_id'])
            ->where(['user_id' => \Yii::$app->user->id]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}