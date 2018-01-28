<?php

namespace app\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Модель сообщений от пользователей
 *
 * @package app\models
 */
class UserMessage extends ActiveRecord {

    public static function tableName() {
        return '{{%user_message}}';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules() {
        return [
            [['user_id', 'recipient_id', 'message'], 'required'],
            [['user_id', 'recipient_id'], 'integer'],
            ['message', 'string'],
            ['is_read', 'boolean'],
        ];
    }

    public function getOwner() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getRecipient() {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }
}