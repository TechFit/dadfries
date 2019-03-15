<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Список продуктов');
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3 products">
                <a href="/product?type=1"><?= Yii::t('app', 'Бургеры')?></a>
            </div>
            <div class="col-lg-3 products">
                <a href="/product?type=2"><?= Yii::t('app', 'Закуски')?></a>
            </div>
            <div class="col-lg-3 products">
                <a href="/product?type=3"><?= Yii::t('app', 'Напитки')?></a>
            </div>
            <div class="col-lg-3 products">
                <a href="/product?type=4"><?= Yii::t('app', 'Сладости из Европы')?></a>
            </div>
        </div>

    </div>
</div>
