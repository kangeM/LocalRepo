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
$statusList=ArrayHelper::map(Status::find()->all(), 'id', 'status');
$clientList=ArrayHelper::map(Clients::find()->all(), 'id', 'name');
$groupList=ArrayHelper::map(Groups::find()->all(), 'id', 'group');

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



