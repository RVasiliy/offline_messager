<?php

use yii\helpers\Html;

$this->title = 'Переписка c ' . $recipient->detail->nickname;
?>
<div class="message-view">
    <h1><?= Html::encode($this->title); ?></h1>
</div>
