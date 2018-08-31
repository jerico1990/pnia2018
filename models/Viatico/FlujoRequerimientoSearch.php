<?php

namespace app\models\Viatico;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viatico\FlujoRequerimiento;
use app\models\Patrimonio\Metacodigo;

/**
 * FlujoRequerimientoSearch represents the model behind the search form about `app\models\Viatico\FlujoRequerimiento`.
 */
class FlujoRequerimientoSearch extends FlujoRequerimiento
{
    /**
     * @inheritdoc
     */
    public $flujoReqDescripcion;
    public $codigoFlujo;
    public $codigoPaso;
    public $fechaEsperada;
    //public $documentoPniaNombreDocumento;

    public function rules()
    {
        return [
            [['flujo_requerimiento_id', 'emisor_persona_id', 'codigo_flujo', 'codigo_paso', 'area_aprobadora_id', 'estado_paso', 'codigo_arbol', 'actualizado_por', 'creado_por'], 'integer'],
            [['descripcion', 'fecha_instanciacion', 'actualizado_en', 'creado_en', 'codigo_requerimiento'], 'safe'],
            [['flujoReqDescripcion', 'codigoFlujo', 'codigoPaso', 'fechaEsperada'], 'safe']
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

        $query = FlujoRequerimiento::find();
        //$query = FlujoRequerimiento::find()->select(['flujo_requerimiento.descripcion', 
               // 'flujo_requerimiento.codigo_flujo', 'flujo_requerimiento.codigo_paso', 'flujo_requerimiento.fecha_esperada'])->distinct();
        $metacodigo_model_adquisicion = Metacodigo::find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Adquisición'])->one();
        $metacodigo_model_documentario = Metacodigo::find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Trámite Documentario'])->one();
        if($id_persona)
        {
            $query->joinWith(['emisorPersona', 'areaAprobadora','codigoFlujo'])
                ->andFilterWhere(
                    ['or',
                        ['=','areaAprobadora.responsable', $id_persona],
                        ['=','emisorPersona.staff_persona_id', $id_persona]
                    ]     
                )
                ->andFilterWhere(['!=','flujo_flujo.tipo_flujo_metacodigo', $metacodigo_model_adquisicion->metacodigo_id])
                ->andFilterWhere(['!=','flujo_flujo.tipo_flujo_metacodigo', $metacodigo_model_documentario->metacodigo_id]);    

        }

        $query->joinWith(['codigoFlujo', 'codigoPaso']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'fechaEsperada' => SORT_ASC,
                ]
            ]
        ]);
//        $dataProvider->sort->attributes['documentoPniaNombreDocumento'] = [
//            // The tables are the ones our relation are configured to
//            // in my case they are prefixed with "tbl_"
//            'asc' => ['documento_pnia.nombre_documento' => SORT_ASC],
//            'desc' => ['documento_pnia.nombre_documento' => SORT_DESC],
//        ];
        $dataProvider->sort->attributes['flujoReqDescripcion'] = [
            'asc' => ['flujo_requerimiento.descripcion' => SORT_ASC],
            'desc' => ['flujo_requerimiento.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['codigoFlujo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['flujo_flujo.nombre_flujo' => SORT_ASC],
            'desc' => ['flujo_flujo.nombre_flujo' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['codigoPaso'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['flujo_paso.nombre_paso' => SORT_ASC],
            'desc' => ['flujo_paso.nombre_paso' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['fechaEsperada'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['flujo_requerimiento.fecha_esperada' => SORT_ASC],
            'desc' => ['flujo_requerimiento.fecha_esperada' => SORT_DESC],
            'default' => SORT_ASC,
        ];
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'flujo_requerimiento_id' => $this->flujo_requerimiento_id,
            'emisor_persona_id' => $this->emisor_persona_id,
            //'codigo_flujo' => $this->codigo_flujo,
            //'codigo_paso' => $this->codigo_paso,
            'area_aprobadora_id' => $this->area_aprobadora_id,
            'estado_paso' => $this->estado_paso,
            'fecha_instanciacion' => $this->fecha_instanciacion,
            'codigo_arbol' => $this->codigo_arbol,
            'periodo_id' => $this->periodo_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'flag_procesado' => $this->flag_procesado,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por
        ]);

        $query->andFilterWhere(['like', 'flujo_requerimiento.descripcion', $this->flujoReqDescripcion]);
        //$query->andFilterWhere(['like', 'flujo_requerimiento.fecha_esperada', $this->fechaEsperada]);
        $query->andFilterWhere(['like', 'flujo_flujo.nombre_flujo', $this->codigoFlujo]);
        $query->andFilterWhere(['like', 'flujo_paso.nombre_paso', $this->codigoPaso]);
        $query->andFilterWhere(['=', 'flag_procesado', 0]);
        //$query->andFilterWhere(['>', 'flujo_requerimiento.codigo_flujo', 2]);
        //$query->andFilterWhere(['like', 'documento_pnia.nombre_documento', $this->documentoPniaNombreDocumento]);

        return $dataProvider;
    }
    
    public function searchListaRequerimientos($params, $codigo_requerimiento)
    {
        $id_persona = Yii::$app->user->identity->persona_id;

        $query = FlujoRequerimiento::find();
        //$query = FlujoRequerimiento::find()->select(['flujo_requerimiento.descripcion', 
               // 'flujo_requerimiento.codigo_flujo', 'flujo_requerimiento.codigo_paso', 'flujo_requerimiento.fecha_esperada'])->distinct();

        if($id_persona)
        {
            $query->joinWith(['emisorPersona', 'areaAprobadora'])
                ->andFilterWhere(
                    ['or',
                        ['=','areaAprobadora.responsable', $id_persona],
                        ['=','emisorPersona.staff_persona_id', $id_persona]
                    ]     
                );    
        }

        $query->joinWith(['codigoFlujo', 'codigoPaso']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//        $dataProvider->sort->attributes['documentoPniaNombreDocumento'] = [
//            // The tables are the ones our relation are configured to
//            // in my case they are prefixed with "tbl_"
//            'asc' => ['documento_pnia.nombre_documento' => SORT_ASC],
//            'desc' => ['documento_pnia.nombre_documento' => SORT_DESC],
//        ];
        $dataProvider->sort->attributes['flujoReqDescripcion'] = [
            'asc' => ['flujo_requerimiento.descripcion' => SORT_ASC],
            'desc' => ['flujo_requerimiento.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['codigoFlujo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['flujo_flujo.nombre_flujo' => SORT_ASC],
            'desc' => ['flujo_flujo.nombre_flujo' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['codigoPaso'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['flujo_paso.nombre_paso' => SORT_ASC],
            'desc' => ['flujo_paso.nombre_paso' => SORT_DESC],
        ];
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'flujo_requerimiento_id' => $this->flujo_requerimiento_id,
            'emisor_persona_id' => $this->emisor_persona_id,
            //'codigo_flujo' => $this->codigo_flujo,
            //'codigo_paso' => $this->codigo_paso,
            'area_aprobadora_id' => $this->area_aprobadora_id,
            'estado_paso' => $this->estado_paso,
            'fecha_instanciacion' => $this->fecha_instanciacion,
            'codigo_arbol' => $this->codigo_arbol,
            'periodo_id' => $this->periodo_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'flag_procesado' => $this->flag_procesado,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por
        ]);

        $query->andFilterWhere(['like', 'flujo_requerimiento.descripcion', $this->flujoReqDescripcion]);
        $query->andFilterWhere(['like', 'flujo_flujo.nombre_flujo', $this->codigoFlujo]);
        $query->andFilterWhere(['like', 'flujo_paso.nombre_paso', $this->codigoPaso]);
        //$query->andFilterWhere(['=', 'flag_procesado', 0]);
        //$query->andFilterWhere(['like', 'documento_pnia.nombre_documento', $this->documentoPniaNombreDocumento]);
        
        $query->andFilterWhere(['=', 'flujo_requerimiento.codigo_requerimiento', $codigo_requerimiento]);

        return $dataProvider;
    }
    
    
    public function searchTramiteDoc($params)
    {
        $id_persona = Yii::$app->user->identity->persona_id;

        $query = FlujoRequerimiento::find();
        //$query = FlujoRequerimiento::find()->select(['flujo_requerimiento.descripcion', 
               // 'flujo_requerimiento.codigo_flujo', 'flujo_requerimiento.codigo_paso', 'flujo_requerimiento.fecha_esperada'])->distinct();
        
        $metacodigo_model = Metacodigo::find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Trámite Documentario'])->one();
        

        if($id_persona)
        {
            $query->joinWith(['emisorPersona', 'areaAprobadora','codigoFlujo'])
                ->andFilterWhere(
                    ['or',
                        ['=','areaAprobadora.responsable', $id_persona],
                        ['=','emisorPersona.staff_persona_id', $id_persona]
                    ]     
                )
                ->andFilterWhere(['=','flujo_flujo.tipo_flujo_metacodigo', $metacodigo_model->metacodigo_id]);    
        }

        $query->joinWith(['codigoFlujo', 'codigoPaso']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//        $dataProvider->sort->attributes['documentoPniaNombreDocumento'] = [
//            // The tables are the ones our relation are configured to
//            // in my case they are prefixed with "tbl_"
//            'asc' => ['documento_pnia.nombre_documento' => SORT_ASC],
//            'desc' => ['documento_pnia.nombre_documento' => SORT_DESC],
//        ];
        $dataProvider->sort->attributes['flujoReqDescripcion'] = [
            'asc' => ['flujo_requerimiento.descripcion' => SORT_ASC],
            'desc' => ['flujo_requerimiento.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['codigoFlujo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['flujo_flujo.nombre_flujo' => SORT_ASC],
            'desc' => ['flujo_flujo.nombre_flujo' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['codigoPaso'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['flujo_paso.nombre_paso' => SORT_ASC],
            'desc' => ['flujo_paso.nombre_paso' => SORT_DESC],
        ];
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'flujo_requerimiento_id' => $this->flujo_requerimiento_id,
            'emisor_persona_id' => $this->emisor_persona_id,
            //'codigo_flujo' => $this->codigo_flujo,
            //'codigo_paso' => $this->codigo_paso,
            'area_aprobadora_id' => $this->area_aprobadora_id,
            'estado_paso' => $this->estado_paso,
            'fecha_instanciacion' => $this->fecha_instanciacion,
            'codigo_arbol' => $this->codigo_arbol,
            'periodo_id' => $this->periodo_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'flag_procesado' => $this->flag_procesado,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por
        ]);

        $query->andFilterWhere(['like', 'flujo_requerimiento.descripcion', $this->flujoReqDescripcion]);
        $query->andFilterWhere(['like', 'flujo_flujo.nombre_flujo', $this->codigoFlujo]);
        $query->andFilterWhere(['like', 'flujo_paso.nombre_paso', $this->codigoPaso]);
        $query->andFilterWhere(['=', 'flag_procesado', 0]);
        //$query->andFilterWhere(['like', 'documento_pnia.nombre_documento', $this->documentoPniaNombreDocumento]);

        return $dataProvider;
    }
    
    public function searchGestionAdq($params)
    {
        $id_persona = Yii::$app->user->identity->persona_id;

        $query = FlujoRequerimiento::find();
        //$query = FlujoRequerimiento::find()->select(['flujo_requerimiento.descripcion', 
               // 'flujo_requerimiento.codigo_flujo', 'flujo_requerimiento.codigo_paso', 'flujo_requerimiento.fecha_esperada'])->distinct();
        
        $metacodigo_model = Metacodigo::find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Adquisición'])->one();

        if($id_persona)
        {
            $query->joinWith(['emisorPersona', 'areaAprobadora','codigoFlujo'])
                ->andFilterWhere(
                    ['or',
                        ['=','areaAprobadora.responsable', $id_persona],
                        ['=','emisorPersona.staff_persona_id', $id_persona],
                    ]     
                )
                ->andFilterWhere(['=','flujo_flujo.tipo_flujo_metacodigo', $metacodigo_model->metacodigo_id]);    
        }

        $query->joinWith(['codigoFlujo', 'codigoPaso']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//        $dataProvider->sort->attributes['documentoPniaNombreDocumento'] = [
//            // The tables are the ones our relation are configured to
//            // in my case they are prefixed with "tbl_"
//            'asc' => ['documento_pnia.nombre_documento' => SORT_ASC],
//            'desc' => ['documento_pnia.nombre_documento' => SORT_DESC],
//        ];
        $dataProvider->sort->attributes['flujoReqDescripcion'] = [
            'asc' => ['flujo_requerimiento.descripcion' => SORT_ASC],
            'desc' => ['flujo_requerimiento.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['codigoFlujo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['flujo_flujo.nombre_flujo' => SORT_ASC],
            'desc' => ['flujo_flujo.nombre_flujo' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['codigoPaso'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['flujo_paso.nombre_paso' => SORT_ASC],
            'desc' => ['flujo_paso.nombre_paso' => SORT_DESC],
        ];
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'flujo_requerimiento_id' => $this->flujo_requerimiento_id,
            'emisor_persona_id' => $this->emisor_persona_id,
            //'codigo_flujo' => $this->codigo_flujo,
            //'codigo_paso' => $this->codigo_paso,
            'area_aprobadora_id' => $this->area_aprobadora_id,
            'estado_paso' => $this->estado_paso,
            'fecha_instanciacion' => $this->fecha_instanciacion,
            'codigo_arbol' => $this->codigo_arbol,
            'periodo_id' => $this->periodo_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'flag_procesado' => $this->flag_procesado,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por
        ]);

        $query->andFilterWhere(['like', 'flujo_requerimiento.descripcion', $this->flujoReqDescripcion]);
        $query->andFilterWhere(['like', 'flujo_flujo.nombre_flujo', $this->codigoFlujo]);
        $query->andFilterWhere(['like', 'flujo_paso.nombre_paso', $this->codigoPaso]);
        $query->andFilterWhere(['=', 'flag_procesado', 0]);
        //$query->andFilterWhere(['like', 'documento_pnia.nombre_documento', $this->documentoPniaNombreDocumento]);

        return $dataProvider;
    }
}
