<?php

namespace app\models\rrhh;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rrhh\PniaEntFinanciera;

/**
 * PniaEntFinancieraSearch represents the model behind the search form about `app\models\rrhh\PniaEntFinanciera`.
 */
class PniaEntFinancieraSearch extends PniaEntFinanciera
{
    /**
     * @inheritdoc
     */
    public $metacodigoEntidadFinancieraDescripcion;
    public function rules()
    {
        return [
            [['pnia_ent_financiera_id', 'tipo_entidad', 'actualizado_por', 'creado_por'], 'integer'],
            [['razon_social', 'cuenta_bancaria', 'actualizado_en', 'creado_en'], 'safe'],
            [['metacodigoEntidadFinancieraDescripcion'], 'safe']
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
        $query = PniaEntFinanciera::find();
        
        $query->joinWith(['tipoEntidadFinanciera']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['metacodigoEntidadFinancieraDescripcion'] = [
            //cuando solo hay un campo con una relación a una tabla, va el nombre de la tabla como este en la BD. EJ: 'metacodigo'
            //cuando existe un alias, le ponen el nombre del alias
            'asc' => ['metacodigo.descripcion' => SORT_ASC],
            'desc' => ['metacodigo.descripcion' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'pnia_ent_financiera_id' => $this->pnia_ent_financiera_id,
            'tipo_entidad' => $this->tipo_entidad,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'razon_social', $this->razon_social])
            ->andFilterWhere(['like', 'cuenta_bancaria', $this->cuenta_bancaria]);
        
        $query->andFilterWhere(['like', 'metacodigo.descripcion', $this->metacodigoEntidadFinancieraDescripcion]);

        return $dataProvider;
    }
}
