<?php

namespace app\models\Patrimonio;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Patrimonio\PatrimonioInventario;

/**
 * PatrimonioInventarioSearch represents the model behind the search form about `app\models\Patrimonio\PatrimonioInventario`.
 */
class PatrimonioInventarioSearch extends PatrimonioInventario
{
    /**
     * @inheritdoc
     */
    
    public $patrimonioItemDescripcion;
    public $patrimonioItemCodigo;
    public $ubicacionDescripcion;
    public $condicionDescripcion;
    public $estadoDescripcion;
    public $documentoPniaNombreDocumento;
            
    public function rules()
    {     
        return [
            [['patrimonio_inventario_id', 'patrimonio_item_id', 'metacodigo_condicion_id', 'metacodigo_estado_id', 'documento_pnia_id', 'ubicacion_id', 'persona_aut', 'persona_inv', 'actualizado_por', 'creado_por'], 'integer'],
            [['fecha_inventario', 'actualizado_en', 'creado_en'], 'safe'],
            //[['patrimonioItem'], 'string'],
            [['patrimonioItemDescripcion', 'patrimonioItemCodigo', 'ubicacionDescripcion', 'condicionDescripcion', 'estadoDescripcion', 'documentoPniaNombreDocumento'], 'safe'],
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
        $query = PatrimonioInventario::find();
        
        //agregado para search de item, son los nombres de las relaciones hasOne, hasMany en el modelo
        $query->joinWith(['patrimonioItem'])->joinWith(['ubicacion'])
                ->joinWith(['documentoPnia'])
                ->joinWith(['metacodigoCondicion','metacodigoEstado']);
 
        
       // JOIN_TYPE = INNER JOIN, LEFT OUTER JOIN, RIGHT OUTER JOIN, FULL OUTER JOIN etc
//        $query	->select([
//            'patrimonio_item.descripcion', 
//            'ubicacion.nombre', 
//            'metacodigo.descripcion', 
//            'documento_pnia.nombre_documento']
//                )  
//                ->from('patrimonio_item, ubicacion, metacodigo, documento_pnia')
//                ->join('LEFT OUTER JOIN', 'patrimonio_item',
//                    'patrimonio_item.patrimonio_item_id =patrimonio_inventario.patrimonio_item_id')		
//                ->join('LEFT OUTER JOIN', 'ubicacion', 
//                    'ubicacion.ubicacion_id =patrimonio_inventario.ubicacion_id')
//                ->join('LEFT OUTER JOIN', 'metacodigo', 
//                    'metacodigo.metacodigo_id = patrimonio_inventario.metacodigo_estado_id')
//                ->join('LEFT OUTER JOIN', 'metacodigo', 
//                    'metacodigo.metacodigo_id = patrimonio_inventario.metacodigo_condicion_id')
//                ->join('LEFT OUTER JOIN', 'documento_pnia', 
//                    'documento_pnia.documento_pnia_id = patrimonio_inventario.documento_pnia_id');
        
                //->LIMIT(5)	; 
//        $command = $query->createCommand();
//        $data = $command->queryAll();       
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        // Important: here is how we set up the sorting
        // The key is the attribute name on our "TourSearch" instance
        $dataProvider->sort->attributes['patrimonioItemDescripcion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['patrimonio_item.descripcion' => SORT_ASC],
            'desc' => ['patrimonio_item.descripcion' => SORT_DESC],
        ];
        
         $dataProvider->sort->attributes['patrimonioItemCodigo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['patrimonio_item.codigo' => SORT_ASC],
            'desc' => ['patrimonio_item.codigo' => SORT_DESC],
        ];
         $dataProvider->sort->attributes['ubicacionDescripcion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['ubicacion.nombre' => SORT_ASC],
            'desc' => ['ubicacion.nombre' => SORT_DESC],
        ];
         $dataProvider->sort->attributes['condicionDescripcion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['condicion.descripcion' => SORT_ASC],
            'desc' => ['condicion.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['estadoDescripcion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['estado.descripcion' => SORT_ASC],
            'desc' => ['estado.descripcion' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['documentoPniaNombreDocumento'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['documento_pnia.nombre_documento' => SORT_ASC],
            'desc' => ['documento_pnia.nombre_documento' => SORT_DESC],
        ];
         
//    public $ubicacionDescripcion;
//    public $condicionDescripcion;
//    public $estadoDescripcion;
//    public $documentoPniaNombreDocumento;

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'patrimonio_inventario_id' => $this->patrimonio_inventario_id,
            'patrimonio_item_id' => $this->patrimonio_item_id,
            'metacodigo_condicion_id' => $this->metacodigo_condicion_id,
            'metacodigo_estado_id' => $this->metacodigo_estado_id,
            'documento_pnia_id' => $this->documento_pnia_id,
            'ubicacion_id' => $this->ubicacion_id,
            'persona_aut' => $this->persona_aut,
            'persona_inv' => $this->persona_inv,
            'fecha_inventario' => $this->fecha_inventario,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
            //'patrimonio_item.descripcion' => $this->patrimonioItem,
        ]);
        $query->andFilterWhere(['like', 'patrimonio_item.descripcion', $this->patrimonioItemDescripcion]);
        $query->andFilterWhere(['like', 'patrimonio_item.codigo', $this->patrimonioItemCodigo]);
        $query->andFilterWhere(['like', 'ubicacion.descripcion', $this->ubicacionDescripcion]);
        $query->andFilterWhere(['like', 'condicion.descripcion', $this->condicionDescripcion]);
        $query->andFilterWhere(['like', 'estado.descripcion', $this->estadoDescripcion]);
        $query->andFilterWhere(['like', 'documento_pnia.nombre_documento', $this->documentoPniaNombreDocumento]);
        
        

        return $dataProvider;
    }
}
