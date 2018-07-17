<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ImagesManager;

/**
 * ImagesManagerSearch represents the model behind the search form of `common\models\ImagesManager`.
 */
class ImagesManagerSearch extends ImagesManager
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'create_time', 'update_time', 'publish_time', 'is_real', 'parent_id', 'sub_id', 'img_type', 'valid_time', 'stay', 'sort', 'platform', 'is_rule'], 'integer'],
            [['title', 'lang', 'app_name', 'app_id', 'img', 'desc', 'url', 'redirect', 'rule'], 'safe'],
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
        $query = ImagesManager::find();

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
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'publish_time' => $this->publish_time,
            'is_real' => $this->is_real,
            'parent_id' => $this->parent_id,
            'sub_id' => $this->sub_id,
            'img_type' => $this->img_type,
            'valid_time' => $this->valid_time,
            'stay' => $this->stay,
            'sort' => $this->sort,
            'platform' => $this->platform,
            'is_rule' => $this->is_rule,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'app_name', $this->app_name])
            ->andFilterWhere(['like', 'app_id', $this->app_id])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'redirect', $this->redirect])
            ->andFilterWhere(['like', 'rule', $this->rule]);

        return $dataProvider;
    }
}
