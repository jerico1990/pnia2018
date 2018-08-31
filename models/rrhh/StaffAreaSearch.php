<?php

namespace app\models\rrhh;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rrhh\StaffArea;

/**
 * StaffAreaSearch represents the model behind the search form about `app\models\rrhh\StaffArea`.
 */
class StaffAreaSearch extends StaffArea
{
    /**
     * @inheritdoc
     */
    public $staffPersonaNombre;
    public function rules()
    {
        return [
            [['staff_area_id', 'responsable', 'area_superior', 'actualizado_por', 'creado_por'], 'integer'],
            [['codigo', 'descripcion', 'cargo', 'actualizado_en', 'creado_en'], 'safe'],
            [['staffPersonaNombre'], 'safe']
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
        $query = StaffArea::find();
        
        $query->joinWith(['personaResponsable']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['staffPersonaNombre'] = [
            //cuando solo hay un campo con una relación a una tabla, va el nombre de la tabla como este en la BD. EJ: 'metacodigo'
            //cuando existe un alias, le ponen el nombre del alias
            'asc' => ['staff_persona.nombres' => SORT_ASC],
            'desc' => ['staff_persona.nombres' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'staff_area_id' => $this->staff_area_id,
            'responsable' => $this->responsable,
            'area_superior' => $this->area_superior,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'cargo', $this->cargo]);
        
        $query->andFilterWhere(['like', 'staff_persona.nombres', $this->staffPersonaNombre]);

        return $dataProvider;
    }
}
