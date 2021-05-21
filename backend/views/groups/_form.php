<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Clients;

/* @var $this yii\web\View */
/* @var $model backend\models\Groups */
/* @var $form yii\widgets\ActiveForm */

if(Yii::$app->user->identity->client_id != 1)//If client not equal to super
{
    $clientList=ArrayHelper::map(Clients::find()->where('id ='.Yii::$app->user->identity->client_id)->all(), 'id', 'name');
}else{

    $clientList=ArrayHelper::map(Clients::find()->all(), 'id', 'name');
}
?>

<div class="groups-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php  //echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'group')->textInput(['maxlength' => true]) ?>

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

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
