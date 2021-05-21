<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NotificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa "></i> Manage <?= Html::encode($this->title) ?></h2>
  </div>
  </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div id="w0" class="x_panel">
<div class="notifications-index">

    <p>
        <?= Html::a('<i class=\"fa fa-plus\"></i> Create Notifications', ['create'], ['class' => 'btn btn-success pull-right']) ?>
        <div class="clearfix"></div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',
            'msisdn',
            'subject',
            'message:ntext',
            //'status',
            //'processed',
            //'inserted_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}{delete}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>