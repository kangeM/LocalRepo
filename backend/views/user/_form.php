<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Status;
use backend\models\Clients;
use backend\models\Groups;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

//Get status
$statusList=ArrayHelper::map(Status::find()->limit(2)->all(), 'id', 'status');
if(Yii::$app->user->identity->client_id != 1)//If client not equal to super
{
    $clientList=ArrayHelper::map(Clients::find()->where('id ='.Yii::$app->user->identity->client_id)->all(), 'id', 'name');
    $groupList=ArrayHelper::map(Groups::find()->where('client_id='.Yii::$app->user->identity->client_id.' OR id=2')->all(), 'id', 'group');


}else{

    $clientList=ArrayHelper::map(Clients::find()->all(), 'id', 'name');
    $groupList=ArrayHelper::map(Groups::find()->all(), 'id', 'group');


}

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php  //echo $form->errorSummary($model); ?>

    <div class="x_panel">
<div class="x_title">
<h2>User Details</h2>
<div class="clearfix"></div>
</div>
<div class="x_content">

<?= $form->field($model, 'names')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'msisdn')->textInput(['maxlength' => true]) ?>



<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

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


<?php if($model->isNewRecord){?>

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

<?php } ?>

</div>
</div>


<div class="x_panel">
<div class="x_title">
<h2>Security Related</h2>
<div class="clearfix"></div>
</div>
<div class="x_content">
<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

<?= $form->field($model, 'password_confirm')->passwordInput(['maxlength' => true]) ?>
</div>
</div>

    

    
    

    


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



