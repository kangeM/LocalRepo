<?php

namespace backend\controllers;

use Yii;
use backend\models\UserGroups;
use app\models\UserGroupsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\libraries\RBAC;
use backend\libraries\Notify;

/**
 * UserGroupsController implements the CRUD actions for UserGroups model.
 */
class UserGroupsController extends Controller
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
     * Lists all UserGroups models.
     * @return mixed
     */
    public function actionIndex($user_id=NULL)
    {
        if(!RBAC::can(RBAC::manage_user_groups)){throw new NotFoundHttpException(Notify::access_message);}

        $searchModel = new UserGroupsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$user_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserGroups model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!RBAC::can(RBAC::manage_user_groups)){throw new NotFoundHttpException(Notify::access_message);}
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserGroups model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!RBAC::can(RBAC::manage_user_groups)){throw new NotFoundHttpException(Notify::access_message);}

        $model = new UserGroups();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserGroups model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!RBAC::can(RBAC::manage_user_groups)){throw new NotFoundHttpException(Notify::access_message);}
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserGroups model.
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
     * Finds the UserGroups model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserGroups the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(Yii::$app->user->identity->client_id != RBAC::super_client)//If client not equal to super
        {
            if (($model = UserGroups::find()->where('user_id IN (SELECT id FROM user where client_id='.Yii::$app->user->identity->client_id.') and id ='.$id)->one() !== null)) {
                $model = UserGroups::find()->where('user_id IN (SELECT id FROM user where client_id='.Yii::$app->user->identity->client_id.') and id ='.$id)->one();
                return $model;
            }
        }else{
            if (($model = UserGroups::findOne($id)) !== null) {
                $model = UserGroups::findOne($id);
                return $model;
            }

        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
