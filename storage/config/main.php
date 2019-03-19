<?php

return [
    'id' => 'storage',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'glide/index',
    'controllerMap' => [
        'glide' => '\trntv\glide\controllers\GlideController'
    ],
    'components' => [
        'urlManager' => require(__DIR__ . '/_urlManager.php'),
        'glide' => [
            'class' => 'trntv\glide\components\Glide',
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'maxImageSize' => 4000000,
            'signKey' => 'GLIDE_SIGN_KEY'
        ]
    ]
];
