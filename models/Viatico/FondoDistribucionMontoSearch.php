<?php

namespace app\models\Viatico;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viatico\FondoDistribucionMonto;

/**
 * FondoDistribucionMontoSearch represents the model behind the search form about `app\models\Viatico\FondoDistribucionMonto`.
 */
class FondoDistribucionMontoSearch extends FondoDistribucionMonto
{
    /**
     * @inheritdoc
     */
    public $conceptoMetacodigoDesc;
    public $ubigeoOrigen;
    public $ubigeoDestino;
    public function rules()
    {
        return [
            [['fondo_distribucion_monto_id', 'escala_metacodigo', 'concepto_metacodigo', 'destino_ini_ubigeo', 'destino_fin_ubigeo', 'actualizado_por', 'creado_por'], 'integer'],
            [['monto_determinado'], 'number'],
            [['actualizado_en', 'creado_en', 'conceptoMetacodigoDesc', 'ubigeoOrigen', 'ubigeoDestino'], 'safe'],
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
        $query = FondoDistribucionMonto::find();
        
        $query->joinWith(['conceptoMetacodigo', 'destinoIniUbigeo', 'destinoFinUbigeo']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['conceptoMetacodigoDesc'] = [
            'asc' => ['conceptoMetacodigo.descripcion' => SORT_ASC],
            'desc' => ['conceptoMetacodigo.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['ubigeoOrigen'] = [
            'asc' => ['destinoInicial.nombre' => SORT_ASC],
            'desc' => ['destinoInicial.nombre' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['ubigeoDestino'] = [
            'asc' => ['destinoFinal.nombre' => SORT_ASC],
            'desc' => ['destinoFinal.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'fondo_distribucion_monto_id' => $this->fondo_distribucion_monto_id,
            'escala_metacodigo' => $this->escala_metacodigo,
//            'concepto_metacodigo' => $this->concepto_metacodigo,
//            'destino_ini_ubigeo' => $this->destino_ini_ubigeo,
//            'destino_fin_ubigeo' => $this->destino_fin_ubigeo,
            'monto_determinado' => $this->monto_determinado,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);
        
        $query->andFilterWhere(['like', 'conceptoMetacodigo.descripcion', $this->conceptoMetacodigoDesc]);
        $query->andFilterWhere(['like', 'destinoInicial.nombre', $this->ubigeoOrigen]);
        $query->andFilterWhere(['like', 'destinoFinal.nombre', $this->ubigeoDestino]);

        return $dataProvider;
    }
}
