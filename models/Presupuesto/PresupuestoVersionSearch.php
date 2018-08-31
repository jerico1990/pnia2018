<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\PresupuestoVersion;

/**
 * PresupuestoVersionSearch represents the model behind the search form about `app\models\Presupuesto\PresupuestoVersion`.
 */
class PresupuestoVersionSearch extends PresupuestoVersion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['presupuesto_version_id', 'estatus', 'nro_version', 'actualizado_por', 'creado_por'], 'integer'],
            [['fecha', 'actualizado_en', 'creado_en','descripcion'], 'safe'],
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
        $query = PresupuestoVersion::find();

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
            'presupuesto_version_id' => $this->presupuesto_version_id,
            'nro_version' => $this->nro_version,
            'fecha' => $this->fecha,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
            'estatus' => $this->estatus,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
