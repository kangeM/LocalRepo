<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserAuditDetails;
use backend\libraries\RBAC;

/**
 * UserAuditDetailsSearch represents the model behind the search form of `backend\models\UserAuditDetails`.
 */
class UserAuditDetailsSearch extends UserAuditDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_audit_id'], 'integer'],
            [['old_value', 'new_value', 'field', 'inserted_at'], 'safe'],
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
    public function search($params,$user_audit_id = NULL)
    {
        $query = UserAuditDetails::find();
        
        /*
        Boilerplate
        if(Yii::$app->user->identity->client_id != RBAC::super_client)//If client not equal to super
        {
            $query = User::find()->where(['client_id'=>Yii::$app->user->identity->client_id]);
        }else{
            $query = User::find();

        }
        */

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

        if($user_audit_id!=NULL)
        {
            $this->user_audit_id = $user_audit_id;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_audit_id' => $this->user_audit_id,
            'inserted_at' => $this->inserted_at,
        ]);

        $query->andFilterWhere(['like', 'old_value', $this->old_value])
            ->andFilterWhere(['like', 'new_value', $this->new_value])
            ->andFilterWhere(['like', 'field', $this->field]);

        return $dataProvider;
    }
}
