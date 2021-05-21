<?php

namespace backend\controllers;

use Yii;
use backend\models\Permissions;
use app\models\PermissionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\libraries\RBAC;
use backend\libraries\Notify;

/**
 * PermissionsController implements the CRUD actions for Permissions model.
 */
class PermissionsController extends Controller
{
    public $layout = 'main_g_inside';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create','view','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Permissions models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!RBAC::can(RBAC::manage_permissions)){throw new NotFoundHttpException(Notify::access_message);}

        $searchModel = new PermissionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Permissions model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!RBAC::can(RBAC::manage_permissions)){throw new NotFoundHttpException(Notify::access_message);}

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Permissions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!RBAC::can(RBAC::manage_permissions)){throw new NotFoundHttpException(Notify::access_message);}

        $model = new Permissions();

        if(Yii::$app->request->post())
        {
            $posted_data = Yii::$app->request->post();
            $actions = $posted_data['Permissions']['actions'];
            $group_id = $posted_data['Permissions']['group_id'];
            $status = $posted_data['Permissions']['status'];

            if($actions == NULL)
            {
                Yii::$app->session->setFlash('error', 'Select Actions');
                return $this->render('create', [
                    'model' => $model,
                ]);
                exit;
            }

            $created = 0;
            $not_created = 0;
            $duplicates =  0;
            if($model->load(Yii::$app->request->post()))
            {
                foreach($actions as $id => $action_id){
                    $model = new Permissions();
                    $model->group_id = $group_id;
                    $model->status = $status; 
                    $model->action_id = $action_id;

                    $permission = Permissions::find()->where(['group_id' => $group_id,'action_id' => $action_id])->one();

                    if($permission)
                    {
                        $duplicates++;
                        continue;
                    }

                    try{
                        if($model->save())
                        {
                            $created ++;

                        }
                    }catch(Exception $e){
                        $not_created ++;
                    }
                    

                }

                $model = new Permissions();
                Yii::$app->session->setFlash('success', 'Successfully Added '.$created.' Permissions. Duplicates '.$duplicates );
                return $this->render('create', [
                    'model' => $model,
                ]);
                exit;
                
            }

           
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Permissions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!RBAC::can(RBAC::manage_permissions)){throw new NotFoundHttpException(Notify::access_message);}

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Permissions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Permissions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Permissions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
       

        if(Yii::$app->user->identity->client_id != RBAC::super_client)//If client not equal to super
        {
            if (($model = Permissions::find()->where('id='.$id.'  AND group_id IN(SELECT group_id FROM user_groups WHERE group_id IN(SELECT id FROM groups WHERE client_id='.Yii::$app->user->identity->client_id.') )')->one() !== null)) {
                $model = Permissions::find()->where('id='.$id.'  AND group_id IN(SELECT group_id FROM user_groups WHERE group_id IN(SELECT id FROM groups WHERE client_id='.Yii::$app->user->identity->client_id.') )')->one();
                return $model;
            }
        }else{
            if (($model = Permissions::findOne($id)) !== null) {
                $model = Permissions::findOne($id);
                return $model;
            }

        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
