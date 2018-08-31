<?php

namespace app\models\rrhh;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rrhh\StaffPersona;

/**
 * StaffPersonaSearch represents the model behind the search form about `app\models\rrhh\StaffPersona`.
 */
class StaffPersonaSearch extends StaffPersona
{
    /**
     * @inheritdoc
     */
    public $Ruc;
    public $razon_social_EF;

    public function rules()
    {
        return [
            [['staff_persona_id', 'ruc', 'actualizado_por', 'creado_por'], 'integer'],
            [['nombres', 'apellido_paterno', 'apellido_materno', 'codigo_pnia', 'cuenta_bancaria', 'actualizado_en', 'creado_en'], 'safe'],
            [['Ruc','razon_social_EF'], 'safe'],
            [['nombreCompleto'],'string'],
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
        $query = StaffPersona::find();
        $query->joinWith(['pniaEntFinanciera']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['Ruc'] = [
            //cuando solo hay un campo con una relación a una tabla, va el nombre de la tabla como este en la BD. EJ: 'metacodigo'
            //cuando existe un alias, le ponen el nombre del alias
            'asc'  => ['staff_persona.ruc' => SORT_ASC],
            'desc' => ['staff_persona.ruc' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['razon_social_EF'] = [
            'asc'  => ['pnia_ent_financiera.razon_social' => SORT_ASC],
            'desc' => ['pnia_ent_financiera.razon_social' => SORT_DESC],
        ];



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'staff_persona_id' => $this->staff_persona_id,
            //'ruc' => $this->ruc,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellido_paterno', $this->apellido_paterno])
            ->andFilterWhere(['like', 'apellido_materno', $this->apellido_materno])
            ->andFilterWhere(['like', 'codigo_pnia', $this->codigo_pnia])
            ->andFilterWhere(['like', 'cuenta_bancaria', $this->cuenta_bancaria]);
        
        $query->andFilterWhere(['like', 'staff_persona.ruc', $this->Ruc]);
        $query->andFilterWhere(['like', 'pnia_ent_financiera.razon_social', $this->razon_social_EF]);

        return $dataProvider;
    }
}
