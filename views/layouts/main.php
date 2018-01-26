<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!doctype html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title); ?></title>
    <?= Html::csrfMetaTags(); ?>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>

<div class="wrap">
    <?php NavBar::begin([
        'brandLabel' => 'Offline messager',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/register']];
        $menuItems[] = ['label' => 'Контакты', 'url' => ['/recipient/index']];

    } else {
        $menuItems[] = ['label' => Yii::$app->user->identity->email, 'items' => [
            ['label' => 'Профиль', 'url' => ['/profile/index']],
            ['label' => 'Контакты', 'url' => ['/recipient/index']],
            ['label' => 'Сообщения', 'url' => ['/message/index']],
        ]];

        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton('Выход', ['class' => 'btn btn-link logout'])
            . Html::endForm()
            . '</li>';
    }
    ?>
    <?= Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]); ?>
    <?php NavBar::end(); ?>

    <div class="container">
        <?= $content; ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Offline messager, <?= date('Y') ?></p>
    </div>
</footer>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>