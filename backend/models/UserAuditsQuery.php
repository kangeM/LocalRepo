<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[UserAudits]].
 *
 * @see UserAudits
 */
class UserAuditsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserAudits[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserAudits|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
