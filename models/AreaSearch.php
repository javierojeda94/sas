<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Area;

/**
 * AreaSearch represents the model behind the search form about `app\models\Area`.
 */
class AreaSearch extends Area{

    public $responsable_name;
    public $father_area;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'area_id', 'id_responsable'], 'integer'],
            [['name', 'description', 'responsable_name', 'father_area'], 'safe'],
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
        $query = Area::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['idResponsable']);

        $dataProvider->sort->attributes['responsable_name'] = [
            'asc' => ['users.first_name' => SORT_ASC],
            'desc' => ['users.first_name' => SORT_DESC],
        ];

        /*
        $dataProvider->sort->attributes['father_area'] = [
            'asc' => ['areas.name' => SORT_ASC],
            'desc' => ['areas.name' => SORT_DESC],
        ];*/

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'area_id' => $this->area_id,
            'id_responsable' => $this->id_responsable,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
             ->andFilterWhere(['like', 'Users.first_name', $this->responsable_name]);


        return $dataProvider;
    }
}
