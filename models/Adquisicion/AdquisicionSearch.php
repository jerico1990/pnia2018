<?php

namespace app\models\Adquisicion;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Adquisicion\Adquisicion;
use app\models\Auditoria\Usuario;
/**
 * AdquisicionSearch represents the model behind the search form about `app\models\Adquisicion\Adquisicion`.
 */
class AdquisicionSearch extends Adquisicion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adquisicion_id', 'flujo_requerimiento_id', 'codigo_referencia', 'referencia_actividad', 'tipo_revision', 'categoria', 'estado_proceso', 'estado_actividad', 'actualizado_por', 'creado_por'], 'integer'],
            [['nombre_firma', 'componente', 'enfoque_mercado', 'actualizado_en', 'creado_en'], 'safe'],
            [['monto_adjudicado', 'monto_ejecutado', 'prestamo', 'monto_estimado'], 'number'],
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
        $query = Adquisicion::find();

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
            'adquisicion_id' => $this->adquisicion_id,
            'flujo_requerimiento_id' => $this->flujo_requerimiento_id,
            'codigo_referencia' => $this->codigo_referencia,
            'referencia_actividad' => $this->referencia_actividad,
            'monto_adjudicado' => $this->monto_adjudicado,
            'monto_ejecutado' => $this->monto_ejecutado,
            'prestamo' => $this->prestamo,
            'tipo_revision' => $this->tipo_revision,
            'categoria' => $this->categoria,
            'monto_estimado' => $this->monto_estimado,
            'estado_proceso' => $this->estado_proceso,
            'estado_actividad' => $this->estado_actividad,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $persona_id = Yii::$app->user->identity->persona_id;
        $objeto_usuario = Usuario::find()->where(['persona_id'=>$persona_id])->one();
        $query->andFilterWhere(['like', 'nombre_firma', $this->nombre_firma])
            ->andFilterWhere(['like', 'componente', $this->componente])
            ->andFilterWhere(['like', 'enfoque_mercado', $this->enfoque_mercado])
            ->andFilterWhere(['=', 'creado_por', $objeto_usuario->usuario_id]);

        return $dataProvider;
    }


  
}
