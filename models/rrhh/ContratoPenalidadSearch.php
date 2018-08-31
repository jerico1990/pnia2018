<?php

namespace app\models\rrhh;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rrhh\ContratoPenalidad;

/**
 * ContratoPenalidadSearch represents the model behind the search form about `app\models\rrhh\ContratoPenalidad`.
 */
class ContratoPenalidadSearch extends ContratoPenalidad
{
    /**
     * @inheritdoc
     */
    public $contratoCodigoInterno;
    
    public function rules()
    {
        return [
            [['contrato_penalidad_id', 'codigo_contrato', 'actualizado_por', 'creado_por'], 'integer'],
            [['descripcion', 'actualizado_en', 'creado_en'], 'safe'],
            [['monto_penalidad'], 'number'],
            [['contratoCodigoInterno'], 'safe'],
            //[['MontoPenalidad'], 'safe']
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
        $query = ContratoPenalidad::find();
        
        $query->joinWith(['codigoContrato']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        // $dataProvider->sort->attributes['contratoCodigoInterno'] = [
        //     //cuando solo hay un campo con una relación a una tabla, va el nombre de la tabla como este en la BD. EJ: 'metacodigo'
        //     //cuando existe un alias, le ponen el nombre del alias
        //     'asc' => ['contrato_contrato.codigo_interno' => SORT_ASC],
        //     'desc' => ['contrato_contrato.codigo_interno' => SORT_DESC],
        // ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'contrato_penalidad_id' => $this->contrato_penalidad_id,
            'codigo_contrato' => $this->codigo_contrato,
            'monto_penalidad' => $this->monto_penalidad,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);
        
        if (isset($_SESSION['codigo_interno_contrato'])) {
            $query->andFilterWhere(['codigo_contrato' => $_SESSION['codigo_interno_contrato']]);
        } else {
            $query->andFilterWhere(['codigo_contrato' => 0]);
        }

        return $dataProvider;
    }
}
