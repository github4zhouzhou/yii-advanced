<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CashTicket;

/**
 * CashTicketSearch represents the model behind the search form of `\common\models\CashTicket`.
 */
class CashTicketSearch extends CashTicket
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'event_id', 'status', 'ticket_type', 'ticket_level', 'expired_accept', 'dispatch_type', 'created_at', 'updated_at'], 'integer'],
            [['valid_month', 'accept_period', 'color', 'title', 'description', 'dispatch_value', 'extra_data'], 'safe'],
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
        $query = CashTicket::find();

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
            'event_id' => $this->event_id,
            'status' => $this->status,
            'ticket_type' => $this->ticket_type,
            'ticket_level' => $this->ticket_level,
            'expired_accept' => $this->expired_accept,
            'dispatch_type' => $this->dispatch_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'valid_month', $this->valid_month])
            ->andFilterWhere(['like', 'accept_period', $this->accept_period])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'dispatch_value', $this->dispatch_value])
            ->andFilterWhere(['like', 'extra_data', $this->extra_data]);

        return $dataProvider;
    }
}
