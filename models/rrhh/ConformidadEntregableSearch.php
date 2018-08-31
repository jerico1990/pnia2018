<?php

namespace app\models\rrhh;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rrhh\ConformidadEntregable;

/**
 * ConformidadEntregableSearch represents the model behind the search form about `app\models\rrhh\ConformidadEntregable`.
 */
class ConformidadEntregableSearch extends ConformidadEntregable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conformidad_entregable_id', 'contrato_entregable_id', 'staff_area_id', 'flag_conformidad', 'actualizado_por', 'creado_por'], 'integer'],
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
        $id_persona = Yii::$app->user->identity->persona_id;
        $query = ConformidadEntregable::find();
        
        $query->joinWith(['staffArea'])
              ->andFilterWhere(['=', 'staff_area.responsable', $id_persona]);

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
            'conformidad_entregable_id' => $this->conformidad_entregable_id,
            'contrato_entregable_id' => $this->contrato_entregable_id,
            'staff_area_id' => $this->staff_area_id,
            'flag_conformidad' => $this->flag_conformidad,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        return $dataProvider;
    }
}
