<?php

namespace app\models\Adquisicion;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Adquisicion\Proyecto;

/**
 * ProyectoSearch represents the model behind the search form about `app\models\Adquisicion\Proyecto`.
 */
class ProyectoSearch extends Proyecto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proyecto_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['nombre', 'actualizado_en', 'creado_en'], 'safe'],
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
        $query = Proyecto::find();

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
            'proyecto_id' => $this->proyecto_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }

    
}
