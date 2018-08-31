<?php

namespace app\models\Adquisicion;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Adquisicion\Requerimiento;

/**
 * RequerimientoSearch represents the model behind the search form about `app\models\Adquisicion\Requerimiento`.
 */
class RequerimientoSearch extends Requerimiento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requerimiento_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['descripcion', 'asunto', 'documento', 'actualizado_en', 'creado_en'], 'safe'],
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
        $query = Requerimiento::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //$query->select('tipo_requerimiento_id,asunto,descripcion,documento');
        //$query->innerJoin('metacodigo','metacodigo.metacodigo_id=requerimiento.tipo_requerimiento_id');
        $query->andFilterWhere([
            'requerimiento_id' => $this->requerimiento_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'asunto', $this->asunto])
            ->andFilterWhere(['like', 'documento', $this->documento]);

        return $dataProvider;
    }

    public function searchAutorizacionJefeRequerimiento($params)
    {

        $query = Requerimiento::find();

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
            'requerimiento_id' => $this->requerimiento_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'asunto', $this->asunto])
            ->andFilterWhere(['like', 'documento', $this->documento])
            ->andFilterWhere(['in', 'situacion_requerimiento_id', [2,3,4,5,6,7,8,9,10,11,12,13]]);

        return $dataProvider;
    }

    public function searchAutorizacionOperacionesRequerimiento($params)
    {

        $query = Requerimiento::find();

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
            'requerimiento_id' => $this->requerimiento_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'asunto', $this->asunto])
            ->andFilterWhere(['like', 'documento', $this->documento])
            ->andFilterWhere(['in', 'situacion_requerimiento_id', [5,6,7,8,9,10,11,12,13]]);

        return $dataProvider;
    }

    public function searchAutorizacionPlaneacionRequerimiento($params)
    {

        $query = Requerimiento::find();

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
            'requerimiento_id' => $this->requerimiento_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'asunto', $this->asunto])
            ->andFilterWhere(['like', 'documento', $this->documento])
            ->andFilterWhere(['in', 'situacion_requerimiento_id', [6,8,9,10,11,12,13]]);

        return $dataProvider;
    }

    public function searchAutorizacionAdjudicacionRequerimiento($params)
    {

        $query = Requerimiento::find();

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
            'requerimiento_id' => $this->requerimiento_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'asunto', $this->asunto])
            ->andFilterWhere(['like', 'documento', $this->documento])
            ->andFilterWhere(['in', 'situacion_requerimiento_id', [9,11,12,13]]);

        return $dataProvider;
    }
}
