<?php

namespace app\widgets;


use app\models\User;
use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

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
            'caption' => 'Потенциальные получатели',
            'layout' => "{items}\n{pager}",
            'columns' => [
                [
                    'class' => SerialColumn::className(),
                    'header' => '№',
                ],
                [
                    'label' => 'Имя',
                    'content' => function ($model) {
                        foreach ($model->details as $detail) {
                            if ('nickname' === $detail->param_name) {
                                return $detail->param_value;
                            }
                        }
                    }
                ],
                'email',
                [
                    'class' => ActionColumn::className(),
                    'template' => '{add} {send}',
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
                        'send' => function ($url) {
                            $options = [
                                'title' => 'Написать',
                                'aria-label' => 'Написать',
                                'data-pjax' => '0',
                            ];

                            $icon = Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']);

                            return Html::a($icon, $url, $options);
                        },
                    ],
                    'visibleButtons' => [
                        'add' => !Yii::$app->user->isGuest,
                        'send' => !Yii::$app->user->isGuest,
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
                ->where('id <> ' . $userId),
        ]);
    }
}