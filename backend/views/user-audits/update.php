<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserAudits */

$this->title = 'Update User Audits: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Audits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa "></i> <?= Html::encode($this->title) ?></h2>
  </div>
  </div>

  <div id="w0" class="x_panel">
<div class="User Audits-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
