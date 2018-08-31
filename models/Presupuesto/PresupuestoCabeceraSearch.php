<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\PresupuestoCabecera;

/**
 * PresupuestoCabeceraSearch represents the model behind the search form about `app\models\Presupuesto\PresupuestoCabecera`.
 */
class PresupuestoCabeceraSearch extends PresupuestoCabecera
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['presupuesto_cabecera_id', 'presupuesto_version_id', 'linea_nivel_id', 'partida_id', 'presupuesto_cabecera_padre_id', 'actualizado_por', 'creado_por','linea_fk'], 'integer'],
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
        $query = PresupuestoCabecera::find();

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
            'presupuesto_cabecera_id' => $this->presupuesto_cabecera_id,
            'presupuesto_version_id' => $this->presupuesto_version_id,
            'linea_nivel_id' => $this->linea_nivel_id,
            'partida_id' => $this->partida_id,
            'presupuesto_cabecera_padre_id' => $this->presupuesto_cabecera_padre_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
            'linea.linea_id' => $this->linea_fk,
        ]);

        return $dataProvider;
    }
}
