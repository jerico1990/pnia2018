<?php

namespace app\models\Auditoria;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Auditoria\Proceso;

/**
 * ProcesoSearch represents the model behind the search form about `app\models\Proceso`.
 */
class ProcesoSearch extends Proceso
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proceso_id', 'modulo_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['descripcion', 'url_accion', 'actualizado_en', 'creado_en'], 'safe'],
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
        $query = Proceso::find();

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
            'proceso_id' => $this->proceso_id,
            'modulo_id' => $this->modulo_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'url_accion', $this->url_accion]);

        return $dataProvider;
    }
}
