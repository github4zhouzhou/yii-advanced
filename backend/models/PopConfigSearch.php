<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PopConfig;

/**
 * PopConfigSearch represents the model behind the search form of `\common\models\PopConfig`.
 */
class PopConfigSearch extends PopConfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'publish_time', 'expired_time', 'sort', 'scene', 'pop_type', 'pop_times', 'pop_interval', 'after_click', 'after_close', 'created_at', 'updated_at'], 'integer'],
            [['title', 'lang', 'app_name', 'app_id', 'img', 'redirect', 'desc'], 'safe'],
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
        $query = PopConfig::find();

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
            'active' => $this->active,
            'publish_time' => $this->publish_time,
            'expired_time' => $this->expired_time,
            'sort' => $this->sort,
            'scene' => $this->scene,
            'pop_type' => $this->pop_type,
            'pop_times' => $this->pop_times,
            'pop_interval' => $this->pop_interval,
            'after_click' => $this->after_click,
            'after_close' => $this->after_close,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'app_name', $this->app_name])
            ->andFilterWhere(['like', 'app_id', $this->app_id])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'redirect', $this->redirect])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
