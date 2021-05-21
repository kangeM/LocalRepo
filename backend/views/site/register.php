<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
          <h4 class="tx-inverse tx-center">Create An Account</h4>
          <?= $this->render('_alerts_partial.php') ?>
          
          <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'class'=>'form-horizontal m-t-20',
                            'fieldConfig' => [
                                'options' => [
                                    //'tag' => false,
                                ],
                            ],]); 
                ?>
         <p class="tx-center mg-b-20">Step 1 : Account Details</p>
          <div class="form-group">
            <?= $form->field($model, 'account_name')->textInput(['autofocus' => true,'class'=>'form-control ','placeholder'=>'Email','required'=>'required'])->label(false) ?>
          </div><!-- form-group -->
          <div class="form-group">
          <?= $form->field($model, 'account_msisdn')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Account Phone Number','required'=>'required'])->label(false) ?>
          </div><!-- form-group -->
          <div class="form-group">
          <?= $form->field($model, 'account_email')->textInput(['autofocus' => true,'class'=>'form-control ','placeholder'=>'Account Email','required'=>'required'])->label(false) ?>
          </div><!-- form-group -->

          <p class="tx-center mg-b-20">Step 2 : Account Admin User Details</p>
          <div class="form-group">
          <?= $form->field($model, 'admin_name')->textInput(['autofocus' => true,'class'=>'form-control ','placeholder'=>'Admin Name','required'=>'required'])->label(false) ?>
          </div><!-- form-group -->
          <div class="form-group">
          <?= $form->field($model, 'admin_msisdn')->textInput(['autofocus' => true,'class'=>'form-control ','placeholder'=>'Admin Phone Number','required'=>'required'])->label(false) ?>
          </div><!-- form-group -->
          <div class="form-group">
          <?= $form->field($model, 'admin_email')->textInput(['autofocus' => true,'class'=>'form-control ','placeholder'=>'Admin Email','required'=>'required'])->label(false) ?>
          </div><!-- form-group -->
          <div class="form-group">
          <?= $form->field($model, 'password')->passwordInput(['autofocus' => true,'class'=>'form-control ','placeholder'=>'Password','required'=>'required'])->label(false) ?>
          </div><!-- form-group -->
          <div class="form-group">
          <?= $form->field($model, 'password_confirm')->passwordInput(['autofocus' => true,'class'=>'form-control ','placeholder'=>'Confirm Password','required'=>'required'])->label(false) ?>
          </div><!-- form-group -->

         
         
          <div class="form-group tx-12">By clicking Create Account button below you indicate you have agreed to our privacy policy and terms of use of our website.</div>


          
          <?= Html::submitButton('Create Account', ['class' => 'btn btn-info btn-block', 'name' => 'login-button', 'type'=>'submit']) ?>

          <?php ActiveForm::end(); ?>
          
          <div class="mg-t-60 tx-center"><?= Html::a('Have An Account? Click Here To Sign In.', ['site/login'], $options = ['class'=>'tx-info'] ) ?></div>
    </div><!-- login-wrapper -->


