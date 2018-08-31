<?php

namespace app\models\Viatico;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viatico\FondoViaticoDetalle;

/**
 * FondoViaticoDetalleSearch represents the model behind the search form about `app\models\Viatico\FondoViaticoDetalle`.
 */
class FondoViaticoDetalleSearch extends FondoViaticoDetalle
{
    /**
     * @inheritdoc
     */
    public $inicialUbigeo;
    public $finalUbigeo;
    
    public function rules()
    {
        return [
            [['fondo_viatico_detalle_id', 'destino_inicial_ubigeo', 'destino_final_ubigeo', 'numero_dias', 'actualizado_por', 'creado_por', 'fondo_fondo_id'], 'integer'],
            [['monto'], 'number'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['inicialUbigeo', 'finalUbigeo'], 'safe'],
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
        $query = FondoViaticoDetalle::find();

        $query->joinWith(['destinoInicialUbigeo', 'destinoFinalUbigeo']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['inicialUbigeo'] = [
            'asc' => ['destinoInicialUbigeo.nombre' => SORT_ASC],
            'desc' => ['destinoInicialUbigeo.nombre' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['finalUbigeo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['destinoFinalUbigeo.nombre' => SORT_ASC],
            'desc' => ['destinoFinalUbigeo.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'fondo_viatico_detalle_id' => $this->fondo_viatico_detalle_id,
            'fondo_fondo_id' => $this->fondo_fondo_id,
            'destino_inicial_ubigeo' => $this->destino_inicial_ubigeo,
            'destino_final_ubigeo' => $this->destino_final_ubigeo,
            'numero_dias' => $this->numero_dias,
            'monto' => $this->monto,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'destinoInicialUbigeo.nombre', $this->inicialUbigeo]);
        $query->andFilterWhere(['like', 'destinoFinalUbigeo.nombre', $this->finalUbigeo]);

        if (isset($_SESSION['fondo_fondo_id'])) {
            $query->andFilterWhere(['fondo_fondo_id' => $_SESSION['fondo_fondo_id']]);
        } else {
            $query->andFilterWhere(['fondo_fondo_id' => 0]);
        }


        return $dataProvider;
    }
}
