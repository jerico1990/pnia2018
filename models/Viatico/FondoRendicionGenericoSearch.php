<?php

namespace app\models\Viatico;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viatico\FondoRendicionGenerico;

/**
 * FondoRendicionGenericoSearch represents the model behind the search form about `app\models\Viatico\FondoRendicionGenerico`.
 */
class FondoRendicionGenericoSearch extends FondoRendicionGenerico
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fondo_rendicion_generico_id', 'fondo_rendicion_viatico_id', 'fondo_rendicion_caja_chica_id', 'fondo_rendicion_encargo_id', 'tipo_afecto_igv_metacodigo', 'tipo_bien_servicio_metacodigo', 'tipo_documento_metacodigo', 'proveedor_pnia_entidad_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['importe', 'importe_gravado', 'importe_no_gravado'], 'number'],
            [['serie_numero', 'ruc', 'detalle_gasto', 'fecha_documento', 'actualizado_en', 'creado_en'], 'safe'],
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
        $query = FondoRendicionGenerico::find();

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
            'fondo_rendicion_generico_id' => $this->fondo_rendicion_generico_id,
            'fondo_rendicion_viatico_id' => $this->fondo_rendicion_viatico_id,
            'fondo_rendicion_caja_chica_id' => $this->fondo_rendicion_caja_chica_id,
            'fondo_rendicion_encargo_id' => $this->fondo_rendicion_encargo_id,
            'tipo_afecto_igv_metacodigo' => $this->tipo_afecto_igv_metacodigo,
            'tipo_bien_servicio_metacodigo' => $this->tipo_bien_servicio_metacodigo,
            'tipo_documento_metacodigo' => $this->tipo_documento_metacodigo,
            'proveedor_pnia_entidad_id' => $this->proveedor_pnia_entidad_id,
            'importe' => $this->importe,
            'importe_gravado' => $this->importe_gravado,
            'importe_no_gravado' => $this->importe_no_gravado,
            'fecha_documento' => $this->fecha_documento,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'serie_numero', $this->serie_numero])
            ->andFilterWhere(['like', 'ruc', $this->ruc])
            ->andFilterWhere(['like', 'detalle_gasto', $this->detalle_gasto]);

        return $dataProvider;
    }
    
    public function searchRendicionCajaChica($params)
    {
        $query = FondoRendicionGenerico::find();

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
            'fondo_rendicion_generico_id' => $this->fondo_rendicion_generico_id,
            'fondo_rendicion_viatico_id' => $this->fondo_rendicion_viatico_id,
            'fondo_rendicion_caja_chica_id' => $this->fondo_rendicion_caja_chica_id,
            'fondo_rendicion_encargo_id' => $this->fondo_rendicion_encargo_id,
            'tipo_afecto_igv_metacodigo' => $this->tipo_afecto_igv_metacodigo,
            'tipo_bien_servicio_metacodigo' => $this->tipo_bien_servicio_metacodigo,
            'tipo_documento_metacodigo' => $this->tipo_documento_metacodigo,
            'proveedor_pnia_entidad_id' => $this->proveedor_pnia_entidad_id,
            'importe' => $this->importe,
            'importe_gravado' => $this->importe_gravado,
            'importe_no_gravado' => $this->importe_no_gravado,
            'fecha_documento' => $this->fecha_documento,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'serie_numero', $this->serie_numero])
            ->andFilterWhere(['like', 'ruc', $this->ruc])
            ->andFilterWhere(['like', 'detalle_gasto', $this->detalle_gasto]);
        
        $query->andWhere(['not', ['fondo_rendicion_caja_chica_id' => null]]);
        if (isset($_SESSION['fondo_rendicion_caja_chica_id'])){
            $query->andFilterWhere(['=', 'fondo_rendicion_caja_chica_id', $_SESSION['fondo_rendicion_caja_chica_id']]);
        }

        return $dataProvider;
    }
    
    public function searchRendicionViatico($params)
    {
        $query = FondoRendicionGenerico::find();

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
            'fondo_rendicion_generico_id' => $this->fondo_rendicion_generico_id,
            'fondo_rendicion_viatico_id' => $this->fondo_rendicion_viatico_id,
            'fondo_rendicion_caja_chica_id' => $this->fondo_rendicion_caja_chica_id,
            'fondo_rendicion_encargo_id' => $this->fondo_rendicion_encargo_id,
            'tipo_afecto_igv_metacodigo' => $this->tipo_afecto_igv_metacodigo,
            'tipo_bien_servicio_metacodigo' => $this->tipo_bien_servicio_metacodigo,
            'tipo_documento_metacodigo' => $this->tipo_documento_metacodigo,
            'proveedor_pnia_entidad_id' => $this->proveedor_pnia_entidad_id,
            'importe' => $this->importe,
            'importe_gravado' => $this->importe_gravado,
            'importe_no_gravado' => $this->importe_no_gravado,
            'fecha_documento' => $this->fecha_documento,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'serie_numero', $this->serie_numero])
            ->andFilterWhere(['like', 'ruc', $this->ruc])
            ->andFilterWhere(['like', 'detalle_gasto', $this->detalle_gasto]);
        
        $query->andWhere(['not', ['fondo_rendicion_viatico_id' => null]]);
        if (isset($_SESSION['fondo_rendicion_viatico_id'])){
            $query->andFilterWhere(['=', 'fondo_rendicion_viatico_id', $_SESSION['fondo_rendicion_viatico_id']]);
        }

        return $dataProvider;
    }
    
    public function searchRendicionEntrega($params)
    {
        $query = FondoRendicionGenerico::find();

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
            'fondo_rendicion_generico_id' => $this->fondo_rendicion_generico_id,
            'fondo_rendicion_viatico_id' => $this->fondo_rendicion_viatico_id,
            'fondo_rendicion_caja_chica_id' => $this->fondo_rendicion_caja_chica_id,
            'fondo_rendicion_encargo_id' => $this->fondo_rendicion_encargo_id,
            'tipo_afecto_igv_metacodigo' => $this->tipo_afecto_igv_metacodigo,
            'tipo_bien_servicio_metacodigo' => $this->tipo_bien_servicio_metacodigo,
            'tipo_documento_metacodigo' => $this->tipo_documento_metacodigo,
            'proveedor_pnia_entidad_id' => $this->proveedor_pnia_entidad_id,
            'importe' => $this->importe,
            'importe_gravado' => $this->importe_gravado,
            'importe_no_gravado' => $this->importe_no_gravado,
            'fecha_documento' => $this->fecha_documento,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'serie_numero', $this->serie_numero])
            ->andFilterWhere(['like', 'ruc', $this->ruc])
            ->andFilterWhere(['like', 'detalle_gasto', $this->detalle_gasto]);
        
        $query->andWhere(['not', ['fondo_rendicion_encargo_id' => null]]);
        if (isset($_SESSION['fondo_rendicion_encargo_id'])){
            $query->andFilterWhere(['=', 'fondo_rendicion_encargo_id', $_SESSION['fondo_rendicion_encargo_id']]);
        }

        return $dataProvider;
    }
}
