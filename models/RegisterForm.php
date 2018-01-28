<?php

namespace app\models;


use yii\base\Model;

/**
 * Форма регистрации
 *
 * @package app\models
 */
class RegisterForm extends Model {
    public $nickname;
    public $email;
    public $password;
    public $password_repeat;

    public function attributeLabels() {
        return [
            'nickname' => 'Имя',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Повторить пароль',
        ];
    }

    public function rules() {
        return [
            ['nickname', 'trim'],
            ['nickname', 'required'],
            ['nickname', 'string', 'min' => 3, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
        ];
    }

    public function register() {
        if ($this->validate()) {
            return null;
        }

        $user = new User();
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($user->save()) {
            $userDetail = new UserDetail();
            $userDetail->user_id = $user->getId();
            $userDetail->param_name = 'nickname';
            $userDetail->param_value = $this->nickname;
            $userDetail->param_type = UserDetail::STRING_TYPE;
            $userDetail->save();

            return $user;
        }

        return null;
    }
}