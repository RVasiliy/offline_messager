<?php

use yii\helpers\Html;

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
        <div class="col-lg-12">

        </div>
    </div>
</div>
