<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Recover Password';
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
          <h4 class="tx-inverse tx-center">Recover Password</h4>
          <p class="tx-center mg-b-60">Enter Email Address Below</p>
          <?= $this->render('_alerts_partial.php') ?>
          <?php $form = ActiveForm::begin([
                            'id' => 'forgot-form',
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
          
         
          <div class="form-group tx-12">
          <?= Html::a('Remebered Your Password ?', ['site/login'], $options = ['class'=>'tx-info'] ) ?>
          </div>
          <?= Html::submitButton('Submit', ['class' => 'btn btn-info btn-block', 'name' => 'login-button', 'type'=>'submit']) ?>

          <?php ActiveForm::end(); ?>
          
          <div class="mg-t-60 tx-center"><?= Html::a('Have An Account? Click Here To Sign In. ?', ['site/register'], $options = ['class'=>'tx-info'] ) ?></div>
    </div><!-- login-wrapper -->

