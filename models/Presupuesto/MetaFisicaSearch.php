<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\MetaFisica;

/**
 * MetaFisicaSearch represents the model behind the search form about `app\models\Presupuesto\MetaFisica`.
 */
class MetaFisicaSearch extends MetaFisica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meta_fisica_id', 'unidad_medida_id', 'presupuesto_cabecera_id', 'estado_regitro', 'actualizado_por', 'creado_por'], 'integer'],
            [['descripcion', 'actualizado_en', 'creado_en'], 'safe'],
            [['avance_total', 'avance_actual'], 'number'],
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
        $query = MetaFisica::find();

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
            'meta_fisica_id' => $this->meta_fisica_id,
            'avance_total' => $this->avance_total,
            'avance_actual' => $this->avance_actual,
            'unidad_medida_id' => $this->unidad_medida_id,
            'presupuesto_cabecera_id' => $this->presupuesto_cabecera_id,
            'estado_regitro' => $this->estado_regitro,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
