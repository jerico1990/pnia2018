<?php

namespace app\models\rrhh;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rrhh\ContratoEntregable;

/**
 * ContratoEntregableSearch represents the model behind the search form about `app\models\rrhh\ContratoEntregable`.
 */
class ContratoEntregableSearch extends ContratoEntregable
{
    /**
     * @inheritdoc
     */
    public $contratoCodigoInterno;
    public $metacodigoEstadoEntregablesDescripcion;

    public function rules()
    {
        return [
            [['contrato_entregable_id', 'codigo_contrato', 'estado', 'actualizado_por', 'creado_por'], 'integer'],
            [['descripcion', 'fecha', 'actualizado_en', 'creado_en'], 'safe'],
            [['monto'], 'number'],
            [['contratoCodigoInterno', 'metacodigoEstadoEntregablesDescripcion'], 'safe']
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
        $query = ContratoEntregable::find();
        
        $query->joinWith(['codigoContrato', 'estadoEntregables']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['metacodigoEstadoEntregablesDescripcion'] = [
            'asc' => ['metacodigo.descripcion' => SORT_ASC],
            'desc' => ['metacodigo.descripcion' => SORT_DESC],
        ];
        
        // $dataProvider->sort->attributes['contratoCodigoInterno'] = [
        //     'asc' => ['contrato_contrato.codigo_interno' => SORT_ASC],
        //     'desc' => ['contrato_contrato.codigo_interno' => SORT_DESC],
        // ];
        // $dataProvider->sort->attributes['descripcion'] = [
        //     'asc' => ['contrato_entregable.descripcion' => SORT_ASC],
        //     'desc' => ['contrato_entregable.descripcion' => SORT_DESC],
        // ];
        // $dataProvider->sort->attributes['monto'] = [
        //     'asc' => ['contrato_entregable.monto' => SORT_ASC],
        //     'desc' => ['contrato_entregable.monto' => SORT_DESC],
        // ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'contrato_entregable_id' => $this->contrato_entregable_id,
            'codigo_contrato' => $this->codigo_contrato,
            'estado' => $this->estado,
            'contrato_entregable.monto' => $this->monto,
            'fecha' => $this->fecha,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'contrato_entregable.descripcion', $this->descripcion]);

        if (isset($_SESSION['codigo_interno_contrato'])) {
            $query->andFilterWhere(['codigo_contrato' => $_SESSION['codigo_interno_contrato']]);
        } else {
            $query->andFilterWhere(['codigo_contrato' => 0]);
        }
        
        $query->andFilterWhere(['like', 'metacodigo.descripcion', $this->metacodigoEstadoEntregablesDescripcion]);

        return $dataProvider;
    }
}
