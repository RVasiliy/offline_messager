<?php

namespace app\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
        ];
    }
}