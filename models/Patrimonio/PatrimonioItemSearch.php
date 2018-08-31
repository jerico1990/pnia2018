<?php

namespace app\models\Patrimonio;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Patrimonio\PatrimonioItem;

/**
 * PatrimonioItemSearch represents the model behind the search form about `app\models\Patrimonio\PatrimonioItem`.
 */
class PatrimonioItemSearch extends PatrimonioItem
{
    /**
     * @inheritdoc
     */
    public $metacodigoDescripcion;
    public $patrimonioClaseDescripcion;
    public $documentoPniaNombreDocumento;
    public $itemDescripcion;
    public $itemCodigo;

    public function rules()
    {
        return [
            [['patrimonio_item_id', 'patrimonio_clase_id', 'metacodigo_id', 'documento_pnia_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['codigo', 'descripcion', 'fecha_alta', 'fecha_baja', 'marca', 'modelo', 'serie', 'actualizado_en', 'creado_en'], 'safe'],
            [['valor_historico'], 'number'],
            [['metacodigoDescripcion', 'patrimonioClaseDescripcion', 'documentoPniaNombreDocumento', 'itemDescripcion', 'itemCodigo'], 'safe'],
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
        $query = PatrimonioItem::find();
        
        $query->joinWith(['patrimonioClase', 'metacodigo', 'documentoPnia']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['metacodigoDescripcion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['metacodigo.descripcion' => SORT_ASC],
            'desc' => ['metacodigo.descripcion' => SORT_DESC],
        ];
        
         $dataProvider->sort->attributes['patrimonioClaseDescripcion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['patrimonio_clase.nombre' => SORT_ASC],
            'desc' => ['patrimonio_clase.nombre' => SORT_DESC],
        ];
         $dataProvider->sort->attributes['documentoPniaNombreDocumento'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['documento_pnia.nombre_documento' => SORT_ASC],
            'desc' => ['documento_pnia.nombre_documento' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['itemDescripcion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['patrimonio_item.descripcion' => SORT_ASC],
            'desc' => ['patrimonio_item.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['itemCodigo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['patrimonio_item.codigo' => SORT_ASC],
            'desc' => ['patrimonio_item.codigo' => SORT_DESC],
        ];
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'patrimonio_item_id' => $this->patrimonio_item_id,
            'patrimonio_clase_id' => $this->patrimonio_clase_id,
            'metacodigo_id' => $this->metacodigo_id,
            'documento_pnia_id' => $this->documento_pnia_id,
            'fecha_alta' => $this->fecha_alta,
            'fecha_baja' => $this->fecha_baja,
            'valor_historico' => $this->valor_historico,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'modelo', $this->modelo])
            ->andFilterWhere(['like', 'serie', $this->serie]);
        $query->andFilterWhere(['like', 'patrimonio_clase.nombre', $this->patrimonioClaseDescripcion]);
        $query->andFilterWhere(['like', 'metacodigo.descripcion', $this->metacodigoDescripcion]);
        $query->andFilterWhere(['like', 'documento_pnia.nombre_documento', $this->documentoPniaNombreDocumento]);
        $query->andFilterWhere(['like', 'patrimonio_item.descripcion', $this->itemDescripcion]);
        $query->andFilterWhere(['like', 'patrimonio_item.codigo', $this->itemCodigo]);

        return $dataProvider;
    }
}
