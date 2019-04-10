<?php

/* @var $this yii\web\View */
/* @var $model \frontend\models\OrderForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Оформление заказа');
$this->params['breadcrumbs'][] = $this->title;
?>
<? if (empty(json_decode($order_products, true))): ?>
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <h1>Корзина пустая.</h1>
            </div>
        </div>
    </div>
</section>
<?else:?>
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <?php $form = ActiveForm::begin(['id' => 'order-form', 'class' => 'billing-form ftco-bg-dark p-3 p-md-5']); ?>
                    <h3 class="mb-4 billing-heading">Оформление доставки</h3>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <?= $form->field($model, 'name') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'phone') ?>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'address') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'comment') ?>
                        </div>
                        <div class="col-md-6">
                            <?= Html::submitButton(Yii::t('app', 'Заказать'), ['class' => 'btn btn-primary py-3 px-4']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div> <!-- .col-md-8 -->
        </div>
    </div>
</section> <!-- .section -->

<?endif;?>