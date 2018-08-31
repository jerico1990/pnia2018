<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\Periodo;

/**
 * PeriodoSearch represents the model behind the search form about `app\models\Presupuesto\Periodo`.
 */
class PeriodoSearch extends Periodo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['periodo_id', 'anho', 'trimestre', 'mes', 'actualizado_por', 'creado_por','estatus_abierto'], 'integer'],
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
        $query = Periodo::find();

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
            'periodo_id' => $this->periodo_id,
            'anho' => $this->anho,
            'trimestre' => $this->trimestre,
            'mes' => $this->mes,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
            'estatus_abierto' => $this->estatus_abierto,
        ]);

        return $dataProvider;
    }
}
