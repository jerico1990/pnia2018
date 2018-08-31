<?php

namespace app\models\Viatico;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viatico\FondoFondo;

/**
 * FondoFondoSearch represents the model behind the search form about `app\models\Viatico\FondoFondo`.
 */
class FondoFondoSearch extends FondoFondo
{
    /**
     * @inheritdoc
     */
    public $fondoId;
    public $ReqFlujoDescripcion;
    public function rules()
    {
        return [
            [['fondo_fondo_id', 'responsable_persona_id', 'requerimiento_flujo_id', 'tipo_flujo_metacodigo', 'resolucion_directoral_pnia_documento_id', 'banco_entidad_financiera', 'actualizado_por', 'creado_por'], 'integer'],
            [['motivo', 'fecha_inicio', 'fecha_fin', 'actualizado_en', 'creado_en'], 'safe'],
            [['saldo_anterior_bienes', 'saldo_anterior_servicios', 'saldo_actual_bienes', 'saldo_actual_servicios', 'total_bienes', 'total_servicios', 'total_entregado'], 'number'],
            [['fondoId', 'ReqFlujoDescripcion'], 'safe'],
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
        $query = FondoFondo::find();

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
            //'fondo_fondo_id' => $this->fondo_fondo_id,
            //'responsable_persona_id' => $this->responsable_persona_id,
            'requerimiento_flujo_id' => $this->requerimiento_flujo_id,
            'tipo_flujo_metacodigo' => $this->tipo_flujo_metacodigo,
            'resolucion_directoral_pnia_documento_id' => $this->resolucion_directoral_pnia_documento_id,
            'banco_entidad_financiera' => $this->banco_entidad_financiera,
            'saldo_anterior_bienes' => $this->saldo_anterior_bienes,
            'saldo_anterior_servicios' => $this->saldo_anterior_servicios,
            'saldo_actual_bienes' => $this->saldo_actual_bienes,
            'saldo_actual_servicios' => $this->saldo_actual_servicios,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'total_bienes' => $this->total_bienes,
            'total_servicios' => $this->total_servicios,
            'total_entregado' => $this->total_entregado,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'motivo', $this->motivo]);

        return $dataProvider;
    }

    public function searchViatico($params)
    {
        $id_persona = Yii::$app->user->identity->persona_id;
        
        $query = FondoFondo::find();
        
        
        //comprueba si master esta logeado o no
        if(!$id_persona)
        {
            echo ($id_persona);
            $query->where(['responsable_persona_id' => $id_persona]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            return $dataProvider;
        }

        $query->joinWith(['requerimientoFlujo']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['fondoId'] = [
            'asc' => ['fondo_fondo.fondo_fondo_id' => SORT_ASC],
            'desc' => ['fondo_fondo.fondo_fondo_id' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['ReqFlujoDescripcion'] = [
            'asc' => ['flujo_requerimiento.descripcion' => SORT_ASC],
            'desc' => ['flujo_requerimiento.descripcion' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            //'fondo_fondo_id' => $this->fondo_fondo_id,
            //'responsable_persona_id' => $this->responsable_persona_id,
            'requerimiento_flujo_id' => $this->requerimiento_flujo_id,
            'tipo_flujo_metacodigo' => $this->tipo_flujo_metacodigo,
            'resolucion_directoral_pnia_documento_id' => $this->resolucion_directoral_pnia_documento_id,
            'banco_entidad_financiera' => $this->banco_entidad_financiera,
            'saldo_anterior_bienes' => $this->saldo_anterior_bienes,
            'saldo_anterior_servicios' => $this->saldo_anterior_servicios,
            'saldo_actual_bienes' => $this->saldo_actual_bienes,
            'saldo_actual_servicios' => $this->saldo_actual_servicios,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'total_bienes' => $this->total_bienes,
            'total_servicios' => $this->total_servicios,
            'total_entregado' => $this->total_entregado,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->where(['tipo_flujo_metacodigo' => 23, 'responsable_persona_id' => $id_persona]);
        $query->andFilterWhere(['like', 'motivo', $this->motivo]);
        $query->andFilterWhere(['=', 'fondo_fondo.fondo_fondo_id', $this->fondoId]);
        $query->andFilterWhere(['like', 'flujo_requerimiento.descripcion', $this->ReqFlujoDescripcion]);

        return $dataProvider;
    }

    public function searchCajaChica($params)
    {
        $id_persona = Yii::$app->user->identity->persona_id;
        
        $query = FondoFondo::find();
        
        
        //comprueba si master esta logeado o no
        if(!$id_persona)
        {
            echo ($id_persona);
            $query->where(['responsable_persona_id' => $id_persona]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            return $dataProvider;
        }

        $query->joinWith(['requerimientoFlujo']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['fondoId'] = [
            'asc' => ['fondo_fondo.fondo_fondo_id' => SORT_ASC],
            'desc' => ['fondo_fondo.fondo_fondo_id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['ReqFlujoDescripcion'] = [
            'asc' => ['flujo_requerimiento.descripcion' => SORT_ASC],
            'desc' => ['flujo_requerimiento.descripcion' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            //'fondo_fondo_id' => $this->fondo_fondo_id,
            //'responsable_persona_id' => $this->responsable_persona_id,
            'requerimiento_flujo_id' => $this->requerimiento_flujo_id,
            'tipo_flujo_metacodigo' => $this->tipo_flujo_metacodigo,
            'resolucion_directoral_pnia_documento_id' => $this->resolucion_directoral_pnia_documento_id,
            'banco_entidad_financiera' => $this->banco_entidad_financiera,
            'saldo_anterior_bienes' => $this->saldo_anterior_bienes,
            'saldo_anterior_servicios' => $this->saldo_anterior_servicios,
            'saldo_actual_bienes' => $this->saldo_actual_bienes,
            'saldo_actual_servicios' => $this->saldo_actual_servicios,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'total_bienes' => $this->total_bienes,
            'total_servicios' => $this->total_servicios,
            'total_entregado' => $this->total_entregado,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->where(['tipo_flujo_metacodigo' => 25, 'responsable_persona_id' => $id_persona]);
        $query->andFilterWhere(['like', 'motivo', $this->motivo]);
        $query->andFilterWhere(['=', 'fondo_fondo.fondo_fondo_id', $this->fondoId]);
        $query->andFilterWhere(['like', 'flujo_requerimiento.descripcion', $this->ReqFlujoDescripcion]);

        return $dataProvider;
    }
    public function searchEntrega($params)
    {
        $id_persona = Yii::$app->user->identity->persona_id;
        
        $query = FondoFondo::find();
        
        
        //comprueba si master esta logeado o no
        if(!$id_persona)
        {
            echo ($id_persona);
            $query->where(['responsable_persona_id' => $id_persona]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            return $dataProvider;
        }

        $query->joinWith(['requerimientoFlujo']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['fondoId'] = [
            'asc' => ['fondo_fondo.fondo_fondo_id' => SORT_ASC],
            'desc' => ['fondo_fondo.fondo_fondo_id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['ReqFlujoDescripcion'] = [
            'asc' => ['flujo_requerimiento.descripcion' => SORT_ASC],
            'desc' => ['flujo_requerimiento.descripcion' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            //'fondo_fondo_id' => $this->fondo_fondo_id,
            //'responsable_persona_id' => $this->responsable_persona_id,
            'requerimiento_flujo_id' => $this->requerimiento_flujo_id,
            'tipo_flujo_metacodigo' => $this->tipo_flujo_metacodigo,
            'resolucion_directoral_pnia_documento_id' => $this->resolucion_directoral_pnia_documento_id,
            'banco_entidad_financiera' => $this->banco_entidad_financiera,
            'saldo_anterior_bienes' => $this->saldo_anterior_bienes,
            'saldo_anterior_servicios' => $this->saldo_anterior_servicios,
            'saldo_actual_bienes' => $this->saldo_actual_bienes,
            'saldo_actual_servicios' => $this->saldo_actual_servicios,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'total_bienes' => $this->total_bienes,
            'total_servicios' => $this->total_servicios,
            'total_entregado' => $this->total_entregado,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->where(['tipo_flujo_metacodigo' => 26, 'responsable_persona_id' => $id_persona]);
        $query->andFilterWhere(['like', 'motivo', $this->motivo]);
        $query->andFilterWhere(['=', 'fondo_fondo.fondo_fondo_id', $this->fondoId]);
        $query->andFilterWhere(['like', 'flujo_requerimiento.descripcion', $this->ReqFlujoDescripcion]);

        return $dataProvider;
    }
    public function searchDesembolso($params)
    {
        $id_persona = Yii::$app->user->identity->persona_id;
        
        $query = FondoFondo::find();
        
        
        //comprueba si master esta logeado o no
        if(!$id_persona)
        {
            echo ($id_persona);
            $query->where(['responsable_persona_id' => $id_persona]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            return $dataProvider;
        }

        $query->joinWith(['requerimientoFlujo']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->sort->attributes['fondoId'] = [
            'asc' => ['fondo_fondo.fondo_fondo_id' => SORT_ASC],
            'desc' => ['fondo_fondo.fondo_fondo_id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['ReqFlujoDescripcion'] = [
            'asc' => ['flujo_requerimiento.descripcion' => SORT_ASC],
            'desc' => ['flujo_requerimiento.descripcion' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            //'fondo_fondo_id' => $this->fondo_fondo_id,
            //'responsable_persona_id' => $this->responsable_persona_id,
            'requerimiento_flujo_id' => $this->requerimiento_flujo_id,
            'tipo_flujo_metacodigo' => $this->tipo_flujo_metacodigo,
            'resolucion_directoral_pnia_documento_id' => $this->resolucion_directoral_pnia_documento_id,
            'banco_entidad_financiera' => $this->banco_entidad_financiera,
            'saldo_anterior_bienes' => $this->saldo_anterior_bienes,
            'saldo_anterior_servicios' => $this->saldo_anterior_servicios,
            'saldo_actual_bienes' => $this->saldo_actual_bienes,
            'saldo_actual_servicios' => $this->saldo_actual_servicios,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'total_bienes' => $this->total_bienes,
            'total_servicios' => $this->total_servicios,
            'total_entregado' => $this->total_entregado,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->where(['tipo_flujo_metacodigo' => 27, 'responsable_persona_id' => $id_persona]);
        $query->andFilterWhere(['like', 'motivo', $this->motivo]);
        $query->andFilterWhere(['=', 'fondo_fondo.fondo_fondo_id', $this->fondoId]);
        $query->andFilterWhere(['like', 'flujo_requerimiento.descripcion', $this->ReqFlujoDescripcion]);

        return $dataProvider;
    }
}
