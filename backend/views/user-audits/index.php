<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserAuditsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Audits';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa fa-bar-chart-o"></i> Manage <?= Html::encode($this->title) ?></h2>
  </div>
  </div>

    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
<div id="w0" class="x_panel">
<div class="user-audits-index">

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'user0.names',
            'client.name',
            'action.action',
            'comments:ntext',
            //'table_name',
            //'table_key',
            //'status',
            'inserted_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>