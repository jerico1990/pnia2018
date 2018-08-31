<?php

namespace app\models\rrhh;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rrhh\PniaEntidad;

/**
 * PniaEntidadSearch represents the model behind the search form about `app\models\rrhh\PniaEntidad`.
 */
class PniaEntidadSearch extends PniaEntidad
{
    /**
     * @inheritdoc
     */
    
    public $metacodigoEntidadDescripcion;
    public $Ruc;
    
    public function rules()
    {
        return [
            [['pnia_entidad_id', 'tipo_entidad', 'ruc', 'actualizado_por', 'creado_por'], 'integer'],
            [['razon_social', 'actualizado_en', 'creado_en'], 'safe'],
            [['metacodigoEntidadDescripcion', 'Ruc'], 'safe']
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
        $query = PniaEntidad::find();
        
        $query->joinWith(['tipoEntidad']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        
        $dataProvider->sort->attributes['metacodigoEntidadDescripcion'] = [
            //cuando solo hay un campo con una relación a una tabla, va el nombre de la tabla como este en la BD. EJ: 'metacodigo'
            //cuando existe un alias, le ponen el nombre del alias
            'asc' => ['metacodigo.descripcion' => SORT_ASC],
            'desc' => ['metacodigo.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['Ruc'] = [
            //cuando solo hay un campo con una relación a una tabla, va el nombre de la tabla como este en la BD. EJ: 'metacodigo'
            //cuando existe un alias, le ponen el nombre del alias
            'asc' => ['pnia_entidad.ruc' => SORT_ASC],
            'desc' => ['pnia_entidad.ruc' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'pnia_entidad_id' => $this->pnia_entidad_id,
            'tipo_entidad' => $this->tipo_entidad,
            //'ruc' => $this->ruc,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'razon_social', $this->razon_social]);
        
        $query->andFilterWhere(['like', 'metacodigo.descripcion', $this->metacodigoEntidadDescripcion]);
        $query->andFilterWhere(['like', 'pnia_entidad.ruc', $this->Ruc]);

        return $dataProvider;
    }
}
