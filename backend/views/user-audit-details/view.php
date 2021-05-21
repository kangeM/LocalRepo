<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UserAuditDetails */

$this->title = 'View user-audit-details';
$this->params['breadcrumbs'][] = ['label' => 'User Audit Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa fa-users"></i> View user-audit-details : <?= Html::encode($this->title) ?></h2>
  </div>
  </div>

 <div id="w0" class="x_panel">
<div class="user-audit-details-view">

    <p class="pull-right">
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_audit_id',
            'old_value:ntext',
            'new_value:ntext',
            'field',
            'inserted_at',
        ],
    ]) ?>

</div>
</div>
