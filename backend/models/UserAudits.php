<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_audits".
 *
 * @property int $id
 * @property int $user_id
 * @property int $client_id
 * @property int $action_id
 * @property string $comments
 * @property string $table_name
 * @property int $table_key
 * @property int $status
 * @property string $inserted_at
 * @property string $updated_at
 */
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class UserAudits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_audits';
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
            [['user_id', 'client_id', 'action_id', 'table_key', 'status'], 'integer'],
            [['comments'], 'string'],
            [['inserted_at', 'updated_at'], 'safe'],
            [['table_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Actor',
            'client_id' => 'Client',
            'action_id' => 'Action',
            'comments' => 'Comments',
            'table_name' => 'Table Name',
            'table_key' => 'Table Key',
            'status' => 'Status',
            'inserted_at' => 'Inserted At',
            'updated_at' => 'Updated At',
            'user0.names'=>'Actor',
            'status0.status'=>'Status',
            'client.name'=>'Client',
            'action.action'=>'Action',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserAuditsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserAuditsQuery(get_called_class());
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Status::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(Actions::className(), ['id' => 'action_id']);
    }

}
