<?php

namespace app\models\Patrimonio;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Patrimonio\PatrimonioMovimiento;

/**
 * PatrimonioMovimientoSearch represents the model behind the search form about `app\models\Patrimonio\PatrimonioMovimiento`.
 */
class PatrimonioMovimientoSearch extends PatrimonioMovimiento
{
    /**
     * @inheritdoc
     */
    public $patrimonioItemDescripcion;
    public $metacodigoDescripcion;
    public $ubicacionInicialNombre;
    public $ubicacionFinalNombre;
    public function rules()
    {
        return [
            [['patrimonio_movimiento_id', 'patrimonio_item_id', 'metacodigo_id', 'ubicacion_inicial_id', 'ubicacion_final_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['persona_aut', 'persona_rec'], 'number'],
            [['fecha_salida', 'fecha_retorno', 'actualizado_en', 'creado_en'], 'safe'],
            [['patrimonioItemDescripcion', 'metacodigoDescripcion', 'ubicacionInicialNombre', 'ubicacionFinalNombre'], 'safe'],
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
        $query = PatrimonioMovimiento::find();
        
        $query->joinWith(['patrimonioItem', 'metacodigo', 'ubicacionInicial', 'ubicacionFinal']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['patrimonioItemDescripcion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['patrimonio_item.descripcion' => SORT_ASC],
            'desc' => ['patrimonio_item.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['metacodigoDescripcion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['metacodigo.descripcion' => SORT_ASC],
            'desc' => ['metacodigo.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['ubicacionInicialNombre'] = [
            'asc' => ['ubicacionInicial.nombre' => SORT_ASC],
            'desc' => ['ubicacionInicial.nombre' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['ubicacionFinalNombre'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['ubicacionFinal.nombre' => SORT_ASC],
            'desc' => ['ubicacionFinal.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'patrimonio_movimiento_id' => $this->patrimonio_movimiento_id,
            'patrimonio_item_id' => $this->patrimonio_item_id,
            'metacodigo_id' => $this->metacodigo_id,
            'ubicacion_inicial_id' => $this->ubicacion_inicial_id,
            'ubicacion_final_id' => $this->ubicacion_final_id,
            'persona_aut' => $this->persona_aut,
            'persona_rec' => $this->persona_rec,
            'fecha_salida' => $this->fecha_salida,
            'fecha_retorno' => $this->fecha_retorno,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);
        $query->andFilterWhere(['like', 'patrimonio_item.descripcion', $this->patrimonioItemDescripcion]);
        $query->andFilterWhere(['like', 'metacodigo.descripcion', $this->metacodigoDescripcion]);
        $query->andFilterWhere(['like', 'ubicacionInicial.nombre', $this->ubicacionInicialNombre]);
        $query->andFilterWhere(['like', 'ubicacionFinal.nombre', $this->ubicacionFinalNombre]);

        return $dataProvider;
    }
}
