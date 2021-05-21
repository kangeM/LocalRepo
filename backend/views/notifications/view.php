<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Notifications */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa fa-users"></i> View notifications : <?= Html::encode($this->title) ?></h2>
  </div>
  </div>

 <div id="w0" class="x_panel">
<div class="notifications-view">

    <p class="pull-right">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'email:email',
            'msisdn',
            'subject',
            'message:ntext',
            'status',
            'processed',
            'inserted_at',
            'updated_at',
        ],
    ]) ?>

</div>
</div>
