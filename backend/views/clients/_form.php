<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Status;
use backend\models\Clients;
/* @var $this yii\web\View */
/* @var $model backend\models\Clients */
/* @var $form yii\widgets\ActiveForm */

//Get status
$statusList=ArrayHelper::map(Status::find()->limit(2)->all(), 'id', 'status');if(Yii::$app->user->identity->client_id != 1)//If client not equal to super
{
    $clientList=ArrayHelper::map(Clients::find()->where('id ='.Yii::$app->user->identity->client_id)->all(), 'id', 'name');
}else{

    $clientList=ArrayHelper::map(Clients::find()->all(), 'id', 'name');
}

?>

<div class="clients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sms_credits_cr')->textInput() ?>

    <?= $form->field($model, 'sms_credits_dr')->textInput() ?>

    <?= $form->field($model, 'sms_credits')->textInput() ?>

    <?= $form->field($model, 'api_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'api_secret')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'api_token')->textInput(['maxlength' => true]) ?>

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

<?php
              echo $form->field($model, 'parent_id')->widget(Select2::classname(), [
                  'data' => $clientList,
                  'language' => 'en',
                  'options' => ['placeholder' => 'Select Parent ...'],
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
