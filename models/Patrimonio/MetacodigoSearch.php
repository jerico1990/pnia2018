<?php

namespace app\models\Patrimonio;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Patrimonio\Metacodigo;

/**
 * MetacodigoSearch represents the model behind the search form about `app\models\Patrimonio\Metacodigo`.
 */
class MetacodigoSearch extends Metacodigo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['metacodigo_id', 'codigo', 'actualizado_por', 'creado_por'], 'integer'],
            [['nombre_lista', 'descripcion', 'descripcion2', 'actualizado_en', 'creado_en'], 'safe'],
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
        $query = Metacodigo::find();

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
            'metacodigo_id' => $this->metacodigo_id,
            'codigo' => $this->codigo,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'nombre_lista', $this->nombre_lista])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'descripcion2', $this->descripcion2]);

        return $dataProvider;
    }
}
