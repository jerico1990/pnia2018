<?php

namespace app\models\General;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\General\RequerimientoDetalle;

/**
 * RequerimientoDetalleSearch represents the model behind the search form about `app\models\General\RequerimientoDetalle`.
 */
class RequerimientoDetalleSearch extends RequerimientoDetalle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requerimiento_detalle_id', 'codigo_arbol', 'periodo_id', 'ro_rooc', 'entregable_id', 'penalidad_id', 'flujo_requerimiento_id', 'cantidad', 'costo_unitario', 'staff_area_id', 'tiempo_garantia_numero_meses', 'forma_pago', 'duracion_servicio', 'staff_persona_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['monto', 'monto_total_contrato_fake'], 'number'],
            [['unidad_medida_cantidad', 'bien_servicio', 'descripcion_bien_servicio', 'especificacion_tecnica_o_tdr', 'lugar_entrega', 'actualizado_en', 'creado_en'], 'safe'],
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
        $query = RequerimientoDetalle::find();

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
            'requerimiento_detalle_id' => $this->requerimiento_detalle_id,
            'codigo_arbol' => $this->codigo_arbol,
            'periodo_id' => $this->periodo_id,
            'monto' => $this->monto,
            'ro_rooc' => $this->ro_rooc,
            'entregable_id' => $this->entregable_id,
            'penalidad_id' => $this->penalidad_id,
            'flujo_requerimiento_id' => $this->flujo_requerimiento_id,
            'cantidad' => $this->cantidad,
            'costo_unitario' => $this->costo_unitario,
            'staff_area_id' => $this->staff_area_id,
            'tiempo_garantia_numero_meses' => $this->tiempo_garantia_numero_meses,
            'forma_pago' => $this->forma_pago,
            'duracion_servicio' => $this->duracion_servicio,
            'monto_total_contrato_fake' => $this->monto_total_contrato_fake,
            'staff_persona_id' => $this->staff_persona_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'unidad_medida_cantidad', $this->unidad_medida_cantidad])
            ->andFilterWhere(['like', 'bien_servicio', $this->bien_servicio])
            ->andFilterWhere(['like', 'descripcion_bien_servicio', $this->descripcion_bien_servicio])
            ->andFilterWhere(['like', 'especificacion_tecnica_o_tdr', $this->especificacion_tecnica_o_tdr])
            ->andFilterWhere(['like', 'lugar_entrega', $this->lugar_entrega]);

        return $dataProvider;
    }
}
