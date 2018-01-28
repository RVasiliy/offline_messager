<?php

use app\widgets\OutboxWidget;
use yii\helpers\Html;

$this->title = 'Исходящие сообщения';
?>
<div class="message-outbox">
    <h1><?= Html::encode($this->title); ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?= OutboxWidget::widget(); ?>
        </div>
    </div>
</div>