<?php

use app\widgets\InboxWidget;
use yii\helpers\Html;

$this->title = 'Входящие сообщения';
?>
<div class="message-index">
    <h1><?= Html::encode($this->title); ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?= InboxWidget::widget(); ?>
        </div>
    </div>
</div>