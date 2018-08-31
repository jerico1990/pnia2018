<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\Meta;

/**
 * MetaSearch represents the model behind the search form about `app\models\Presupuesto\Meta`.
 */
class MetaSearch extends Meta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meta_id', 'unidad_medida_id', 'estado_regitro', 'actualizado_por', 'creado_por'], 'integer'],
            [['meta_descripcion', 'actualizado_en', 'creado_en'], 'safe'],
            [['tipo', 'presupuesto_afectado'], 'boolean'],
            [['avance_total', 'avance_actual', 'precio_unitario', 'monto_total'], 'number'],
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
        $query = Meta::find();

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
            'meta_id' => $this->meta_id,
            'tipo' => $this->tipo,
            'avance_total' => $this->avance_total,
            'avance_actual' => $this->avance_actual,
            'unidad_medida_id' => $this->unidad_medida_id,
            'precio_unitario' => $this->precio_unitario,
            'monto_total' => $this->monto_total,
            'presupuesto_afectado' => $this->presupuesto_afectado,
            'estado_regitro' => $this->estado_regitro,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'meta_descripcion', $this->meta_descripcion]);

        return $dataProvider;
    }
}
