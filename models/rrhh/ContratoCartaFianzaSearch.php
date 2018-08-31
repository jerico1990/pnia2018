<?php

namespace app\models\rrhh;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rrhh\ContratoCartaFianza;

/**
 * ContratoCartaFianzaSearch represents the model behind the search form about `app\models\rrhh\ContratoCartaFianza`.
 */
class ContratoCartaFianzaSearch extends ContratoCartaFianza
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contrato_carta_fianza_id', 'entidad_emisora', 'entidad_afianzada', 'contrato', 'actualizado_por', 'creado_por'], 'integer'],
            [['codigo_interno', 'periodo_inicio', 'periodo_fin', 'actualizado_en', 'creado_en'], 'safe'],
            [['monto'], 'number'],
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
        $query = ContratoCartaFianza::find();

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
            'contrato_carta_fianza_id' => $this->contrato_carta_fianza_id,
            'entidad_emisora' => $this->entidad_emisora,
            'entidad_afianzada' => $this->entidad_afianzada,
            'contrato' => $this->contrato,
            'periodo_inicio' => $this->periodo_inicio,
            'periodo_fin' => $this->periodo_fin,
            'monto' => $this->monto,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'codigo_interno', $this->codigo_interno]);

        return $dataProvider;
    }
}
