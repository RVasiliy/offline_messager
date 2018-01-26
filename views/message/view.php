<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Переписка c ' . $recipient->detail->nickname;
?>
<div class="message-view">
    <h1><?= Html::encode($this->title); ?></h1>

    <div class="row">
        <div class="col-lg-12">

            <?php foreach ($messages->each() as $message): ?>
                <?php if ($message->user_id === Yii::$app->user->id) { ?>
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="alert alert-success">
                                <p class="text-left">
                                    <strong>Я, [<?= Yii::$app->formatter->asDatetime($message->created_at, 'short'); ?>
                                        ]</strong>
                                </p>

                                <p><?= $message->message; ?></p>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-2">
                            <div class="alert alert-info">
                                <p class="text-right">
                                    <strong>
                                        <?= $recipient->detail->nickname; ?>,
                                        [<?= Yii::$app->formatter->asDatetime($message->created_at, 'short'); ?>]
                                    </strong>
                                </p>

                                <p><?= $message->message; ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php endforeach; ?>

        </div>
    </div>

    <div class="row">
        <?php $form = ActiveForm::begin([
            'id' => 'form-message',
            'action' => Url::to(['message/add']),
            'fieldConfig' => [
                'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            ],
        ]); ?>

        <div class="col-lg-10">
            <?= $form->field($model, 'userId')->hiddenInput(['value' => Yii::$app->user->id]); ?>
            <?= $form->field($model, 'recipientId')->hiddenInput(['value' => $recipient->id]); ?>
            <?= $form->field($model, 'message')->textarea(['autofocus' => true]); ?>
        </div>

        <div class="col-lg-2 media-middle">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-block btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
