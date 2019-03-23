<?php

/* @var $this yii\web\View */
/* @var $model \frontend\models\OrderForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Оформление заказа');
$this->params['breadcrumbs'][] = $this->title;
?>

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

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                        <tr class="text-center">
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td class="product-remove"><a href="#"><span class="icon-close"></span></a></td>

                            <td class="image-prod"><div class="img" style="background-image:url(images/menu-2.jpg);"></div></td>

                            <td class="product-name">
                                <h3>Creamy Latte Coffee</h3>
                                <p>Far far away, behind the word mountains, far from the countries</p>
                            </td>

                            <td class="price">$4.90</td>

                            <td class="quantity">
                                <div class="input-group mb-3">
                                    <input type="text" name="quantity" class="quantity form-control input-number" value="1" min="1" max="100">
                                </div>
                            </td>

                            <td class="total">$4.90</td>
                        </tr><!-- END TR-->

                        <tr class="text-center">
                            <td class="product-remove"><a href="#"><span class="icon-close"></span></a></td>

                            <td class="image-prod"><div class="img" style="background-image:url(images/dish-2.jpg);"></div></td>

                            <td class="product-name">
                                <h3>Grilled Ribs Beef</h3>
                                <p>Far far away, behind the word mountains, far from the countries</p>
                            </td>

                            <td class="price">$15.70</td>

                            <td class="quantity">
                                <div class="input-group mb-3">
                                    <input type="text" name="quantity" class="quantity form-control input-number" value="1" min="1" max="100">
                                </div>
                            </td>

                            <td class="total">$15.70</td>
                        </tr><!-- END TR-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col col-lg-3 col-md-6 mt-5 cart-wrap ftco-animate">
                <div class="cart-total mb-3">
                    <h3>Cart Totals</h3>
                    <p class="d-flex">
                        <span>Subtotal</span>
                        <span>$20.60</span>
                    </p>
                    <p class="d-flex">
                        <span>Delivery</span>
                        <span>$0.00</span>
                    </p>
                    <p class="d-flex">
                        <span>Discount</span>
                        <span>$3.00</span>
                    </p>
                    <hr>
                    <p class="d-flex total-price">
                        <span>Total</span>
                        <span>$17.60</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
