<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "permissions".
 *
 * @property int $id
 * @property int $group_id
 * @property int $action_id
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property string $inserted_at
 * @property string $updated_at
 */
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Permissions extends \yii\db\ActiveRecord
{
    public $actions;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permissions';
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
            [['group_id', 'action_id', 'status'], 'required'],
            [['group_id', 'action_id', 'status', 'created_by', 'updated_by'], 'integer'],
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
            'group_id' => 'Group',
            'action_id' => 'Action',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'inserted_at' => 'Inserted At',
            'updated_at' => 'Updated At',
            'action0.action'=>'Action',
            'status0.status'=>'Status',
            'group0.group'=>'Group',
            'createdBy.names'=>'Created By',
            'updatedBy.names'=>'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PermissionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PermissionsQuery(get_called_class());
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
    public function getAction0()
    {
        return $this->hasOne(Actions::className(), ['id' => 'action_id']);
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
