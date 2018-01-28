<?php

namespace app\models;


use Yii;
use yii\base\Model;

/**
 * Форма редактирования профиля
 *
 * @package app\models
 */
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
            return $userDetail->save() && $this->updatePassword($user->identity, $this->password);
        }

        return $userDetail->save();
    }

    protected function updatePassword(User $user, $password) {
        $user->setPassword($password);
        return $user->save();
    }
}