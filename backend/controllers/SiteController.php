<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\ForgotForm;
use backend\libraries\RBAC;
use backend\libraries\Statuses;
use backend\libraries\Commons;
use backend\libraries\Notify;
use backend\models\User;
use backend\models\Clients;
use app\models\UserSearch;
use backend\models\Notifications;
use common\models\RegistrationForm;
use backend\models\UserGroups;
/**
 * Site controller
 */
class SiteController extends Controller
{
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
                        'actions' => ['login', 'error','forgot','recover-password', 'reset-password','register'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }
   
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

   

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main_g_inside';
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'main_outside';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            RBAC::getPermissions(Yii::$app->user->identity->id);

            /*if(!RBAC::can(RBAC::omnipotent))
            {
                echo 'User is not omnipotent';
            }*/
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    //Registration
    public function actionRegister()
    {
        $this->layout = 'main_outside';
        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post())) {

            //Check password
            $password = $model->password;
            $password_confirm = $model->password_confirm;
            if( ($password != $password_confirm) )
            {
                //Set session
                Yii::$app->session->setFlash('error', 'Password and Password Confirm Must Be Identical');
                return $this->render('register', [
                    'model' => $model,
                ]);
                exit;
            }

            //Check email
            $client = Clients::find()->where(['email'=>$model->account_email])->one();
            if($client)
            {
                //Set session
                Yii::$app->session->setFlash('error', 'Account Email Has Been Taken');
                $model->addError('account_email', 'Account Email Has Been Taken');
                return $this->render('register', [
                    'model' => $model,
                ]);
                exit;
            }

            //check user email
            $user = User::find()->where(['email'=>$model->admin_email])->one();
            if($user)
            {
                //Set session
                Yii::$app->session->setFlash('error', 'Admin Email Has Been Taken');
                $model->addError('admin_email', 'Admin Email Has Been Taken');
                return $this->render('register', [
                    'model' => $model,
                ]);
                exit;
            }

            //Validate phone numbers
            $account_msisdn = Commons::formatMSISDN($model->account_msisdn);
            $admin_msisdn = Commons::formatMSISDN($model->admin_msisdn);
            $model->account_msisdn = $account_msisdn;
            $model->admin_msisdn = $admin_msisdn;

            if(Commons::isValidMobileNo($account_msisdn)==0)
            {
                $model->addError('account_msisdn', 'Invalid Phone Number');
                return $this->render('register', [
                    'model' => $model,
                ]);
                exit;
            }


            if(Commons::isValidMobileNo($admin_msisdn)==0)
            {
                $model->addError('admin_msisdn', 'Invalid Phone Number');
                return $this->render('register', [
                    'model' => $model,
                ]);
                exit;
            }


            //Create Client 
            $client = new Clients();
            $client->name = $model->account_name;
            $client->email = $model->account_email;
            $client->phone = $model->account_msisdn;
            $client->status = Statuses::ACTIVE;

            if($client->save())
            {
                $user = new User();
                $user->names = $model->admin_name;
                $user->msisdn = $model->admin_msisdn;
                $user->password_hash = Commons::hashString($model->password);
                $user->email = $model->admin_email;
                $user->client_id = $client->id; 
                $user->status = Statuses::ACTIVE;
                $user->created_by = RBAC::super_admin_user;//AdminUser
                $user->updated_by = RBAC::super_admin_user;//AdminUser

                if($user->save())
                {
                    //Create User Group
                    $model_groups = new UserGroups();
                    $model_groups->user_id = $user->id;
                    $model_groups->group_id = RBAC::admin_group;
                    $model_groups->status = Statuses::ACTIVE;
                    $model_groups->save();//Save

                    Notify::registration_notification($model->account_name,$model->account_email,$model->account_msisdn,$model->admin_email,$user->names,$client->id);

                }else{
                    Yii::$app->session->setFlash('error', 'Contact us, your account was created but something went wrong.');
                    return $this->goHome();
                    exit;

                }

                Yii::$app->session->setFlash('success', 'Successfully Created Account. Login With Your Admin Account.');
                return $this->goHome();
                exit;


            }else{
                Yii::$app->session->setFlash('error', 'An unexpected error occurred, kindly retry.');
                
            }
            

            return $this->render('register', [
                'model' => $model,
            ]);

        } else {

            return $this->render('register', [
                'model' => $model,
            ]);
        }

        

    }

    //Forgot password
    public function actionForgot()
    {
        
        $this->layout = 'main_outside';

        $model = new ForgotForm();
        if ($model->load(Yii::$app->request->post())) {

            $posted_data = Yii::$app->request->post();
            $email = $posted_data['ForgotForm']['email'];

            //Check if user exists
            $user = User::find()->where(['email'=>$email])->one();
            if($user)
            {
                //user found -- generate token and update the users table
                $reset_token = Commons::generateRandomString();

                $user->password_reset_token = Commons::hashString($reset_token);

                if($user->save())
                {
                   
                    Notify::password_forgot_notification($reset_token,$user->email,$user->msisdn,$user->client_id);
                    Yii::$app->session->setFlash('success', 'Email has been sent with reset instructions.');

                }else{
                    Yii::$app->session->setFlash('error', 'Error Occurred Kindly Try Again');

                }
                
            }else{
                $model->addError('email', 'We do not recognize that email.');
            }
           
        } else {
            $model->email = '';

            
        }  

        return $this->render('forgot', [
            'model' => $model,
        ]);

    }

    //Recover Password
    public function actionRecoverPassword($email,$token)
    {
        $this->layout = 'main_g_outside';

        Yii::$app->session['reset_email'] = NULL;
        Yii::$app->session['reset_token'] = NULL;
        //Check Reset Token
        $user = User::find()->where(['email'=>$email])->one();
        if($user)
        {

            //Confirm the token
            $reset_token = $user->password_reset_token;
            $result = Commons::validateHash($token,$reset_token);

            if($result == TRUE)
            {
                Yii::$app->session['reset_email'] = $email;
                Yii::$app->session['reset_token'] = $token;

                return $this->redirect(['reset-password']);
            }else{
                Yii::$app->session->setFlash('error', 'Unrecognized email/token.');
                return $this->goHome();
            }

        }else{
            Yii::$app->session->setFlash('error', 'Unrecognized email/token');
            return $this->goHome();
        }
    }

    //Reset Password
    public function actionResetPassword()
    {
        $this->layout = 'main_g_outside';
        if(isset(Yii::$app->session['reset_email']) && isset(Yii::$app->session['reset_token']))
        {

        }else{
            Yii::$app->session->setFlash('error', 'Unrecognized email/token');
            return $this->goHome();
        }

        if(Yii::$app->request->post())
        {

                $user = User::find()->where(['email'=>Yii::$app->session['reset_email']])->one();
                //Check if password was set and update
                $posted_data = Yii::$app->request->post();
                $password = $posted_data['User']['password'];
                $password_confirm = $posted_data['User']['password_confirm'];
    
                if($password == NULL && $password_confirm == NULL)
                {
    
                     //Set session
                    Yii::$app->session->setFlash('success', 'Enter password and confirm it to proceed');
                    return $this->redirect(['reset-password']);
    
                    
                }else{
                    if( ($password != $password_confirm) )
                    {
                        //Set session
                        Yii::$app->session->setFlash('error', 'Password and Password Confirm Must Be Identical');
                        return $this->redirect(['reset-password']);
                        exit;
                    }else{
                        //Update the password
                        $user->password_hash=Commons::hashString($password);// password
                        $user->password_reset_token = NULL;
                        $user->save();//Save
    
                        Yii::$app->session->setFlash('success', 'Successfully reset your password - proceed to login');
    
                        return $this->goHome();
    
                    }
    
                }
            
    
               
            
        }else{
            $user = User::find()->where(['email'=>Yii::$app->session['reset_email']])->one();

            if($user)
            {
                //Confirm the token
                $reset_token = $user->password_reset_token;
                $result = Commons::validateHash(Yii::$app->session['reset_token'],$reset_token);

                if($result == TRUE)
                {
                   //Load the reset form
                   return $this->render('reset_password', [
                    'model' => $user,
                  ]);

                }else{
                    Yii::$app->session->setFlash('error', 'Unrecognized email/token.');
                    return $this->goHome();
                }
            }else{
                Yii::$app->session->setFlash('error', 'Unrecognized email/token');
                return $this->goHome();
            }
        }

        
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    
}
