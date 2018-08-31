<?php

namespace app\models\Viatico;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viatico\FlujoPaso;

/**
 * FlujoPasoSearch represents the model behind the search form about `app\models\Viatico\FlujoPaso`.
 */
class FlujoPasoSearch extends FlujoPaso
{
    /**
     * @inheritdoc
     */
    public $nombreFlujo;
    public $estadoPasoMetacodigo;
    public $areaResponsableDescripcion;
    public function rules()
    {
        return [
            [['flujo_paso_id', 'flujo', 'estado_paso_metacodigo', 'area_responsable_id', 'primer_flujo_paso', 'nivel', 'actualizado_por', 'creado_por'], 'integer'],
            [['nombre_paso', 'actualizado_en', 'creado_en'], 'safe'],
            [['nombreFlujo', 'estadoPasoMetacodigo', 'areaResponsableDescripcion'], 'safe']
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
        $query = FlujoPaso::find();

        $query->joinWith(['estadoPasoMetacodigo', 'flujo0', 'areaResponsable']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['nombreFlujo'] = [
            'asc' => ['flujo_flujo.nombre_flujo' => SORT_ASC],
            'desc' => ['flujo_flujo.nombre_flujo' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['estadoPasoMetacodigo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['metacodigo.descripcion' => SORT_ASC],
            'desc' => ['metacodigo.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['areaResponsableDescripcion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
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
            'flujo_paso_id' => $this->flujo_paso_id,
            'flujo' => $this->flujo,
            'estado_paso_metacodigo' => $this->estado_paso_metacodigo,
            'area_responsable_id' => $this->area_responsable_id,
            'primer_flujo_paso' => $this->primer_flujo_paso,
            'nivel' => $this->nivel,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'nombre_paso', $this->nombre_paso]);

        $query->andFilterWhere(['like', 'flujo_flujo.nombre_flujo', $this->nombreFlujo]);
        $query->andFilterWhere(['like', 'metacodigo.descripcion', $this->estadoPasoMetacodigo]);
        $query->andFilterWhere(['like', 'staff_area.descripcion', $this->areaResponsableDescripcion]);
        
        if (isset($_SESSION['flujo_flujo_id']))
        {
            $flujo_flujo_id = $_SESSION['flujo_flujo_id'];
            $query->andFilterWhere(['=', 'flujo_paso.flujo', $flujo_flujo_id]);
        }
        

        return $dataProvider;
    }
}
