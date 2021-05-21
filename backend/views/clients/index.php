<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa fa-cogs"></i> Manage <?= Html::encode($this->title) ?></h2>
  </div>
  </div>

    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

<div id="w0" class="x_panel">
<div class="clients-index">

    <p>
        <?= Html::a('Create Clients', ['create'], ['class' => 'btn btn-success pull-right']) ?>
        <div class="clearfix"></div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'email:email',
            'phone',
            //'address:ntext',
            'sms_credits_cr',
            'sms_credits_dr',
            'sms_credits',
            //'api_key',
            //'api_secret',
            //'api_token',
            'status0.status',
            'inserted_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}{delete}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
