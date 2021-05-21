<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Groups;
use backend\models\User;
use backend\models\Status;
use backend\models\Clients;
use backend\models\Actions;

/* @var $this yii\web\View */
/* @var $model app\models\UserAuditsSearch */
/* @var $form yii\widgets\ActiveForm */

$statusList=ArrayHelper::map(Status::find()->limit(2)->all(), 'id', 'status');

if(Yii::$app->user->identity->client_id != 1)//If client not equal to super
{
    $userList=ArrayHelper::map(User::find()->where(['client_id'=>Yii::$app->user->identity->client_id])->all(), 'id', 'names');
    $clientList=ArrayHelper::map(Clients::find()->where('id ='.Yii::$app->user->identity->client_id)->all(), 'id', 'name');
    $actionList=ArrayHelper::map(Actions::find()->where('visible=1')->all(), 'id', 'action');


}else{

  $userList=ArrayHelper::map(User::find()->all(), 'id', 'names');
  $clientList=ArrayHelper::map(Clients::find()->all(), 'id', 'name');
  $actionList=ArrayHelper::map(Actions::find()->all(), 'id', 'action');


}
?>
<div class="x_panel">
  <div class="x_title">
    <h2> 
      <i class="fa fa-search">
      </i> Search 
    </h2>
    <ul class="nav navbar-right panel_toolbox">
      <li>
        <a class="collapse-link">
          <i class="fa fa-chevron-up">
          </i>
        </a>
      </li>
      <li>
        <a class="close-link">
          <i class="fa fa-close">
          </i>
        </a>
      </li>
    </ul>
    <div class="clearfix">
    </div>
  </div>
  <div class="x_content">

<div class="user-audits-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
        <?php
              echo $form->field($model, 'user_id')->widget(Select2::classname(), [
                  'data' => $userList,
                  'language' => 'en',
                  'options' => ['placeholder' => 'Select User ...'],
                  'pluginOptions' => [
                      'allowClear' => true
                  ],
              ]);
          ?>
        </div>
        <div class="col-md-6">
        <?php
              echo $form->field($model, 'client_id')->widget(Select2::classname(), [
                  'data' => $clientList,
                  'language' => 'en',
                  'options' => ['placeholder' => 'Select Client ...'],
                  'pluginOptions' => [
                      'allowClear' => true
                  ],
              ]);
          ?>
        </div>
        <div class="col-md-6">
        <?php
              echo $form->field($model, 'action_id')->widget(Select2::classname(), [
                  'data' => $actionList,
                  'language' => 'en',
                  'options' => ['placeholder' => 'Select Actions ...'],
                  'pluginOptions' => [
                      'allowClear' => true
                  ],
              ]);
          ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'comments') ?>
        </div>
      </div>
    </div>

    <div class="form-group pull-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
