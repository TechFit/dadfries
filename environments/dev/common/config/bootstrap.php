<?php

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@storage', dirname(dirname(__DIR__)) . '/storage');

/**
 * Setting url aliases
 */
Yii::setAlias('@frontendUrl', 'http://dad.local');
Yii::setAlias('@backendUrl',  'http://admin.dad.local');
Yii::setAlias('@storageUrl',  'http://storage.dad.local');
