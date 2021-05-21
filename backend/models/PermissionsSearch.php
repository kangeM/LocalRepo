<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Permissions;
use backend\libraries\RBAC;

/**
 * PermissionsSearch represents the model behind the search form of `backend\models\Permissions`.
 */
class PermissionsSearch extends Permissions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'action_id', 'status', 'created_by', 'updated_by'], 'integer'],
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

            if($user_id != NULL)
            {
                $query = Permissions::find()->where('group_id IN(SELECT group_id FROM user_groups WHERE user_id='.$user_id.' )');
            }else{
                $query = Permissions::find()->where('group_id IN(SELECT group_id FROM user_groups WHERE group_id IN(SELECT id FROM groups WHERE client_id='.Yii::$app->user->identity->client_id.') )');

            }

        }else{

            if($user_id != NULL)
            {
                $query = Permissions::find()->where('group_id IN(SELECT group_id FROM user_groups WHERE user_id='.$user_id.' )');
            }else{
                $query = Permissions::find();

            }

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
            'group_id' => $this->group_id,
            'action_id' => $this->action_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'inserted_at' => $this->inserted_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
