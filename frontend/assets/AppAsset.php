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
        'css/site.css',
        'css/open-iconic-bootstrap.min.css',
        'css/css/animate.css',
        'css/magnific-popup.css',
        'css/aos.css',
        'css/ionicons.min.css',
        'css/flaticon.css',
        'css/icomoon.css',
        'css/style.css',
        'https://fonts.googleapis.com/css?family=Great+Vibes',
        'https://fonts.googleapis.com/css?family=Josefin+Sans:400,700',
        'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700',
    ];
    public $js = [
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/jquery.easing.1.3.js',
        'js/jquery.waypoints.min.js',
        'js/jquery.stellar.min.js',
        'js/aos.js',
        'js/scrollax.min.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
