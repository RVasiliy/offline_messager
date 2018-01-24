<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Профиль';
?>
<div class="profile-index">
    <h1><?= Html::encode($this->title); ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'form-profile']); ?>

            <?= $form->field($model, 'nickname')->textInput(); ?>
            <?= $form->field($model, 'password')->passwordInput(); ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(); ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
