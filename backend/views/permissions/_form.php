<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Groups;
use backend\models\Actions;
use backend\models\Status;
use softark\duallistbox\DualListbox;


/* @var $this yii\web\View */
/* @var $model backend\models\Permissions */
/* @var $form yii\widgets\ActiveForm */


$statusList=ArrayHelper::map(Status::find()->limit(2)->all(), 'id', 'status');


if(Yii::$app->user->identity->client_id != 1)//If client not equal to super
{
  $actionList=ArrayHelper::map(Actions::find()->where('visible=1')->all(), 'id', 'action');
  $groupList=ArrayHelper::map(Groups::find()->where('client_id='.Yii::$app->user->identity->client_id.'')->all(), 'id', 'group');


}else{

  $actionList=ArrayHelper::map(Actions::find()->all(), 'id', 'action');
  $groupList=ArrayHelper::map(Groups::find()->all(), 'id', 'group');


}

?>

<div class="permissions-form">

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

    <?php if($model->isNewRecord){?>
    
    <?php
        $options = [
            'multiple' => true,
            'size' => 20,
        ];
        echo $form->field($model, 'actions')->widget(DualListbox::className(),[
            'items' => $actionList,
            'options' => $options,
            'clientOptions' => [
                'moveOnSelect' => false,
                'selectedListLabel' => 'Selected Actions',
                'nonSelectedListLabel' => 'Available Actions',
            ],
        ]);
    ?>

    <?php }else { ?>

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

    <?php } ?>


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
