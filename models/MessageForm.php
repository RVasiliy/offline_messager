<?php

namespace app\models;


use yii\base\Model;

class MessageForm extends Model {
    public $userId;
    public $recipientId;
    public $message;

    public function rules() {
        return [
            [['userId', 'recipientId'], 'required'],
            [['userId', 'recipientId'], 'integer'],
            ['message', 'string'],
        ];
    }

    public function save() {
        $model = new UserMessage();
        $model->user_id = $this->userId;
        $model->recipient_id = $this->recipientId;
        $model->message = $this->message;

        return $model->save();
    }
}