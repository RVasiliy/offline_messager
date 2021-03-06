<?php

namespace app\assets;

use Yii;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init() {
        if (!Yii::$app->user->isGuest) {
            $this->js[] = 'js/user-online.js';
        }
    }
}

