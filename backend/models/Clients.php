<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property int $sms_credits_cr
 * @property int $sms_credits_dr
 * @property int $sms_credits
 * @property string $api_key
 * @property string $api_secret
 * @property string $api_token
 * @property int $status
 * @property int $parent_id
 * @property string $reseller_flag
 * @property double $cost_per_sms
 * @property string $inserted_at
 * @property string $updated_at
 */
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'inserted_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address'], 'string'],
            [['sms_credits_cr', 'sms_credits_dr', 'sms_credits', 'status', 'parent_id'], 'integer'],
            [['cost_per_sms'], 'number'],
            [['inserted_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['email', 'api_key', 'api_secret', 'api_token'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['reseller_flag'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'sms_credits_cr' => 'Sms Credits Cr',
            'sms_credits_dr' => 'Sms Credits Dr',
            'sms_credits' => 'Sms Credits',
            'api_key' => 'Api Key',
            'api_secret' => 'Api Secret',
            'api_token' => 'Api Token',
            'status' => 'Status',
            'parent_id' => 'Parent',
            'reseller_flag' => 'Reseller Flag',
            'cost_per_sms' => 'Cost Per Sms',
            'inserted_at' => 'Inserted At',
            'updated_at' => 'Updated At',
            'status0.status'=>'Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ClientsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientsQuery(get_called_class());
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Status::className(), ['id' => 'status']);
    }
}
