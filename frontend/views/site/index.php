<?php

/* @var $this yii\web\View */
/* @var $products \common\models\Product */

$this->title = Yii::t('app', 'Папа Жарит');
?>
<section class="ftco-menu">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-7 heading-section text-center ftco-animate">
            <h2 class="mb-4">Меню</h2
        </div>
        </div>
        <div class="row d-md-flex">
            <div class="col-lg-12 ftco-animate p-md-5 menu-tabs-row">
                <div class="row">
                    <div class="col-md-12 nav-link-wrap mb-5">
                        <div class="nav ftco-animate nav-pills justify-content-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                            <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Бургеры</a>

                            <a class="nav-link" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Напитки</a>

                            <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Закуски</a>

                            <a class="nav-link" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-4" aria-selected="false">Сладости из Европы</a>

                        </div>
                    </div>
                    <div class="col-md-12 d-flex align-items-center">

                        <div class="tab-content ftco-animate" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">
                                    <? $b = 0; ?>
                                    <? if ($b %3 == 0): ?>
                                        <? $b = 0; ?>
                                        <div class="row">
                                    <? endif ?>
                                        <? foreach ($products['burgers'] AS $product): ?>
                                            <div class="col-md-4 text-center">
                                                <div class="menu-wrap">
                                                    <a href="#" class="menu-img img mb-4" style="background-image: url(<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>);"></a>
                                                    <div class="text">
                                                        <h3><a href="#"><?= $product['title'] ?></a></h3>
                                                        <p><?= $product['description'] ?></p>
                                                        <p class="price"><span><?= $product['price'] ?> р.</span></p>
                                                        <p><a href="#" class="btn btn-primary btn-outline-primary">Добавить в корзину</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <? $b++; ?>
                                        <? endforeach; ?>
                                        </div>
                                    <? if ($b %3 != 0): ?>
                                    <? endif ?>
                                </div>

                                <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                                    <? $d = 0; ?>
                                    <? if ($d %3 == 0): ?>
                                        <? $d = 0; ?>
                                    <div class="row">
                                        <? endif ?>
                                        <? foreach ($products['drinks'] AS $product): ?>
                                            <div class="col-md-4 text-center">
                                                <div class="menu-wrap">
                                                    <a href="#" class="menu-img img mb-4" style="background-image: url(<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>);"></a>
                                                    <div class="text">
                                                        <h3><a href="#"><?= $product['title'] ?></a></h3>
                                                        <p><?= $product['description'] ?></p>
                                                        <p class="price"><span><?= $product['price'] ?> р.</span></p>
                                                        <p><a href="#" class="btn btn-primary btn-outline-primary">Добавить в корзину</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <? $d++; ?>
                                        <? endforeach; ?>
                                    </div>
                                    <? if ($d %3 != 0): ?>
                                    <? endif ?>
                                </div>

                                <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
                                    <? $b = 0; ?>
                                    <? if ($b %3 == 0): ?>
                                        <? $b = 0; ?>
                                    <div class="row">
                                        <? endif ?>
                                        <? foreach ($products['fryer'] AS $product): ?>
                                            <div class="col-md-4 text-center">
                                                <div class="menu-wrap">
                                                    <a href="#" class="menu-img img mb-4" style="background-image: url(<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>);"></a>
                                                    <div class="text">
                                                        <h3><a href="#"><?= $product['title'] ?></a></h3>
                                                        <p><?= $product['description'] ?></p>
                                                        <p class="price"><span><?= $product['price'] ?> р.</span></p>
                                                        <p><a href="#" class="btn btn-primary btn-outline-primary">Добавить в корзину</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <? $b++; ?>
                                        <? endforeach; ?>
                                    </div>
                                    <? if ($b %3 != 0): ?>
                                    <? endif ?>
                                </div>

                                <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab">
                                    <? $b = 0; ?>
                                    <? if ($b %3 == 0): ?>
                                        <? $b = 0; ?>
                                    <div class="row">
                                        <? endif ?>
                                        <? foreach ($products['europe'] AS $product): ?>
                                            <div class="col-md-4 text-center">
                                                <div class="menu-wrap">
                                                    <a href="#" class="menu-img img mb-4" style="background-image: url(<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>);"></a>
                                                    <div class="text">
                                                        <h3><a href="#"><?= $product['title'] ?></a></h3>
                                                        <p><?= $product['description'] ?></p>
                                                        <p class="price"><span><?= $product['price'] ?> р.</span></p>
                                                        <p><a href="#" class="btn btn-primary btn-outline-primary">Добавить в корзину</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <? $b++; ?>
                                        <? endforeach; ?>
                                    </div>
                                    <? if ($b %3 != 0): ?>
                                    <? endif ?>
                               </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--<section class="ftco-gallery">-->
<!--    <div class="container-wrap">-->
<!--        <div class="row no-gutters">-->
<!--            <div class="col-md-3 ftco-animate">-->
<!--                <a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-1.jpg);">-->
<!--                    <div class="icon mb-4 d-flex align-items-center justify-content-center">-->
<!--                        <span class="icon-search"></span>-->
<!--                    </div>-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="col-md-3 ftco-animate">-->
<!--                <a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-2.jpg);">-->
<!--                    <div class="icon mb-4 d-flex align-items-center justify-content-center">-->
<!--                        <span class="icon-search"></span>-->
<!--                    </div>-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="col-md-3 ftco-animate">-->
<!--                <a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-3.jpg);">-->
<!--                    <div class="icon mb-4 d-flex align-items-center justify-content-center">-->
<!--                        <span class="icon-search"></span>-->
<!--                    </div>-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="col-md-3 ftco-animate">-->
<!--                <a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-4.jpg);">-->
<!--                    <div class="icon mb-4 d-flex align-items-center justify-content-center">-->
<!--                        <span class="icon-search"></span>-->
<!--                    </div>-->
<!--                </a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->

