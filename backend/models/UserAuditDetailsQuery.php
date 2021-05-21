<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[UserAuditDetails]].
 *
 * @see UserAuditDetails
 */
class UserAuditDetailsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserAuditDetails[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserAuditDetails|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
