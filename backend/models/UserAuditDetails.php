<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_audit_details".
 *
 * @property int $id
 * @property int $user_audit_id
 * @property string $old_value
 * @property string $new_value
 * @property string $field
 * @property string $inserted_at
 * @property string $updated_at
 */
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class UserAuditDetails extends \yii\db\ActiveRecord
{
    public $updated_at;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_audit_details';
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
            [['user_audit_id'], 'integer'],
            [['old_value', 'new_value'], 'string'],
            [['inserted_at'], 'safe'],
            [['field'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_audit_id' => 'User Audit ID',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'field' => 'Field',
            'inserted_at' => 'Inserted At',
            'user0.names'=>'User',
            'status0.status'=>'Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserAuditDetailsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserAuditDetailsQuery(get_called_class());
    }

   
}
