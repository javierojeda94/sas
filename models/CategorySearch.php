<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;

/**
 * CategorySearch represents the model behind the search form about `app\models\Category`.
 */
class CategorySearch extends Category
{
    public $area_name;
    public $category_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'id_area','service_level_agreement_asignment', 'service_level_agreement_completion'], 'integer'],
            [['name', 'description' ,'area_name', 'category_name'], 'safe'],
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

        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->service_level_agreement_asignment){
            $asignment_level = intval($this->service_level_agreement_asignment);
            if($asignment_level <= 0) {
                $asignment_level = 1;
            }
            if($asignment_level > 5) {
                $asignment_level = 5;
            }
            $this->service_level_agreement_asignment = strval($asignment_level);
        }
        if($this->service_level_agreement_completion){
            $completion_level = intval($this->service_level_agreement_completion);
            if($completion_level <= 0){
                $completion_level = 1;
            }
            if($completion_level > 5){
                $completion_level = 5;
            }
            $this->service_level_agreement_completion = strval($completion_level);
        }

        $query->joinWith('idArea');

        $dataProvider->sort->attributes['area_name'] = [
            'asc' => ['Areas.name' => SORT_ASC],
            'desc' => ['Areas.name' => SORT_DESC],
        ];

        /*
        $dataProvider->sort->attributes['category_name'] = [
            'asc' => ['Categories.name' => SORT_ASC],
            'desc' => ['Categories.name' => SORT_DESC],
        ];*/

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'id_area' => $this->id_area,
            'service_level_agreement_asignment' => $this->service_level_agreement_asignment,
            'service_level_agreement_completion' => $this->service_level_agreement_completion,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'areas.name', $this->area_name]);
            //->andFilterWhere(['like', 'categories.name', $this->category_name]);

        return $dataProvider;
    }
}
