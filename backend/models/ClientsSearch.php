<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Clients;
use backend\libraries\RBAC;

/**
 * ClientsSearch represents the model behind the search form of `backend\models\Clients`.
 */
class ClientsSearch extends Clients
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sms_credits_cr', 'sms_credits_dr', 'sms_credits', 'status'], 'integer'],
            [['name', 'email', 'phone', 'address', 'api_key', 'api_secret', 'api_token', 'inserted_at', 'updated_at'], 'safe'],
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
            $query = Clients::find()->where('id='.Yii::$app->user->identity->client_id.'OR id IN (SELECT id FROM clients where parent_id='.Yii::$app->user->identity->client_id);
        }else{
            $query = Clients::find();

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
            'sms_credits_cr' => $this->sms_credits_cr,
            'sms_credits_dr' => $this->sms_credits_dr,
            'sms_credits' => $this->sms_credits,
            'status' => $this->status,
            'inserted_at' => $this->inserted_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'api_key', $this->api_key])
            ->andFilterWhere(['like', 'api_secret', $this->api_secret])
            ->andFilterWhere(['like', 'api_token', $this->api_token]);

        return $dataProvider;
    }
}
