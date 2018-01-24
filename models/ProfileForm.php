<?php

namespace app\models;


use Yii;
use yii\base\Model;

class ProfileForm extends Model {
    public $nickname;
    public $password;
    public $password_repeat;

    public function attributeLabels() {
        return [
            'nickname' => 'Имя',
            'password' => 'Пароль',
            'password_repeat' => 'Повторить пароль',
        ];
    }

    public function rules() {
        return [
            ['nickname', 'required'],
            ['nickname', 'string', 'max' => 255],

            ['password', 'string', 'min' => 6],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
        ];
    }

    public function init() {
        $user = Yii::$app->getUser();

        if (!$user->isGuest) {
            $userNickname = UserDetail::findByName('nickname', $user->id);

            if ($userNickname) {
                $this->nickname = $userNickname->param_value;
            }
        }
    }

    public function save() {
        $user = Yii::$app->getUser();

        if ($user->isGuest) {
            return false;
        }

        $userDetail = UserDetail::createModel($user->id, 'nickname');
        $userDetail->param_value = $this->nickname;

        if ($this->password) {
            $this->updatePassword($this->password);
        }

        return $userDetail->save();
    }

    protected function updatePassword($password) {
        $user = Yii::$app->getUser()->identity;

        $user->setPassword($password);
        $user->save();
    }
}