<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAssetOut;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAssetOut::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="row no-gutters flex-row-reverse ht-100v">
      <div class="col-md-6 bg-gray-200 d-flex align-items-center justify-content-center">
      
      <?= $content ?>
      </div><!-- col -->
      <div class="col-md-6 bg-br-primary d-flex align-items-center justify-content-center">
        <div class="wd-250 wd-xl-450 mg-y-30">
          <div class="signin-logo tx-28 tx-bold tx-white">
          <?= Html::img('@web/asset_files/images/logo-light-sms.png', ['alt' => 'Logo','width' => '300px', 'style' => 'padding: 5px;','class'=>'img-responsive']) ?>
          </div>
          <div class="tx-white-7 mg-b-60"></div>

          <h5 class="tx-white">Why BongaSMS?</h5>
          <p class="tx-white-6">When it comes to websites or apps, one of the first impression you consider is the design. It needs to be high quality enough otherwise you will lose potential users due to bad design.</p>
          <p class="tx-white-6 mg-b-60">When your website or app is attractive to use, your users will not simply be using it, they’ll look forward to using it. This means that you should fashion the look and feel of your interface for your users.</p>
          <?= Html::a('Create An Account', ['site/register'], $options = ['class'=>'btn btn-outline-light bd bd-white bd-2 tx-white pd-x-25 tx-uppercase tx-12 tx-spacing-2 tx-medium'] ) ?>
        </div><!-- wd-500 -->
      </div>
    </div><!-- row -->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
