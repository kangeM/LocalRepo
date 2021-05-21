<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\UserAudits */

$this->title = 'View user-audits';
$this->params['breadcrumbs'][] = ['label' => 'User Audits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h2>
  </div>
  </div>

 <div id="w0" class="x_panel">
<div class="user-audits-view">

    <p class="pull-right">
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user0.names',
            'client.name',
            'action.action',
            'comments:ntext',
            'table_name',
            'table_key',
            'status0.status',
            'inserted_at',
            'updated_at',
        ],
    ]) ?>

 <div class="clearfix"></div>
      <h2>Audit Details </h2>

 <div class="clearfix"></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'user_audit_id',
            'old_value:ntext',
            'new_value:ntext',
            'field',
            'inserted_at',

            //['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}{delete}'],
        ],
    ]); ?>

</div>
</div>


