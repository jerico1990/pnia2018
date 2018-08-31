<?php

namespace app\models\General;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\General\Postores;

/**
 * PostoresSearch represents the model behind the search form about `app\models\General\Postores`.
 */
class PostoresSearch extends Postores
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['postores_id', 'actualizado_por', 'creado_por','adjudicacion_id'], 'integer'],
            [['dni', 'nombres', 'apellido_paterno', 'apellido_materno', 'ruc', 'fecha_nacimiento', 'email', 'telefono', 'actualizado_en', 'creado_en'], 'safe'],
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
        $query = Postores::find();

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
            'postores_id' => $this->postores_id,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'dni', $this->dni])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellido_paterno', $this->apellido_paterno])
            ->andFilterWhere(['like', 'apellido_materno', $this->apellido_materno])
            ->andFilterWhere(['like', 'ruc', $this->ruc])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telefono', $this->telefono]);

        return $dataProvider;
    }
}
