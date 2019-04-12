<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ReviewForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\MaskedInput;

$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <?php $form = ActiveForm::begin(['id' => 'review-form', 'class' => 'billing-form ftco-bg-dark p-3 p-md-5']); ?>
                <h3 class="mb-4 billing-heading">Напишите нам</h3>
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <?= $form->field($model, 'name')->textInput(['autocomplete' => "off"]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                            'mask' => '(999) 999-9999'
                        ]) ?>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'message')->textarea(['autocomplete' => "false"]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-primary py-3 px-4']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div> <!-- .col-md-8 -->
        </div>
    </div>
</section> <!-- .section -->
