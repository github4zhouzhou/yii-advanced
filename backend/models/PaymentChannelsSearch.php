<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PaymentChannels;

/**
 * PaymentChannelsSearch represents the model behind the search form of `backend\models\PaymentChannels`.
 */
class PaymentChannelsSearch extends PaymentChannels
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'max_amount', 'min_amount', 'show_limit', 'status', 'sort', 'created_at', 'updated_at', 'open_mode', 'need_proof'], 'integer'],
            [['channel', 'channelcode', 'img', 'platform', 'country', 'domain', 'currency', 'which_fee', 'server_label'], 'safe'],
            [['proportion', 'fixed_fee'], 'number'],
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
        $query = PaymentChannels::find();

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
            'max_amount' => $this->max_amount,
            'min_amount' => $this->min_amount,
            'show_limit' => $this->show_limit,
            'status' => $this->status,
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'proportion' => $this->proportion,
            'fixed_fee' => $this->fixed_fee,
            'open_mode' => $this->open_mode,
            'need_proof' => $this->need_proof,
        ]);

        $query->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['like', 'channelcode', $this->channelcode])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'which_fee', $this->which_fee])
            ->andFilterWhere(['like', 'server_label', $this->server_label]);

        return $dataProvider;
    }
}
