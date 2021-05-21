<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
          <h4 class="tx-inverse tx-center">Sign In</h4>
          <p class="tx-center mg-b-60">Enter Your Credentials Below</p>
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
          <div class="form-group">
            <?= $form->field($model, 'email')->textInput(['autofocus' => true,'class'=>'form-control ','placeholder'=>'Email','required'=>'required'])->label(false) ?>
          </div><!-- form-group -->
          <div class="form-group">
          <?= $form->field($model, 'password')->passwordInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Password','required'=>'required'])->label(false) ?>

          </div><!-- form-group -->
         
         
          <div class="form-group tx-12">
          <?= Html::a('Lost Your Password ?', ['site/forgot'], $options = ['class'=>'tx-info'] ) ?>
          </div>
          <?= Html::submitButton('Login', ['class' => 'btn btn-info btn-block', 'name' => 'login-button', 'type'=>'submit']) ?>

          <?php ActiveForm::end(); ?>
          
          <div class="mg-t-60 tx-center"><?= Html::a('Click Here To Create An Account', ['site/register'], $options = ['class'=>'tx-info'] ) ?></div>
    </div><!-- login-wrapper -->

