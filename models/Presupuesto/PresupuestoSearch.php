<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\presupuesto;

/**
 * PresupuestoSearch represents the model behind the search form about `app\models\Presupuesto\presupuesto`.
 */
class PresupuestoSearch extends presupuesto
{



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['presupuesto_id', 'periodo_id', 'presupuesto_cabecera_id', 'estado', 'actualizado_por', 'creado_por','linea_id_fk'], 'integer'],
            [['presupuesto_planificado_ro','presupuesto_planificado_rooc','presupuesto_plan_ro', 'presupuesto_plan_rooc', 'presupuesto_ejecutado_ro', 'presupuesto_ejecutado_rooc', 'presupuesto_saldo_ro', 'presupuesto_saldo_rooc', 'presupuesto_saldo_anual_ro', 'presupuesto_saldo_anual_rooc', 'presupuesto_compromiso_ro', 'presupuesto_compromiso_rooc', 'presupuesto_devengado_ro', 'presupuesto_devengado_rooc', 'presupuesto_girado_ro', 'presupuesto_girado_rooc', 'presupuesto_pagado_ro', 'presupuesto_pagado_rooc'], 'number'],
            [['actualizado_en', 'creado_en'], 'safe'],
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
        $query = presupuesto::find();//->jo;

        $query->joinWith(['linea']); // Agregado para filtrar

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
            'presupuesto_id' => $this->presupuesto_id,
            'periodo_id' => $this->periodo_id,
            'presupuesto_cabecera.presupuesto_cabecera_id' => $this->presupuesto_cabecera_id,
            'presupuesto_planificado_ro' => $this->presupuesto_planificado_ro,
            'presupuesto_planificado_rooc' => $this->presupuesto_planificado_rooc,
            'presupuesto_plan_ro' => $this->presupuesto_plan_ro,
            'presupuesto_plan_rooc' => $this->presupuesto_plan_rooc,
            'presupuesto_ejecutado_ro' => $this->presupuesto_ejecutado_ro,
            'presupuesto_ejecutado_rooc' => $this->presupuesto_ejecutado_rooc,
            'presupuesto_saldo_ro' => $this->presupuesto_saldo_ro,
            'presupuesto_saldo_rooc' => $this->presupuesto_saldo_rooc,
            'presupuesto_saldo_anual_ro' => $this->presupuesto_saldo_anual_ro,
            'presupuesto_saldo_anual_rooc' => $this->presupuesto_saldo_anual_rooc,
            'estado' => $this->estado,
            'presupuesto_compromiso_ro' => $this->presupuesto_compromiso_ro,
            'presupuesto_compromiso_rooc' => $this->presupuesto_compromiso_rooc,
            'presupuesto_devengado_ro' => $this->presupuesto_devengado_ro,
            'presupuesto_devengado_rooc' => $this->presupuesto_devengado_rooc,
            'presupuesto_girado_ro' => $this->presupuesto_girado_ro,
            'presupuesto_girado_rooc' => $this->presupuesto_girado_rooc,
            'presupuesto_pagado_ro' => $this->presupuesto_pagado_ro,
            'presupuesto_pagado_rooc' => $this->presupuesto_pagado_rooc,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);


        $query->andFilterWhere([
            'linea.linea_id' => $this->linea_id_fk,
        ]);


        return $dataProvider;
    }
}
