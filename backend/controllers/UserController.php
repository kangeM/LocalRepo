<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\libraries\Commons;
use backend\libraries\Statuses;
use backend\libraries\Audits;
use backend\models\UserGroups;
use app\models\UserGroupsSearch;
use app\models\PermissionsSearch; 
use backend\libraries\RBAC;
use backend\libraries\Notify;
use yii\filters\AccessControl;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                        'actions' => ['index', 'view', 'create','view','update','view-profile','update-profile'],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!RBAC::can(RBAC::manage_users)){throw new NotFoundHttpException(Notify::access_message);}

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!RBAC::can(RBAC::manage_users)){throw new NotFoundHttpException(Notify::access_message);}

        //Groups Search
        $searchModel = new UserGroupsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$id);

        //Permissions Search
        $searchModel2 = new PermissionsSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->post(),$id);

        $model = $this->findModel($id);
        return $this->render('view_profile', [
            'model' => $model,
            'groupsDataProvider' => $dataProvider,
            'permissionsDataProvider' => $dataProvider2,
        ]);
    }

    //View User Profile 
    public function actionViewProfile()
    {
        $id = Yii::$app->user->id ;
        //Groups Search
        $searchModel = new UserGroupsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$id);

        //Permissions Search
        $searchModel2 = new PermissionsSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->post(),$id);


        return $this->render('view_user_profile', [
            'model' => $this->findModel($id),
            'groupsDataProvider' => $dataProvider,
            'permissionsDataProvider' => $dataProvider2,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!RBAC::can(RBAC::manage_users)){throw new NotFoundHttpException(Notify::access_message);}
        $model = new User();

        //Check the submitted passwords if post
        if(Yii::$app->request->post())
        {
            $posted_data = Yii::$app->request->post();
            $password = $posted_data['User']['password'];
            $password_confirm = $posted_data['User']['password_confirm'];
            $group_id = $posted_data['User']['group_id'];

            if($group_id==NULL)
            {
                //Set session
                Yii::$app->session->setFlash('error', 'Select Group');
                return $this->render('create', [
                    'model' => $model,
                ]);
                exit;
            }
            
            if( ($password != $password_confirm) || $password == NULL || $password == NULL)
            {
                $model->load(Yii::$app->request->post());
                //Set session
                Yii::$app->session->setFlash('error', 'Password and Password Confirm Must Be Identical');
                return $this->render('create', [
                    'model' => $model,
                ]);
                exit;
            }

            
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->password_hash=Commons::hashString($password);// password
            $model->save();//Save


            //Create User - Group
            $model_groups = new UserGroups();
            $model_groups->user_id = $model->id;
            $model_groups->group_id = $group_id;
            $model_groups->status = Statuses::ACTIVE;
            $model_groups->save();//Save

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!RBAC::can(RBAC::manage_users)){throw new NotFoundHttpException(Notify::access_message);}
        $model = $this->findModel($id);
        $oldattributes = $model->getAttributes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Check if password was set and update
            $posted_data = Yii::$app->request->post();
            $password = $posted_data['User']['password'];
            $password_confirm = $posted_data['User']['password_confirm'];

            $user_audit_id = Audits::logAudit($user_id=Yii::$app->user->identity->id,$client_id=Yii::$app->user->identity->client_id,$action_id=RBAC::manage_users,$comments='UPDATE',$table_name='user',$table_key=$model->id,$status=Statuses::SUCCESS);
            Audits::logAuditDetails($oldattributes,$model,$user_audit_id);

            if($password == NULL && $password == NULL)
            {

                 //Set session
                Yii::$app->session->setFlash('success', 'Successfully updated user - '.$id);
                return $this->redirect(['view', 'id' => $model->id]);

                
            }else{
                if( ($password != $password_confirm) )
                {
                    $model->load(Yii::$app->request->post());
                    //Set session
                    Yii::$app->session->setFlash('error', 'Password and Password Confirm Must Be Identical');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                    exit;
                }else{
                    //Update the password
                    $model->password_hash=Commons::hashString($password);// password
                    $model->save();//Save

                    Yii::$app->session->setFlash('success', 'Successfully updated user - '.$id);

                    return $this->redirect(['view', 'id' => $model->id]);

                }

            }

           
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    //Update user profile .. different from the admin
    public function actionUpdateProfile()
    {
        $id = Yii::$app->user->id ;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Check if password was set and update
            $posted_data = Yii::$app->request->post();
            $password = $posted_data['User']['password'];
            $password_confirm = $posted_data['User']['password_confirm'];

            if($password == NULL && $password_confirm == NULL)
            {

                 //Set session
                 Yii::$app->session->setFlash('success', 'Successfully updated profile info');

                 return $this->redirect(['view-profile']);

            }else{
                if( ($password != $password_confirm) )
                {
                    $model->load(Yii::$app->request->post());
                    //Set session
                    Yii::$app->session->setFlash('error', 'Password and Password Confirm Must Be Identical');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                    exit;
                }else{
                    //Update the password
                    $model->password_hash=Commons::hashString($password);// password
                    $model->save();//Save

                    Yii::$app->session->setFlash('success', 'Successfully updated profile info');

                    return $this->redirect(['view-profile']);

                }

            }

           
        }

        return $this->render('update_profile', [
            'model' => $model,
        ]);
    }



    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
    public function actionDelete($id)
    {
        if(!RBAC::can(RBAC::manage_users)){throw new NotFoundHttpException(Notify::access_message);}
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(Yii::$app->user->identity->client_id != RBAC::super_client)//If client not equal to super
        {
            if (($model = User::find()->where('client_id='.Yii::$app->user->identity->client_id.' or client_id IN (SELECT id FROM clients where parent_id='.Yii::$app->user->identity->client_id.') and id ='.$id)->one() !== null)) {
                $model = User::find()->where('client_id='.Yii::$app->user->identity->client_id.' or client_id IN (SELECT id FROM clients where parent_id='.Yii::$app->user->identity->client_id.') and id ='.$id)->one();
                return $model;
            }
        }else{
            if (($model = User::findOne($id)) !== null) {
                $model = User::findOne($id);
                return $model;
            }

        }

        throw new NotFoundHttpException('The requested page does not exist.');

        
    }
}
