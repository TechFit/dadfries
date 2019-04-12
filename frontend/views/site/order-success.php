<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">

                <h1><?= Html::encode($this->title) ?></h1>

                <div class="alert alert-success">
                    <?= nl2br(Html::encode($message)) ?>
                </div>
            </div> <!-- .col-md-8 -->
        </div>
    </div>
</section> <!-- .section -->

<script>
    setTimeout(function(){
        window.location.replace("<?= 'index' ?>");
    }, 5000);
</script>
