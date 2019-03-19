<?php

use common\models\Product;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Product::listOfProducts()[$model->type], 'url' => ['index', 'type' => $model->type]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div>
        <?= Html::img($model->getPhoto(), ['style' => 'width:100px;']);?>
    </div>
    <div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'title',
                'description',
                'created_at:datetime',
            ],
        ]) ?>
    </div>
</div>
