<?php

namespace app\models\Viatico;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viatico\FlujoFlujo;

/**
 * FlujoFlujoSearch represents the model behind the search form about `app\models\Viatico\FlujoFlujo`.
 */
class FlujoFlujoSearch extends FlujoFlujo
{
    /**
     * @inheritdoc
     */
    public $tipoFlujoMetacodigo;
    public function rules()
    {
        return [
            [['flujo_flujo_id', 'tipo_flujo_metacodigo', 'actualizado_por', 'creado_por'], 'integer'],
            [['nombre_flujo', 'actualizado_en', 'creado_en'], 'safe'],
            [['tipoFlujoMetacodigo'], 'safe'],
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
        $query = FlujoFlujo::find();

        $query->joinWith(['tipoFlujoMetacodigo']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['tipoFlujoMetacodigo'] = [
            'asc' => ['metacodigo.descripcion' => SORT_ASC],
            'desc' => ['metacodigo.descripcion' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'flujo_flujo_id' => $this->flujo_flujo_id,
            'tipo_flujo_metacodigo' => $this->tipo_flujo_metacodigo,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'nombre_flujo', $this->nombre_flujo]);
        $query->andFilterWhere(['like', 'metacodigo.descripcion', $this->tipoFlujoMetacodigo]);

        return $dataProvider;
    }
}
