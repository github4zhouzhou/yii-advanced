<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RedPacketRecord;

/**
 * RedPacketRecordSearch represents the model behind the search form of `\common\models\RedPacketRecord`.
 */
class RedPacketRecordSearch extends RedPacketRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'owner_id', 'achieve_condition_type', 'expire_hours', 'relative_line', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'currency', 'achieve_condition_value', 'add_condition'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = RedPacketRecord::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'owner_id' => $this->owner_id,
            'amount' => $this->amount,
            'achieve_condition_type' => $this->achieve_condition_type,
            'expire_hours' => $this->expire_hours,
            'relative_line' => $this->relative_line,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'achieve_condition_value', $this->achieve_condition_value])
            ->andFilterWhere(['like', 'add_condition', $this->add_condition]);

        return $dataProvider;
    }
}
