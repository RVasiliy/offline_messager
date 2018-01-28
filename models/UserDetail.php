<?php

namespace app\models;


use Yii;
use yii\db\ActiveRecord;

/**
 * Модель дополнительной информации о пользователе
 *
 * @package app\models
 */
class UserDetail extends ActiveRecord {

    const DATE_TYPE = 'date';
    const FLOAT_TYPE = 'float';
    const INT_TYPE = 'integer';
    const STRING_TYPE = 'string';
    const TIMESTAMP_TYPE = 'timestamp';

    public static function createModel($userId, $paramName) {
        $model = self::findOne(['user_id' => $userId, 'param_name' => $paramName]);

        if (!$model) {
            $model = new self();
            $model->user_id = $userId;
            $model->param_name = $paramName;
            $model->param_type = self::STRING_TYPE;
        }

        return $model;
    }

    public static function tableName() {
        return '{{%user_detail}}';
    }

    public function rules() {
        return [
            ['user_id', 'integer'],
            ['user_id', 'required'],

            ['param_name', 'trim'],
            ['param_name', 'string', 'max' => 255],
            ['param_name', 'required'],

            ['param_value', 'trim'],
            ['param_value', 'string', 'max' => 255],
            ['param_value', 'required'],
            ['param_value', 'validateParamValue'],

            ['param_type', 'trim'],
            ['param_type', 'string', 'max' => 10],
            ['param_type', 'required'],
            ['param_type', 'default', 'value' => self::STRING_TYPE],
            ['param_type', 'in', 'range' => [
                self::DATE_TYPE,
                self::FLOAT_TYPE,
                self::INT_TYPE,
                self::STRING_TYPE,
                self::TIMESTAMP_TYPE,
            ]],
        ];
    }

    public function validateParamValue($attribute, $params) {
        switch ($this->param_type) {
            case self::DATE_TYPE:
                if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1])$/', $attribute)) {
                    $this->addError('param_value', 'Attribute "param_value" not match with type "' . self::DATE_TYPE . '"');
                }

                break;

            case self::FLOAT_TYPE:
                if (!preg_match('/^(0\.\d{1,}|[1-9]\d{0,}\.\d{1,})$/', $attribute)) {
                    $this->addError('param_value', 'Attribute "param_value" not match with type "' . self::FLOAT_TYPE . '"');
                }

                break;

            case self::INT_TYPE:
            case self::TIMESTAMP_TYPE:
                if (!preg_match('/^\d{1,}$/', $attribute)) {
                    $this->addError('param_value', 'Attribute "param_value" not match with type "' . self::INT_TYPE . '" or "' . self::TIMESTAMP_TYPE . '"');
                }

                break;
            default:
                break;
        }
    }

    public static function findByName($paramName, $userId = 0) {
        if ($userId) {
            $userId = Yii::$app->user->identity->getId();
        }

        return static::findOne(['user_id' => $userId, 'param_name' => $paramName]);
    }
}