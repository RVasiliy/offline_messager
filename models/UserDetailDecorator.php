<?php

namespace app\models;


/**
 * Вспомогательная модель для получения дополнительных данных о пользователе.
 * Используется в модели User ($user->detail->$param_name).
 *
 * @package app\models
 */
class UserDetailDecorator {
    private $_user;
    private $_cache = [];

    public function __construct(User $user) {
        $this->_user = $user;
    }

    public function __get($field) {
        if (array_key_exists($field, $this->_cache)) {
            return $this->_cache[$field];
        }

        $userDetails = $this->_user->details;

        foreach ($userDetails as $detail) {
            if ($detail->param_name === $field) {
                $this->_cache[$field] = $detail->param_value;

                return $this->_cache[$field];
            }
        }
    }
}