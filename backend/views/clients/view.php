<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Clients */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa fa-users"></i> View <?= Html::encode($this->title) ?></h2>
  </div>
  </div>

 <div id="w0" class="x_panel">
<div class="clients-view">

    <p class="pull-right">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email:email',
            'phone',
            'address:ntext',
            'sms_credits_cr',
            'sms_credits_dr',
            'sms_credits',
            'api_key',
            'api_secret',
            'api_token',
            'status0.status',
            'inserted_at',
            'updated_at',
        ],
    ]) ?>

</div>
</div>
