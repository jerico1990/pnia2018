<?php

namespace app\models\Adquisicion;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Adquisicion\Adjudicacion;

/**
 * AdjudicacionSearch represents the model behind the search form about `app\models\Adquisicion\Adjudicacion`.
 */
class AdjudicacionSearch extends Adjudicacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adjudicacion_id', 'requerimiento_detalle_id', 'requerimiento_id', 'situacion_adjudicacion_id', 'actualizado_por', 'creado_por'], 'integer'],
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
        $query = Adjudicacion::find();

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
            'adjudicacion_id' => $this->adjudicacion_id,
            'requerimiento_detalle_id' => $this->requerimiento_detalle_id,
            'requerimiento_id' => $this->requerimiento_id,
            'situacion_adjudicacion_id' => $this->situacion_adjudicacion_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        return $dataProvider;
    }

    public function searchAutorizacionAdjudicacion($params)
    {
        $query = Adjudicacion::find();

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
            'adjudicacion_id' => $this->adjudicacion_id,
            'requerimiento_detalle_id' => $this->requerimiento_detalle_id,
            'requerimiento_id' => $this->requerimiento_id,
            'situacion_adjudicacion_id' => $this->situacion_adjudicacion_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['in', 'situacion_adjudicacion_id', [2,3,4,5,6,7]]);

        return $dataProvider;
    }

}
