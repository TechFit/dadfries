<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">


    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="/"> <img src="images/dadfries.png" alt="" style="width: 150px;"></a>
        <div class="dp-header__item no-ma small-nav" style="display:none;">
            <div class="dp-cart-item">
                <div class="dp-cart-wrapper">
                    <div class="dp-button-cart">
                        <div class="dp-button-cart__icon-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510 510">
                                <path d="M153,408c-28.05,0-51,22.95-51,51s22.95,51,51,51s51-22.95,51-51S181.05,408,153,408z M0,0v51h51l91.8,193.8L107.1,306 c-2.55,7.65-5.1,17.85-5.1,25.5c0,28.05,22.95,51,51,51h306v-51H163.2c-2.55,0-5.1-2.55-5.1-5.1v-2.551l22.95-43.35h188.7 c20.4,0,35.7-10.2,43.35-25.5L504.9,89.25c5.1-5.1,5.1-7.65,5.1-12.75c0-15.3-10.2-25.5-25.5-25.5H107.1L84.15,0H0z M408,408 c-28.05,0-51,22.95-51,51s22.95,51,51,51s51-22.95,51-51S436.05,408,408,408z">
                                </path>
                            </svg>
                        </div>
                        <div class="dp-button-cart__price-block"><span class="total">0</span> <span class="total-currency"> .р</span></div>
                        <div class="dp-button-cart__text-block">
                            <a href="cart.html"><span>Заказать</span></a>
                        </div>
                    </div>
                    <div class="ReactCollapse--collapse" style="height: auto; display: none;">
                        <div class="ReactCollapse--content">
                            <div class="dp-cart__items-list">
                                <div class="dp-cart__items-total-wrap">
                                    <div class="dp-cart__items-total-text">Всего</div>
                                    <div class="dp-cart__items-total-price">
                                        <span>0 </span>.р
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="index.html" class="nav-link">Главная</a></li>
                <li class="nav-item"><a href="menu.html" class="nav-link">Оставить отзыв</a></li>
                <li class="nav-item">
                    <div class="dp-header__item no-ma">
                        <div class="dp-cart-item">
                            <div class="dp-cart-wrapper">
                                <div class="dp-button-cart">
                                    <div class="dp-button-cart__icon-wrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510 510">
                                            <path d="M153,408c-28.05,0-51,22.95-51,51s22.95,51,51,51s51-22.95,51-51S181.05,408,153,408z M0,0v51h51l91.8,193.8L107.1,306 c-2.55,7.65-5.1,17.85-5.1,25.5c0,28.05,22.95,51,51,51h306v-51H163.2c-2.55,0-5.1-2.55-5.1-5.1v-2.551l22.95-43.35h188.7 c20.4,0,35.7-10.2,43.35-25.5L504.9,89.25c5.1-5.1,5.1-7.65,5.1-12.75c0-15.3-10.2-25.5-25.5-25.5H107.1L84.15,0H0z M408,408 c-28.05,0-51,22.95-51,51s22.95,51,51,51s51-22.95,51-51S436.05,408,408,408z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="dp-button-cart__price-block"><span class="total">0</span> <span class="total-currency"> .р</span></div>
                                    <div class="dp-button-cart__text-block">
                                        <a href="cart.html"><span>Заказать</span></a>
                                    </div>
                                </div>
                                <div class="ReactCollapse--collapse" style="height: auto; display: none;">
                                    <div class="ReactCollapse--content">
                                        <div class="dp-cart__items-list">
                                            <div class="dp-cart__items-total-wrap">
                                                <div class="dp-cart__items-total-text">Всего</div>
                                                <div class="dp-cart__items-total-price">
                                                    <span>0 </span>.р
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php $this->beginBody() ?>

<?= Alert::widget() ?>

<?= $content ?>

<?php $this->endBody() ?>

<footer class="ftco-footer ftco-section img">
    <div class="overlay"></div>
    <div class="container">
        <div class="row ">
            <div class="col-lg-4 col-md-4 ">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Контакты</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li  style="height: 34px;"><span class="icon icon-map-marker"></span><span class="text">г. Конаково, ул. Васильковского 29</span></li>
                            <li  style="height: 34px;"><a href="#"><span class="icon icon-phone"></span><span class="text">8 965 723 51 61</span></a></li>
                            <li  style="height: 34px;"><a href="https://www.instagram.com/p/BrSHB58HnTG/"><span class="icon icon-instagram"></span><span class="text">dadfries_burgers</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 ">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Время работы</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li  style="height: 34px;"><span class="icon icon-calendar"></span><span class="text">Пн - Вс</span></li>
                            <li  style="height: 34px;"><span class="icon icon-clock-o"></span><span class="text">10:00 - 22:00</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">

                <p style="font-size: 10px;">
                    &copy;<script>document.write(new Date().getFullYear());</script> ВСЕ ПРАВА ЗАЩИЩЕНЫ!. ЛЮБОЕ ИСПОЛЬЗОВАНИЕ МАТЕРИАЛОВ ДОПУСКАЕТСЯ ТОЛЬКО С СОГЛАСИЯ РЕДАКЦИИ.
                </p>
            </div>
        </div>
    </div>
</footer>
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
<!--<script src="js/jquery.min.js"></script>-->
<!--<script src="js/jquery-migrate-3.0.1.min.js"></script>-->
<!--<script src="js/jquery.cookie.js"></script>-->
<!--<script src="js/popper.min.js"></script>-->
<!--<script src="js/bootstrap.min.js"></script>-->
<!--<script src="js/jquery.easing.1.3.js"></script>-->
<!--<script src="js/jquery.waypoints.min.js"></script>-->
<!--<script src="js/jquery.stellar.min.js"></script>-->
<!--<script src="js/owl.carousel.min.js"></script>-->
<!--<script src="js/jquery.magnific-popup.min.js"></script>-->
<!--<script src="js/aos.js"></script>-->
<!--<script src="js/jquery.animateNumber.min.js"></script>-->
<!--<script src="js/bootstrap-datepicker.js"></script>-->
<!--<script src="js/jquery.timepicker.min.js"></script>-->
<!--<script src="js/scrollax.min.js"></script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>-->
<!--<script src="js/google-map.js"></script>-->
<script src="js/Cookie.js"></script>
<script src="js/Order.js"></script>
<script src="js/Cart.js"></script>
<script src="js/main.js"></script>

</body>
</html>
<?php $this->endPage() ?>
