<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\LineaNivel;

/**
 * LineaNivelSearch represents the model behind the search form about `app\models\Presupuesto\LineaNivel`.
 */
class LineaNivelSearch extends LineaNivel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['linea_nivel_id', 'nivel', 'actualizado_por', 'creado_por'], 'integer'],
            [['nombre_linea', 'actualizado_en', 'creado_en'], 'safe'],
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
        $query = LineaNivel::find();

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
            'linea_nivel_id' => $this->linea_nivel_id,
            'nivel' => $this->nivel,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'nombre_linea', $this->nombre_linea]);

        return $dataProvider;
    }
}
