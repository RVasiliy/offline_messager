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

            <div class="message-list-wrap">
                <div class="message-list-scroller">
                    <div id="message-list"></div>
                </div>
            </div>

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
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-block btn-primary']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <script>
        var MESSAGE_PARAMS = {
            owner_id: <?= Yii::$app->user->id; ?>,
            owner_name: '<?= Yii::$app->user->identity->detail->nickname; ?>',
            recipient_id: <?= $recipient->id; ?>,
            recipient_name: '<?= $recipient->detail->nickname; ?>'
        };
    </script>
</div>
