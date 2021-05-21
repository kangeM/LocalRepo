<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserGroups;
use backend\libraries\RBAC;

/**
 * UserGroupsSearch represents the model behind the search form of `backend\models\UserGroups`.
 */
class UserGroupsSearch extends UserGroups
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'group_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['inserted_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$user_id = NULL)
    {
        if(Yii::$app->user->identity->client_id != RBAC::super_client)//If client not equal to super
        {
            $query = UserGroups::find()->where('user_id IN (SELECT id FROM user where client_id='.Yii::$app->user->identity->client_id.')');
        }else{
            $query = UserGroups::find();

        }

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($user_id!=NULL)
        {
            $this->user_id = $user_id;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'group_id' => $this->group_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'inserted_at' => $this->inserted_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
