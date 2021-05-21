<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Groups;
use backend\models\User;
use backend\models\Status;
/* @var $this yii\web\View */
/* @var $model backend\models\UserGroups */
/* @var $form yii\widgets\ActiveForm */
$statusList=ArrayHelper::map(Status::find()->limit(2)->all(), 'id', 'status');

if(Yii::$app->user->identity->client_id != 1)//If client not equal to super
{
    $userList=ArrayHelper::map(User::find()->where(['client_id'=>Yii::$app->user->identity->client_id])->all(), 'id', 'names');
    $groupList=ArrayHelper::map(Groups::find()->where('client_id='.Yii::$app->user->identity->client_id.' OR id=2')->all(), 'id', 'group');


}else{

  $userList=ArrayHelper::map(User::find()->all(), 'id', 'names');
  $groupList=ArrayHelper::map(Groups::find()->all(), 'id', 'group');


}
?>

<div class="user-groups-form">

    <?php $form = ActiveForm::begin(); ?>


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

    <?php
              echo $form->field($model, 'status')->widget(Select2::classname(), [
                  'data' => $statusList,
                  'language' => 'en',
                  'options' => ['placeholder' => 'Select Status ...'],
                  'pluginOptions' => [
                      'allowClear' => true
                  ],
              ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
