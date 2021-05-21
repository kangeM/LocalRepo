<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_groups".
 *
 * @property int $id
 * @property int $user_id
 * @property int $group_id
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property string $inserted_at
 * @property string $updated_at
 */
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class UserGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_groups';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'inserted_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id', 'status'], 'required'],
            [['user_id', 'group_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['inserted_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'group_id' => 'Group',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'inserted_at' => 'Inserted At',
            'updated_at' => 'Updated At',
            'user0.names'=>'User',
            'status0.status'=>'Status',
            'group0.group'=>'Group',
            'createdBy.names'=>'Created By',
            'updatedBy.names'=>'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserGroupsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserGroupsQuery(get_called_class());
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

    public function getGroup0()
    {
        return $this->hasOne(Groups::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

}
