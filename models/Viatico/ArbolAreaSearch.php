<?php

namespace app\models\Viatico;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viatico\ArbolArea;

/**
 * ArbolAreaSearch represents the model behind the search form about `app\models\Viatico\ArbolArea`.
 */
class ArbolAreaSearch extends ArbolArea
{
    /**
     * @inheritdoc
     */
    public $arbolPniaDescripcion;
    public $staffAreaDescripcion;
    public function rules()
    {
        return [
            [['arbol_area_id', 'staff_area_id', 'presupuesto_cabecera_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en', 'arbolPniaDescripcion', 'staffAreaDescripcion'], 'safe'],
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
        $query = ArbolArea::find();
//        $query->joinWith(['staffArea', 'arbolPnia']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['staffAreaDescripcion'] = [
            'asc' => ['staff_area.descripcion' => SORT_ASC],
            'desc' => ['staff_area.descripcion' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'arbol_area_id' => $this->arbol_area_id,
            'staff_area_id' => $this->staff_area_id,
            'presupuesto_cabecera_id' => $this->presupuesto_cabecera_id,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

//        $query->andFilterWhere(['like', 'staff_area.descripcion', $this->staffAreaDescripcion]);
        
        return $dataProvider;
    }
}
