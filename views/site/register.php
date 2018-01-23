<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Регистрация';
?>

<div class="site-register">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h1><?= Html::encode($this->title); ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <?php $form = ActiveForm::begin(['id' => 'form-register']); ?>

            <?= $form->field($model, 'nickname')->textInput(['autofocus' => true]); ?>
            <?= $form->field($model, 'email'); ?>
            <?= $form->field($model, 'password')->passwordInput(); ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(); ?>

            <div class="form-group">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
