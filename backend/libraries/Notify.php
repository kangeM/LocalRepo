<?php

namespace backend\libraries;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

use backend\models\Notifications;
/**
* Notifications
*/
class Notify 
{

  //Access Message
  const access_message = 'The requested page does not exist or you do not have sufficient rights to access it.';

  //New Registration Notification
  public static function registration_notification($account_name,$account_email,$admin_msisdn,$admin_email,$admin_name,$client_id)
  {
    //send email
    $subject=Yii::$app->name." Registration Notification";
    $message='Hi '.$admin_name.' ,<br/>
              Your '.Yii::$app->name.' account has has been processed. Details are listed below :<br/><br/>
              
              Account Name : '.$account_name.'<br/>
              Account Email: '.$account_email.'<br/>
              Account Phone: '.$admin_msisdn.'<br/><br/>

              Admin User Name  : '.$admin_name.'<br/>
              Admin User Phone : '.$admin_msisdn.'<br/>
    <br/>';


    $result = Notify::create_notifications($admin_email,$admin_msisdn,$message,$subject,$client_id);

    return $result;
  }
  //Password Reset Notification
  public static function password_forgot_notification($token,$email,$msisdn,$client_id)
  {

    //send email
    $subject=Yii::$app->name." Forgot Password Notification";
    $message='Hi ,<br/>
              Your '.Yii::$app->name.' account password recovery request has been processed. Kindly Follow the below link to complete your password recovery.<br/><br/>
              Link:<a href="'.Yii::$app->params['base_url'].'/site/recover-password?&email='.$email.'&token='.$token.'">Password Recover Link</a>
    <br/>';


    $result = Notify::create_notifications($email,$msisdn,$message,$subject,$client_id);

    return $result;


  }

  public static function create_notifications($email,$msisdn,$message,$subject,$client_id)
  {
      
      //Insert into notifications
      $notify = new Notifications();
      $notify->email = $email;
      $notify->msisdn = $msisdn;
      $notify->message = $message;
      $notify->subject = $subject;
      $notify->client_id = $client_id;
      $notify->status = Statuses::ACTIVE;

      if($notify->save())
      {
        return TRUE;
      }else{
        return FALSE;
      }
  }
}

?>