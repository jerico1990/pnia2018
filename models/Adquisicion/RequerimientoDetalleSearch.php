<?php

namespace app\models\Adquisicion;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Adquisicion\RequerimientoDetalle;

/**
 * RequerimientoDetalleSearch represents the model behind the search form about `app\models\Adquisicion\RequerimientoDetalle`.
 */
class RequerimientoDetalleSearch extends RequerimientoDetalle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requerimiento_detalle_id', 'requerimiento_id', 'linea_nivel_id', 'cantidad', 'tipo_garantia_id', 'garantia_cantidad', 'forma_entrega', 'anio_fabricacion', 'actualizado_por', 'creado_por'], 'integer'],
            [['descripcion', 'concepto', 'unidad_medida', 'especificacion_tecnica', 'tiempo_entrega', 'lugar_entrega', 'fecha_entrega', 'forma_pago', 'resumen_especificacion_tecnica', 'otras_caractaristicas', 'lugar_fabricacion', 'staff_area_id', 'actualizado_en', 'creado_en'], 'safe'],
            [['costo_unitario', 'monto_total', 'rooc', 'ro'], 'number'],
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
            'requerimiento_id' => $this->requerimiento_id,
            'linea_nivel_id' => $this->linea_nivel_id,
            'cantidad' => $this->cantidad,
            'costo_unitario' => $this->costo_unitario,
            'monto_total' => $this->monto_total,
            'rooc' => $this->rooc,
            'ro' => $this->ro,
            'tiempo_entrega' => $this->tiempo_entrega,
            'tipo_garantia_id' => $this->tipo_garantia_id,
            'garantia_cantidad' => $this->garantia_cantidad,
            'fecha_entrega' => $this->fecha_entrega,
            'forma_entrega' => $this->forma_entrega,
            'anio_fabricacion' => $this->anio_fabricacion,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'concepto', $this->concepto])
            ->andFilterWhere(['like', 'unidad_medida', $this->unidad_medida])
            ->andFilterWhere(['like', 'especificacion_tecnica', $this->especificacion_tecnica])
            ->andFilterWhere(['like', 'lugar_entrega', $this->lugar_entrega])
            ->andFilterWhere(['like', 'forma_pago', $this->forma_pago])
            ->andFilterWhere(['like', 'resumen_especificacion_tecnica', $this->resumen_especificacion_tecnica])
            ->andFilterWhere(['like', 'otras_caractaristicas', $this->otras_caractaristicas])
            ->andFilterWhere(['like', 'lugar_fabricacion', $this->lugar_fabricacion])
            ->andFilterWhere(['like', 'staff_area_id', $this->staff_area_id]);

        return $dataProvider;
    }


    public function searchContabilidad($params)
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
            'requerimiento_id' => $this->requerimiento_id,
            'linea_nivel_id' => $this->linea_nivel_id,
            'cantidad' => $this->cantidad,
            'costo_unitario' => $this->costo_unitario,
            'monto_total' => $this->monto_total,
            'rooc' => $this->rooc,
            'ro' => $this->ro,
            'tiempo_entrega' => $this->tiempo_entrega,
            'tipo_garantia_id' => $this->tipo_garantia_id,
            'garantia_cantidad' => $this->garantia_cantidad,
            'fecha_entrega' => $this->fecha_entrega,
            'forma_entrega' => $this->forma_entrega,
            'anio_fabricacion' => $this->anio_fabricacion,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'concepto', $this->concepto])
            ->andFilterWhere(['like', 'unidad_medida', $this->unidad_medida])
            ->andFilterWhere(['like', 'especificacion_tecnica', $this->especificacion_tecnica])
            ->andFilterWhere(['like', 'lugar_entrega', $this->lugar_entrega])
            ->andFilterWhere(['like', 'forma_pago', $this->forma_pago])
            ->andFilterWhere(['like', 'resumen_especificacion_tecnica', $this->resumen_especificacion_tecnica])
            ->andFilterWhere(['like', 'otras_caractaristicas', $this->otras_caractaristicas])
            ->andFilterWhere(['like', 'lugar_fabricacion', $this->lugar_fabricacion])
            ->andFilterWhere(['like', 'staff_area_id', $this->staff_area_id])
            ->andFilterWhere(['in', 'situacion_requerimiento_detalle_id', [17,18,19]]);

        return $dataProvider;
    }


}
