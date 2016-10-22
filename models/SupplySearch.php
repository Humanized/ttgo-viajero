<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Supply;

/**
 * SupplySearch represents the model behind the search form of `app\models\Supply`.
 */
class SupplySearch extends Supply
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'has_wifi', 'has_kitchen', 'has_shower'], 'integer'],
            [['description_public', 'description_private'], 'safe'],
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
        $query = Supply::find();

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
            'user_id' => $this->user_id,
            'has_wifi' => $this->has_wifi,
            'has_kitchen' => $this->has_kitchen,
            'has_shower' => $this->has_shower,
        ]);

        $query->andFilterWhere(['like', 'description_public', $this->description_public])
            ->andFilterWhere(['like', 'description_private', $this->description_private]);

        return $dataProvider;
    }
}
