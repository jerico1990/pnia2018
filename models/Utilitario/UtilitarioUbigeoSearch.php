<?php

namespace app\models\Utilitario;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Utilitario\UtilitarioUbigeo;

/**
 * UtilitarioUbigeoSearch represents the model behind the search form about `app\models\Utilitario\UtilitarioUbigeo`.
 */
class UtilitarioUbigeoSearch extends UtilitarioUbigeo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['utilitario_ubigeo_id', 'nombre', 'ubigeo_region_id', 'ubigeo_provincia_id', 'actualizado_en', 'creado_en'], 'safe'],
            [['creado_por', 'actualizado_por'], 'integer'],
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
        $query = UtilitarioUbigeo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'actualizado_en' => $this->actualizado_en,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
            'actualizado_por' => $this->actualizado_por,
        ]);

        $query->andFilterWhere(['like', 'utilitario_ubigeo_id', $this->utilitario_ubigeo_id])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'ubigeo_region_id', $this->ubigeo_region_id])
            ->andFilterWhere(['like', 'ubigeo_provincia_id', $this->ubigeo_provincia_id]);

        return $dataProvider;
    }
}
