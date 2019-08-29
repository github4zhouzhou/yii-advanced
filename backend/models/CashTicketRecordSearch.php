<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CashTicketRecord;

/**
 * CashTicketRecordSearch represents the model behind the search form of `\common\models\CashTicketRecord`.
 */
class CashTicketRecordSearch extends CashTicketRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mid', 'status', 'event_id', 'expired_day', 'valid_day', 'ticket_level', 'refer_id', 'exchange_type', 'exchange_time', 'used_day', 'used_time', 'expired_time', 'created_at', 'updated_at'], 'integer'],
            [['name', 'color', 'description', 'remark', 'message'], 'safe'],
            [['money', 'real_money'], 'number'],
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
        $query = CashTicketRecord::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		$dataProvider->setSort([
			'defaultOrder' => ['id' => SORT_DESC],
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
            'mid' => $this->mid,
            'status' => $this->status,
            'event_id' => $this->event_id,
            'expired_day' => $this->expired_day,
            'valid_day' => $this->valid_day,
            'money' => $this->money,
            'ticket_level' => $this->ticket_level,
            'real_money' => $this->real_money,
            'refer_id' => $this->refer_id,
            'exchange_type' => $this->exchange_type,
            'exchange_time' => $this->exchange_time,
            'used_day' => $this->used_day,
            'used_time' => $this->used_time,
            'expired_time' => $this->expired_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
