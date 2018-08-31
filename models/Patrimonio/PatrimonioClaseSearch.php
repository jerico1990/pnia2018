<?php

namespace app\models\Patrimonio;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Patrimonio\PatrimonioClase;

/**
 * PatrimonioClaseSearch represents the model behind the search form about `app\models\Patrimonio\PatrimonioClase`.
 */
class PatrimonioClaseSearch extends PatrimonioClase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patrimonio_clase_id', 'patrimonio_clase_padre_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['nombre', 'codigo', 'actualizado_en', 'creado_en'], 'safe'],
            [['tasa_depreciacion'], 'number'],
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
        $query = PatrimonioClase::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['codigo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['patrimonio_clase.codigo' => SORT_ASC],
            'desc' => ['patrimonio_clase.codigo' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'patrimonio_clase_id' => $this->patrimonio_clase_id,
            'patrimonio_clase_padre_id' => $this->patrimonio_clase_padre_id,
            'tasa_depreciacion' => $this->tasa_depreciacion,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'codigo', $this->codigo]);

        return $dataProvider;
    }
}
