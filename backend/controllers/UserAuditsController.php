<?php

namespace backend\controllers;

use Yii;
use backend\models\UserAudits;
use app\models\UserAuditsSearch;
use app\models\UserAuditDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\libraries\Commons;
use backend\libraries\Statuses;
use backend\libraries\RBAC;
use backend\libraries\Notify;
use yii\filters\AccessControl;

/**
 * UserAuditsController implements the CRUD actions for UserAudits model.
 */
class UserAuditsController extends Controller
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
     * Lists all UserAudits models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!RBAC::can(RBAC::view_user_audits)){throw new NotFoundHttpException(Notify::access_message);}

        $searchModel = new UserAuditsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserAudits model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!RBAC::can(RBAC::view_user_audits)){throw new NotFoundHttpException(Notify::access_message);}

        $searchModel = new UserAuditDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new UserAudits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!RBAC::can(RBAC::view_user_audits)){throw new NotFoundHttpException(Notify::access_message);}
        $model = new UserAudits();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserAudits model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!RBAC::can(RBAC::view_user_audits)){throw new NotFoundHttpException(Notify::access_message);}
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserAudits model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
    public function actionDelete($id)
    {
        if(!RBAC::can(RBAC::manage_useraudits)){throw new NotFoundHttpException(Notify::access_message);}
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    */

    /**
     * Finds the UserAudits model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserAudits the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
       
        if(Yii::$app->user->identity->client_id != RBAC::super_client)//If client not equal to super
        {
            if (($model = UserAudits::find()->where('client_id='.Yii::$app->user->identity->client_id.' or client_id IN (SELECT id FROM clients where parent_id='.Yii::$app->user->identity->client_id.') and id ='.$id)->one() !== null)) {
                $model = UserAudits::find()->where('client_id='.Yii::$app->user->identity->client_id.' or client_id IN (SELECT id FROM clients where parent_id='.Yii::$app->user->identity->client_id.') and id ='.$id)->one();
                return $model;
            }
        }else{
            
                if (($model = UserAudits::findOne($id)) !== null) {
                    $model = UserAudits::findOne($id);
                    return $model;
                }

            

        }
        

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
