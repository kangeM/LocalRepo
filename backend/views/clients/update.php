<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Clients */

$this->title = 'Update Clients: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa "></i> <?= Html::encode($this->title) ?></h2>
  </div>
  </div>

  <div id="w0" class="x_panel">
<div class="clients-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
