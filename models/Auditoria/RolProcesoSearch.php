<?php

namespace app\models\Auditoria;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Auditoria\RolProceso;

/**
 * RolProcesoSearch represents the model behind the search form about `app\models\RolProceso`.
 */
class RolProcesoSearch extends RolProceso
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rol_proceso_id', 'rol_id', 'proceso_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['permiso', 'descripcion', 'actualizado_en', 'creado_en'], 'safe'],
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
        $query = RolProceso::find();

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
            'rol_proceso_id' => $this->rol_proceso_id,
            'rol_id' => $this->rol_id,
            'proceso_id' => $this->proceso_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['ilike', 'permiso', $this->permiso])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
