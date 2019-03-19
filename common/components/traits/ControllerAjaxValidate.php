<?php

namespace common\components\traits;

use Yii;
use yii\base\Model;
use yii\web\Response;
use frontend\widgets\ActiveForm;

trait ControllerAjaxValidate
{
    public function handleAjaxValidation(Model $model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        return null;
    }
}