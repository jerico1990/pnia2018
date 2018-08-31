<?php

namespace app\models\Viatico;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viatico\FondoRendicionCajaChica;

/**
 * FondoRendicionCajaChicaSearch represents the model behind the search form about `app\models\Viatico\FondoRendicionCajaChica`.
 */
class FondoRendicionCajaChicaSearch extends FondoRendicionCajaChica
{
    /**
     * @inheritdoc
     */
    public $fondoDescripcion;
    public $rendicionRequerimiento;
    public function rules()
    {
        return [
            [['fondo_rendicion_caja_chica_id', 'fondo_fondo_id', 'flujo_requerimiento_id', 'responsable_persona_id', 'documento_pnia', 'correlativo', 'actualizado_por', 'creado_por'], 'integer'],
            [['total_rendicion'], 'number'],
            [['fecha_rendicion', 'actualizado_en', 'creado_en'], 'safe'],
            [['fondoDescripcion', 'rendicionRequerimiento'], 'safe']
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
        $query = FondoRendicionCajaChica::find();
        
        $query->joinWith(['fondoFondo', 'flujoRequerimiento']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['fondoDescripcion'] = [
            'asc' => ['fondo_fondo.motivo' => SORT_ASC],
            'desc' => ['fondo_fondo.motivo' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['rendicionRequerimiento'] = [
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
            'fondo_rendicion_caja_chica_id' => $this->fondo_rendicion_caja_chica_id,
            'fondo_fondo_id' => $this->fondo_fondo_id,
            'flujo_requerimiento_id' => $this->flujo_requerimiento_id,
//            'tipo_flujo_metacodigo' => $this->tipo_flujo_metacodigo,
//            'estado_paso_metacodigo' => $this->estado_paso_metacodigo,
            'responsable_persona_id' => $this->responsable_persona_id,
            'total_rendicion' => $this->total_rendicion,
            'documento_pnia' => $this->documento_pnia,
            'fecha_rendicion' => $this->fecha_rendicion,
            'correlativo' => $this->correlativo,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);
        
        $query->andFilterWhere(['like', 'fondo_fondo.motivo', $this->fondoDescripcion]);
        $query->andFilterWhere(['like', 'flujo_requerimiento.descripcion', $this->rendicionRequerimiento]);

        return $dataProvider;
    }
}
