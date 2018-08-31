<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\PresupuestoMeta;

/**
 * PresupuestoMetaSearch represents the model behind the search form about `app\models\Presupuesto\PresupuestoMeta`.
 */
class PresupuestoMetaSearch extends PresupuestoMeta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['presupuesto_meta_id', 'presupuesto_id', 'meta_fisica_id', 'meta_financiera_id', 'estado_meta', 'estado_financiero', 'estado_regitro', 'actualizado_por', 'creado_por'], 'integer'],
            [['unidad_fisica_consumida_temp', 'unidad_financiera_consumida_temp', 'unidad_fisica_consumida_final', 'unidad_financiera_consumida_final'], 'number'],
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
        $query = PresupuestoMeta::find();

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
            'presupuesto_meta_id' => $this->presupuesto_meta_id,
            'presupuesto_id' => $this->presupuesto_id,
            'meta_fisica_id' => $this->meta_fisica_id,
            'meta_financiera_id' => $this->meta_financiera_id,
            'unidad_fisica_consumida_temp' => $this->unidad_fisica_consumida_temp,
            'unidad_financiera_consumida_temp' => $this->unidad_financiera_consumida_temp,
            'unidad_fisica_consumida_final' => $this->unidad_fisica_consumida_final,
            'unidad_financiera_consumida_final' => $this->unidad_financiera_consumida_final,
            'estado_meta' => $this->estado_meta,
            'estado_financiero' => $this->estado_financiero,
            'estado_regitro' => $this->estado_regitro,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        return $dataProvider;
    }
}
