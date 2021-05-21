<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'View Profile';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

  <div id="w0" class="x_panel">
  <div class="pull-right">
        <?= Html::a('<i class="fa fa-toggle-left m-right-xs"></i> Go Back To Users', ['user/index'], ['class' => 'btn btn-primary']) ?>
        
  </div>
  </div>

<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-user"></i> <?php echo $model->names;?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <?= DetailView::widget([
                          'model' => $model,
                          'attributes' => [
                              'id',
                              'names',
                              'msisdn',
                              //'username',
                              //'auth_key',
                              //'password_hash',
                              //'password_reset_token',
                              'email:email',
                              'client.name',
                              'status0.status',
                              'createdBy.names',
                              'updatedBy.names',
                              'inserted_at',
                              'updated_at',
                          ],
                      ]) ?>
                      

                      <?= Html::a('<i class="fa fa-edit m-right-xs"></i> Edit User Info', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

                      <br />

                     
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                      

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active">
                        <a href="#tab_content1" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Groups</a>
                        </li>
                        <li role="presentation">
                        <a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Permissions</a>
                        </li>
                      
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                          <?= Html::a('<i class="fa fa-edit m-right-xs"></i> Manage User Groups', ['user-groups/index', 'user_id' => $model->id], ['class' => 'btn btn-info pull-right']) ?>

                            <?= GridView::widget([
                                'dataProvider' => $groupsDataProvider,
                                //'filterModel' => $searchModel,
                                'columns' => [
                                    //['class' => 'yii\grid\SerialColumn'],

                                    'id',
                                    //'user0.names',
                                    'group0.group',
                                    'status0.status',
                                    'createdBy.names',
                                    //'updated_by',
                                    //'inserted_at',
                                    //'updated_at',

                                    ['class' => 'yii\grid\ActionColumn','template'=>''],
                                ],
                            ]); ?>

                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <!-- start user permissions -->
                            <?= GridView::widget([
                                'dataProvider' => $permissionsDataProvider,
                                //'filterModel' => $searchModel,
                                'columns' => [
                                    //['class' => 'yii\grid\SerialColumn'],

                                    'id',
                                    'group0.group',
                                    'action0.action',
                                    'status0.status',
                                    'createdBy.names',
                                    //'updatedBy.names',
                                    //'inserted_at',
                                    //'updated_at',

                                    ['class' => 'yii\grid\ActionColumn','template'=>''],
                                ],
                            ]); ?>
                            <!-- end user permissions -->

                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                            <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui
                              photo booth letterpress, commodo enim craft beer mlkshk </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>