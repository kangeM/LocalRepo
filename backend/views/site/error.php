<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="ht-100v d-flex align-items-center justify-content-center">
      <div class="wd-lg-70p wd-xl-50p tx-center pd-x-40">
        <h1 class="tx-30 tx-xs-80 tx-normal tx-inverse tx-roboto mg-b-0"><?= Html::encode($this->title) ?></h1>
        <h5 class="tx-xs-24 tx-normal tx-info mg-b-30 lh-5">The resource you are looking for has not been found.</h5>
        <p class="tx-16 mg-b-30"><?= nl2br(Html::encode($message)) ?></p>
        
        

        <div class="d-flex justify-content-center">
          <div class="input-group wd-xs-300 ">
          <?= Html::a('Go Back Home', ['site/index'], $options = ['class'=>'btn btn-info btn-block'] ) ?>
          </div><!-- input-group -->
          
        </div><!-- d-flex -->


      </div>
    </div><!-- ht-100v -->

