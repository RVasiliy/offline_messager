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
 * Список пользователей, приславших сообщения
 *
 * @package app\widgets
 */
class InboxWidget extends Widget {
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
                        $owner = $model->owner;
                        $isOnline = '';
                        $hasMesages = '';

                        if (UserOnline::isUserOnline($owner->id)) {
                            $isOnline = '<span class="glyphicon glyphicon-globe"></span> ';
                        }

                        if (UserMessage::find()->where([
                            'user_id' => $owner->id,
                            'recipient_id' => Yii::$app->user->id,
                            'is_read' => false
                        ])->count()) {
                            $hasMesages = '<span class="glyphicon glyphicon-envelope"></span> ';
                        }

                        return $isOnline . $hasMesages . $owner->detail->nickname;
                    },
                ],
                [
                    'label' => 'Email',
                    'content' => function ($model) {
                        return $model->owner->email;
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

                            return Html::a($icon, Url::to(['message/view', 'recipient_id' => $model->user_id]), $options);
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
            ->where(['recipient_id' => \Yii::$app->user->id]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}