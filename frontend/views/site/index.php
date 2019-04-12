<?php

/* @var $this yii\web\View */
/* @var $products array */
/* @var $product \common\models\Product */

$this->title = Yii::t('app', 'Папа Жарит');
?>
<section class="ftco-menu mb-5 pb-5">
    <div class="container">
        <div class="row d-md-flex">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="mb-4">Меню</h2
            </div>
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
                                        <? if (!empty($products['burgers'])): ?>
                                            <? foreach ($products['burgers'] AS $product): ?>
                                                <div id="product-<?=$product['id']?>" class="col-md-6 col-lg-4 col-sm-6 text-center product-col">
                                                    <div class="menu-wrap">
                                                        <a href="#" class="menu-img img mb-4" data-img="<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>" style="background-image: url(<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>);"></a>
                                                        <div class="text">
                                                            <h3><a href="#"><?= $product['title'] ?></a></h3>
                                                            <p><?= $product['description'] ?></p>
                                                            <p class="price"><span><?= $product['price'] ?></span><span> р.</span></p>
                                                            <p>
                                                                <button id="add-to-cart-<?=$product['id']?>" data-attr="add-<?=$product['id']?>" data-id="<?=$product['id']?>" class="add-to-cart btn btn-primary btn-outline-primary">Добавить в корзину</button>
                                                                <div data-attr="product-buttons" style="display: none" data-id="<?=$product['id']?>">
                                                                    <button data-attr="minus" data-id="<?=$product['id']?>" class="btn btn-primary btn-outline-primary">
                                                                        -
                                                                    </button>
                                                                        <div data-attr="count" class="btn btn-primary btn-outline-primary btn-count">
                                                                            0
                                                                        </div>
                                                                        <button data-attr="plus" data-id="<?=$product['id']?>" class="btn btn-primary btn-outline-primary">
                                                                            +
                                                                        </button>
                                                                </div>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <? $b++; ?>
                                            <? endforeach; ?>
                                        <? else: ?>
                                            <?= Yii::t('app', 'Уточните, пожалуйста, по телефону.')?>
                                        <? endif ?>
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
                                        <? if (!empty($products['drinks'])): ?>
                                            <? foreach ($products['drinks'] AS $product): ?>
                                                <div id="product-<?=$product['id']?>" class="col-md-6 col-lg-4 col-sm-6 text-center product-col">
                                                    <div class="menu-wrap">
                                                        <a href="#" class="menu-img img mb-4" data-img="<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>" style="background-image: url(<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>);"></a>
                                                        <div class="text">
                                                            <h3><a href="#"><?= $product['title'] ?></a></h3>
                                                            <p><?= $product['description'] ?></p>
                                                            <p class="price"><span><?= $product['price'] ?></span><span> р.</span></p>
                                                            <p>
                                                                <button id="add-to-cart-<?=$product['id']?>" data-attr="add-<?=$product['id']?>" data-id="<?=$product['id']?>" class="add-to-cart btn btn-primary btn-outline-primary">Добавить в корзину</button>
                                                            <div data-attr="product-buttons" style="display: none" data-id="<?=$product['id']?>">
                                                                <button data-attr="minus" data-id="<?=$product['id']?>" class="btn btn-primary btn-outline-primary">
                                                                    -
                                                                </button>
                                                                <div data-attr="count" class="btn btn-primary btn-outline-primary btn-count">
                                                                    0
                                                                </div>
                                                                <button data-attr="plus" data-id="<?=$product['id']?>" class="btn btn-primary btn-outline-primary">
                                                                    +
                                                                </button>
                                                            </div>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <? $d++; ?>
                                            <? endforeach; ?>
                                        <? else: ?>
                                            <?= Yii::t('app', 'Уточните, пожалуйста, по телефону.')?>
                                        <? endif ?>
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
                                        <? if (!empty($products['fryer'])): ?>
                                            <? foreach ($products['fryer'] AS $product): ?>
                                            <div id="product-<?=$product['id']?>" class="col-md-6 col-lg-4 col-sm-6 text-center product-col">
                                                <div class="menu-wrap">
                                                    <a href="#" class="menu-img img mb-4" data-img="<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>" style="background-image: url(<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>);"></a>
                                                    <div class="text">
                                                        <h3><a href="#"><?= $product['title'] ?></a></h3>
                                                        <p><?= $product['description'] ?></p>
                                                        <p class="price"><span><?= $product['price'] ?></span><span> р.</span></p>
                                                        <p>
                                                            <button id="add-to-cart-<?=$product['id']?>" data-attr="add-<?=$product['id']?>" data-id="<?=$product['id']?>" class="add-to-cart btn btn-primary btn-outline-primary">Добавить в корзину</button>
                                                        <div data-attr="product-buttons" style="display: none" data-id="<?=$product['id']?>">
                                                            <button data-attr="minus" data-id="<?=$product['id']?>" class="btn btn-primary btn-outline-primary">
                                                                -
                                                            </button>
                                                            <div data-attr="count" class="btn btn-primary btn-outline-primary btn-count">
                                                                0
                                                            </div>
                                                            <button data-attr="plus" data-id="<?=$product['id']?>" class="btn btn-primary btn-outline-primary">
                                                                +
                                                            </button>
                                                        </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <? $b++; ?>
                                        <? endforeach; ?>
                                        <? else: ?>
                                            <?= Yii::t('app', 'Уточните, пожалуйста, по телефону.')?>
                                        <? endif ?>
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
                                        <? if (!empty($products['europe'])): ?>
                                            <? foreach ($products['europe'] AS $product): ?>
                                            <div id="product-<?=$product['id']?>" class="col-md-6 col-lg-4 col-sm-6 text-center product-col">
                                                <div class="menu-wrap">
                                                    <a href="#" class="menu-img img mb-4" data-img="<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>" style="background-image: url(<?= $product['photo_base_url'] . '/' . $product['photo_path'] ?>);"></a>
                                                    <div class="text">
                                                        <h3><a href="#"><?= $product['title'] ?></a></h3>
                                                        <p><?= $product['description'] ?></p>
                                                        <p class="price"><span><?= $product['price'] ?></span><span> р.</span></p>
                                                        <p>
                                                            <button id="add-to-cart-<?=$product['id']?>" data-attr="add-<?=$product['id']?>" data-id="<?=$product['id']?>" class="add-to-cart btn btn-primary btn-outline-primary">Добавить в корзину</button>
                                                        <div data-attr="product-buttons" style="display: none" data-id="<?=$product['id']?>">
                                                            <button data-attr="minus" data-id="<?=$product['id']?>" class="btn btn-primary btn-outline-primary">
                                                                -
                                                            </button>
                                                            <div data-attr="count" class="btn btn-primary btn-outline-primary btn-count">
                                                                0
                                                            </div>
                                                            <button data-attr="plus" data-id="<?=$product['id']?>" class="btn btn-primary btn-outline-primary">
                                                                +
                                                            </button>
                                                        </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <? $b++; ?>
                                        <? endforeach; ?>
                                        <? else: ?>
                                            <?= Yii::t('app', 'Уточните, пожалуйста, по телефону.')?>
                                        <? endif ?>
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
