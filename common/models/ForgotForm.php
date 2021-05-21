<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Forgot form
 */
class ForgotForm extends Model
{
    public $email;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email'], 'required'],
        ];
    }

    
}
