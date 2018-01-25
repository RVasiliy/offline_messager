<?php

use app\widgets\RecipientsWidget;
use yii\helpers\Html;

$this->title = 'Контакты';
?>
<div class="recipient-index">
    <h1><?= Html::encode($this->title); ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?= RecipientsWidget::widget(); ?>
        </div>
        <div class="col-lg-12">
            <?php if (Yii::$app->user->isGuest): ?>
                <p>* Для того, чтобы отправить сообщение кому-нибудь нужно <?= Html::a('войти в систему', ['site/login']); ?></p>
            <?php endif;?>
        </div>
    </div>
</div>
