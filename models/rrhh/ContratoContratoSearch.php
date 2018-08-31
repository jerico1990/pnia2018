<?php

namespace app\models\rrhh;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rrhh\ContratoContrato;

use app\models\Auditoria\Usuario;
use yii\helpers\ArrayHelper;

/**
 * ContratoContratoSearch represents the model behind the search form about `app\models\rrhh\ContratoContrato`.
 */
class ContratoContratoSearch extends ContratoContrato
{
    public $pniaEntidadRazonSocial;
    public $staffAreaContratanteDescripcion;
    public $staffAreaResponsableDescripcion;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contrato_contrato_id', 'entidad_contratista', 'area_contratante', 'area_responsable', 'contrato_origen', 'actualizado_por', 'creado_por'], 'integer'],
            [['codigo_interno', 'fecha_inicio', 'fecha_fin', 'objetivos', 'flg_es_staff', 'actualizado_en', 'creado_en'], 'safe'],
            [['pniaEntidadRazonSocial','staffAreaContratanteDescripcion','staffAreaResponsableDescripcion'],'safe'],
            [['monto'],'number']
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
        $id_persona = Yii::$app->user->identity->persona_id;
        $model_area = new StaffArea();
        $responsable = $model_area->findByResponsable($id_persona);
        
        $query = ContratoContrato::find();
        
        if($id_persona)
        {
            $responsable_array = ArrayHelper::toArray($responsable);
            $id_del_area_que_es_responsable = $responsable_array['staff_area_id'];
            $codigo_del_area_que_es_responsable = $responsable_array['codigo'];


            $query->joinWith(['entidadContratista', 'areaContratante', 'areaResponsable'])
                    ->andFilterWhere(
                            ['or',
                                ['=','areaResponsable.responsable', $id_persona],
                                //['=','areaResponsable.area_superior', $id_del_area_que_es_responsable],
                                //['like', 'areaResponsable.codigo', '5']
                            ]
                            
                            );    
        }
        
        $query->joinWith(['entidadContratista', 'areaContratante', 'areaResponsable']);
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['pniaEntidadRazonSocial'] = [
            'asc' => ['pnia_entidad.razon_social' => SORT_ASC],
            'desc' => ['pnia_entidad.razon_social' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['staffAreaContratanteDescripcion'] = [
            'asc' => ['areaContratante.descripcion' => SORT_ASC],
            'desc' => ['areaContratante.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['staffAreaResponsableDescripcion'] = [
            'asc' => ['areaResponsable.descripcion' => SORT_ASC],
            'desc' => ['areaResponsable.descripcion' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'contrato_contrato_id' => $this->contrato_contrato_id,
            'entidad_contratista' => $this->entidad_contratista,
            'area_contratante' => $this->area_contratante,
            'area_responsable' => $this->area_responsable,
            //'monto' => $this->monto,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'contrato_origen' => $this->contrato_origen,
            //'documento_pnia_id' => $this->documento_pnia_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->where(['flg_es_staff' => 'no']);
        $query->andFilterWhere(['=', 'monto', $this->monto]);

        $query->andFilterWhere(['like', 'codigo_interno', $this->codigo_interno])
            ->andFilterWhere(['like', 'objetivos', $this->objetivos]);
            //->andFilterWhere(['like', 'flg_es_staff', $this->flg_es_staff])

        $query->andFilterWhere(['like', 'pnia_entidad.razon_social', $this->pniaEntidadRazonSocial]);
        $query->andFilterWhere(['like', 'areaContratante.descripcion', $this->staffAreaContratanteDescripcion]);
        $query->andFilterWhere(['like', 'areaResponsable.descripcion', $this->staffAreaResponsableDescripcion]);

        return $dataProvider;
    }

    public function searchContratoContratoRrhh($params)
    {
        $id_persona = Yii::$app->user->identity->persona_id;
        $model_area = new StaffArea();
        $responsable = $model_area->findByResponsable($id_persona);
        
        $query = ContratoContrato::find();
        
        if($id_persona)
        {
            $responsable_array = ArrayHelper::toArray($responsable);
            $id_del_area_que_es_responsable = $responsable_array['staff_area_id'];
            $codigo_del_area_que_es_responsable = $responsable_array['codigo'];


            $query->joinWith(['entidadContratista', 'areaContratante', 'areaResponsable'])
                    ->andFilterWhere(
                            ['or',
                                ['=','areaResponsable.responsable', $id_persona],
                                //['=','areaResponsable.area_superior', $id_del_area_que_es_responsable],
                                //['like', 'areaResponsable.codigo', '5']
                            ]
                            
                            );    
        }
        
        $query->joinWith(['entidadContratista', 'areaContratante', 'areaResponsable']);
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['pniaEntidadRazonSocial'] = [
            'asc' => ['pnia_entidad.razon_social' => SORT_ASC],
            'desc' => ['pnia_entidad.razon_social' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['staffAreaContratanteDescripcion'] = [
            'asc' => ['areaContratante.descripcion' => SORT_ASC],
            'desc' => ['areaContratante.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['staffAreaResponsableDescripcion'] = [
            'asc' => ['areaResponsable.descripcion' => SORT_ASC],
            'desc' => ['areaResponsable.descripcion' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'contrato_contrato_id' => $this->contrato_contrato_id,
            'entidad_contratista' => $this->entidad_contratista,
            'area_contratante' => $this->area_contratante,
            'area_responsable' => $this->area_responsable,
            //'monto' => $this->monto,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'contrato_origen' => $this->contrato_origen,
            //'documento_pnia_id' => $this->documento_pnia_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->where(['flg_es_staff' => 'si']);
        $query->andFilterWhere(['=', 'monto', $this->monto]);

        $query->andFilterWhere(['like', 'codigo_interno', $this->codigo_interno])
            ->andFilterWhere(['like', 'objetivos', $this->objetivos]);
            //->andFilterWhere(['like', 'flg_es_staff', $this->flg_es_staff])

        $query->andFilterWhere(['like', 'pnia_entidad.razon_social', $this->pniaEntidadRazonSocial]);
        $query->andFilterWhere(['like', 'areaContratante.descripcion', $this->staffAreaContratanteDescripcion]);
        $query->andFilterWhere(['like', 'areaResponsable.descripcion', $this->staffAreaResponsableDescripcion]);

        return $dataProvider;
    }
}
