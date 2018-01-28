<?php

use yii\helpers\Html;

$this->title = 'Мои сообщения';
?>
<div class="message-index">
    <h1><?= Html::encode($this->title); ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped">
                <tr>
                    <th>Входящие</th>
                    <td><?= Html::a('Смотреть', ['message/inbox'], ['class' => 'btn btn-primary']); ?></td>
                </tr>
                <tr>
                    <th>Исходящие</th>
                    <td><?= Html::a('Смотреть', ['message/outbox'], ['class' => 'btn btn-primary']); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>