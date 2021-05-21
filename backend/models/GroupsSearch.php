<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Groups;
use backend\libraries\RBAC;

/**
 * GroupsSearch represents the model behind the search form of `backend\models\Groups`.
 */
class GroupsSearch extends Groups
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'created_by', 'updated_by'], 'integer'],
            [['group', 'inserted_at', 'updated_at'], 'safe'],
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
            $query = Groups::find()->where('client_id='.Yii::$app->user->identity->client_id.' OR id=2');
        }else{
            $query = Groups::find();

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
            'client_id' => $this->client_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'inserted_at' => $this->inserted_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'group', $this->group]);

        return $dataProvider;
    }
}
