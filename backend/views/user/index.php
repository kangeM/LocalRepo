<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
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
<div class="user-index">

    
    

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Create User', ['create'], ['class' => 'btn btn-success pull-right']) ?>
        <div class="clearfix"></div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'names',
            'msisdn',
            //'username',
            'email:email',
            'client.name',
            'status0.status',
            //'created_by',
            //'updated_by',
            'inserted_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>


  </div>