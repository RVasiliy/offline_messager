<?php

namespace app\models;


use yii\db\ActiveRecord;

class UserRecipient extends ActiveRecord {

    public static function tableName() {
        return '{{%user_recipient}}';
    }

    public function rules() {
        return [
            ['user_id', 'required'],
            ['user_id', 'integer'],

            ['recipient_id', 'required'],
            ['recipient_id', 'integer'],
        ];
    }

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (self::findOne(['user_id' => $this->user_id, 'recipient_id' => $this->recipient_id])) {
            return false;
        }

        return true;
    }
}
