<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property string $email
 * @property string $msisdn
 * @property string $subject
 * @property string $message
 * @property int $status
 * @property int $client_id
 * @property int $processed
 * @property string $inserted_at
 * @property string $updated_at
 */
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
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
            [['message'], 'string'],
            [['status', 'client_id', 'processed'], 'integer'],
            [['inserted_at', 'updated_at'], 'safe'],
            [['email', 'subject'], 'string', 'max' => 255],
            [['msisdn'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'msisdn' => 'Msisdn',
            'subject' => 'Subject',
            'message' => 'Message',
            'status' => 'Status',
            'client_id' => 'Client',
            'processed' => 'Processed',
            'inserted_at' => 'Inserted At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return NotificationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationsQuery(get_called_class());
    }
}
