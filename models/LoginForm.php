<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model {
    private $_user;

    public $email;
    public $password;
    public $rememberMe = true;

    public function attributeLabels() {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }

    public function rules() {
        return [
            ['email', 'required'],
            ['email', 'email'],

            ['password', 'required'],
            ['password', 'validatePassword'],

            ['rememberMe', 'boolean'],
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function login() {
        if ($this->validate()) {
            return Yii::$app->getUser()->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    protected function getUser() {
        if (null === $this->_user) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}