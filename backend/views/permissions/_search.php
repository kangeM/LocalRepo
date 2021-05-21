<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Groups;
use backend\models\Actions;

/* @var $this yii\web\View */
/* @var $model app\models\PermissionsSearch */
/* @var $form yii\widgets\ActiveForm */


if(Yii::$app->user->identity->client_id != 1)//If client not equal to super
{
  $actionList=ArrayHelper::map(Actions::find()->where('visible=1')->all(), 'id', 'action');
  $groupList=ArrayHelper::map(Groups::find()->where('client_id='.Yii::$app->user->identity->client_id.' OR id=2')->all(), 'id', 'group');


}else{

  $actionList=ArrayHelper::map(Actions::find()->all(), 'id', 'action');
  $groupList=ArrayHelper::map(Groups::find()->all(), 'id', 'group');


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

<div class="permissions-search">

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
              echo $form->field($model, 'group_id')->widget(Select2::classname(), [
                  'data' => $groupList,
                  'language' => 'en',
                  'options' => ['placeholder' => 'Select Group ...'],
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
