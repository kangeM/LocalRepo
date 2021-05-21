<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserGroupsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Groups';
$this->params['breadcrumbs'][] = $this->title;


?>

<div id="w0" class="x_panel">
  <div class="">
  <h2><i class="fa fa-users"></i> Manage <?= Html::encode($this->title) ?></h2>
  </div>
  </div>

    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
<div id="w0" class="x_panel">
<div class="user-groups-index">

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Create User Groups', ['create'], ['class' => 'btn btn-success pull-right']) ?>
        <div class="clearfix"></div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'user0.names',
            'group0.group',
            'status0.status',
            'createdBy.names',
            //'updated_by',
            //'inserted_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}{delete}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>