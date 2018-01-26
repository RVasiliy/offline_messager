<?php

namespace app\models;


use Yii;
use yii\base\Model;

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