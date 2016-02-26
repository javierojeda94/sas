<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Request;
use app\models\Area;

/**
 * RequestSearch represents the model behind the search form about `app\models\request`.
 */
class RequestSearch extends request
{
    public $area_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'area_id', 'user_id'], 'integer'],
            [['name', 'email', 'subject', 'description', 'creation_date', 'completion_date', 'status',
                'scheduled_start_date', 'scheduled_end_date', 'token','area_name'], 'safe'],
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
        $query = request::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['area']);

        $dataProvider->sort->attributes['area_name'] = [
            'asc' => ['areas.name' => SORT_ASC],
            'desc' => ['areas.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'area_id' => $this->area_id,
            'creation_date' => $this->creation_date,
            'completion_date' => $this->completion_date,

        ]);

        $query->andFilterWhere(['like', 'request.name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'request.description', $this->description])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'areas.name', $this->area_name]);

        return $dataProvider;
    }
}
