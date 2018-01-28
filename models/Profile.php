<?php

namespace app\models;


use Yii;
use yii\base\Model;

/**
 * Модель для вывода дополнительных данных о пользователе на странице профиля
 *
 * @package app\models
 */
class Profile extends Model {
    public $nickname;

    public function init() {
        $userId = Yii::$app->getUser()->id;

        $userDetails = UserDetail::find()
            ->where(['user_id' => $userId])
            ->each();

        foreach ($userDetails as $userDetail) {
            $paramName = $userDetail->param_name;
            $paramValue = $userDetail->param_value;

            if (property_exists($this, $paramName)) {
                $this->$paramName = $paramValue;
            }
        }
    }
}