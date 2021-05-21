<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h2>
  </div>
  </div>
  <div id="w0" class="x_panel">
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
    </div>
