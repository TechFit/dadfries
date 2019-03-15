<?php

namespace console\controllers;

use common\models\User;

/**
 * Class UserController
 */
class UserController extends \yii\console\Controller
{
    public function actionCreate(string $username, string $password): void
    {
        $user = new User();
        $user->username = $username;
        $user->email = "";
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->save();
    }
}