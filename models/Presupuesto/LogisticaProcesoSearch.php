<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\LogisticaProceso;

/**
 * LogisticaProcesoSearch represents the model behind the search form about `app\models\Presupuesto\LogisticaProceso`.
 */
class LogisticaProcesoSearch extends LogisticaProceso
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['logistica_proceso_id', 'proyecto_id', 'componente_id', 'categoria', 'tipo', 'estado', 'documento_pnia_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['nombre', 'codigo', 'tdr_plan', 'tdr_real', 'expresion_plan', 'expresion_real', 'evaluacion_plan', 'evaluacion_real', 'notificacion_plan', 'notificacion_real', 'firma_plan', 'firma_real', 'adenda_plan', 'adenda_real', 'termino_plan', 'termino_real', 'actualizado_en', 'creado_en'], 'safe'],
            [['monto_rooc_bm', 'monto_rooc_bid', 'monto_ro', 'monto_total'], 'number'],
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
        $query = LogisticaProceso::find();

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
            'logistica_proceso_id' => $this->logistica_proceso_id,
            'proyecto_id' => $this->proyecto_id,
            'componente_id' => $this->componente_id,
            'monto_rooc_bm' => $this->monto_rooc_bm,
            'monto_rooc_bid' => $this->monto_rooc_bid,
            'monto_ro' => $this->monto_ro,
            'monto_total' => $this->monto_total,
            'categoria' => $this->categoria,
            'tipo' => $this->tipo,
            'tdr_plan' => $this->tdr_plan,
            'tdr_real' => $this->tdr_real,
            'expresion_plan' => $this->expresion_plan,
            'expresion_real' => $this->expresion_real,
            'evaluacion_plan' => $this->evaluacion_plan,
            'evaluacion_real' => $this->evaluacion_real,
            'notificacion_plan' => $this->notificacion_plan,
            'notificacion_real' => $this->notificacion_real,
            'firma_plan' => $this->firma_plan,
            'firma_real' => $this->firma_real,
            'adenda_plan' => $this->adenda_plan,
            'adenda_real' => $this->adenda_real,
            'termino_plan' => $this->termino_plan,
            'termino_real' => $this->termino_real,
            'estado' => $this->estado,
            'documento_pnia_id' => $this->documento_pnia_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'codigo', $this->codigo]);

        return $dataProvider;
    }
}
