<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserAudits;
use backend\libraries\RBAC;

/**
 * UserAuditsSearch represents the model behind the search form of `backend\models\UserAudits`.
 */
class UserAuditsSearch extends UserAudits
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'client_id', 'action_id', 'table_key', 'status'], 'integer'],
            [['comments', 'table_name', 'inserted_at', 'updated_at'], 'safe'],
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
    public function search($params)
    {
        
        if(Yii::$app->user->identity->client_id != RBAC::super_client)//If client not equal to super
        {
            $query = UserAudits::find()->where('client_id='.Yii::$app->user->identity->client_id.' or client_id IN (SELECT id FROM clients where parent_id='.Yii::$app->user->identity->client_id.')');
        }else{
            $query = UserAudits::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'client_id' => $this->client_id,
            'action_id' => $this->action_id,
            'table_key' => $this->table_key,
            'status' => $this->status,
            'inserted_at' => $this->inserted_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['like', 'table_name', $this->table_name]);

        return $dataProvider;
    }
}
