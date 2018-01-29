<?php

namespace app\assets;


use yii\web\AssetBundle;

class MessageFormAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/message-list.css',
    ];
    public $js = [
        'js/message-form.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}