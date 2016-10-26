<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Request;
use yii\db\Expression;

/**
 * RequestSearch represents the model behind the search form of `app\models\Request`.
 */
class RequestSearch extends Request
{

    const INBOX = 0;
    const OUTBOX = 1;

    public $mode = self::INBOX;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'is_new', 'status'], 'integer'],
            [['request_message', 'response_message'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [

            'user_id' => Yii::t('app', $this->mode == self::INBOX ? 'Received By' : 'Sent To'),
        ]);
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
        $query = Request::find();

        $defaultOrder = [];

        if ($this->mode == self::INBOX) {

            $defaultOrder['is_new'] = SORT_DESC;
            $query->joinWith('accommodationRequests');
            $subquery = Supply::find()->select('accommodation.id as id')->joinWith('accommodations')->where(['user_id' => Yii::$app->user->id]);
            $query->andFilterWhere(['IN', 'accommodation_id', $subquery]);
        }

        if ($this->mode == self::OUTBOX) {

            //    $query->andFilterWhere(['not', ['response_date' => null]]);
            $query->andFilterWhere([
                'user_id' => Yii::$app->user->id]);
        }
        $defaultOrder['request_date'] = SORT_ASC;
  
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => $defaultOrder]
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
            'is_new' => $this->is_new,
                //       'is_responded' => $this->is_responded,
        ]);

        $query->andFilterWhere(['like', 'request_message', $this->request_message])
                ->andFilterWhere(['like', 'response_message', $this->response_message]);

        return $dataProvider;
    }

}
