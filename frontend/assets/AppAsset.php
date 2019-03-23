<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css'
    ];
    public $js = [
        'js/jquery-migrate-3.0.1.min.js',
        'js/jquery.cookie.js',
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/jquery.easing.1.3.js',
        'js/jquery.waypoints.min.js',
        'js/jquery.stellar.min.js',
        'js/aos.js',
        'js/scrollax.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
