<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Registration form
 */
class RegistrationForm extends Model
{
    public $account_name;
    public $account_email;
    public $account_msisdn;
    

    public $admin_name;
    public $admin_email;
    public $admin_msisdn;

    public $password;
    public $password_confirm;



    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // required fields
            [['account_name','account_email','account_msisdn','admin_name','admin_email','admin_msisdn','password','password_confirm'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'account_name' => 'Account Name',
            'account_email' => 'Account Emal',
            'account_msisdn' => 'Account MSISDN',
            'admin_name' => 'Admin User Name',
            'admin_email' => 'Admin User Email',
            'admin_msisdn' => 'Admin User MSISDN',
            'password' => 'Password',
            'password_confirm' => 'Confirm Password',
            
        ];
    }

    
}
