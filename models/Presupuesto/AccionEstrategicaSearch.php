<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\AccionEstrategica;

/**
 * AccionEstrategicaSearch represents the model behind the search form about `app\models\Presupuesto\AccionEstrategica`.
 */
class AccionEstrategicaSearch extends AccionEstrategica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accion_estrategica_id', 'estado_regitro', 'actualizado_por', 'creado_por'], 'integer'],
            [['accion_descripcion', 'actualizado_en', 'creado_en'], 'safe'],
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
        $query = AccionEstrategica::find();

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
            'accion_estrategica_id' => $this->accion_estrategica_id,
            'estado_regitro' => $this->estado_regitro,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'accion_descripcion', $this->accion_descripcion]);

        return $dataProvider;
    }
}
