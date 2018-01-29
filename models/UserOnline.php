<?php

namespace app\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Модель для отслеживания пользователей online
 *
 * @package app\models
 */
class UserOnline extends ActiveRecord {

    /**
     * Время простоя в секундах, в течение которого пользователь считается online
     */
    const OFFLINE_LIMIT = 10;

    public static function tableName() {
        return '{{%user_online}}';
    }

    public static function primaryKey() {
        return 'user_id';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'last_time',
                'updatedAtAttribute' => 'last_time',
            ],
        ];
    }

    public function rules() {
        return [
            [['user_id', 'last_time'], 'integer'],
            ['user_id', 'unique'],
        ];
    }

    public static function isUserOnline($userId) {
        $model = self::findOne(['user_id' => $userId]);

        if (!$model) {
            return false;
        }

        return (time() - $model->last_time) < self::OFFLINE_LIMIT;
    }
}