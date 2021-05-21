<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[UserGroups]].
 *
 * @see UserGroups
 */
class UserGroupsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserGroups[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserGroups|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
