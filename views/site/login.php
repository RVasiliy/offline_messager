<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Вход';
?>
<div class="site-login">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h1><?= Html::encode($this->title); ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <?php $form = ActiveForm::begin(['id' => 'form-register']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]); ?>
            <?= $form->field($model, 'password')->passwordInput(); ?>
            <?= $form->field($model, 'rememberMe')->checkbox(); ?>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
