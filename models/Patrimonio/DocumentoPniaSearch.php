<?php

namespace app\models\Patrimonio;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Patrimonio\DocumentoPnia;
use app\models\Viatico\FlujoRequerimiento;
use app\models\Viatico\FlujoPaso;
use yii\data\SqlDataProvider;
/**
 * DocumentoPniaSearch represents the model behind the search form about `app\models\Patrimonio\DocumentoPnia`.
 */
class DocumentoPniaSearch extends DocumentoPnia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['documento_pnia_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['ruta_documento', 'nombre_documento', 'documento_mimetype', 'documento_charset', 'documento_lastupd', 'actualizado_en', 'creado_en', 'flujo_requerimiento_id'], 'safe'],
        ];
    }

    // public function rules()
    // {
    //     return [
    //         [['flujo_requerimiento_id', 'emisor_persona_id', 'codigo_flujo', 'codigo_paso', 'area_aprobadora_id', 'estado_paso', 'codigo_arbol', 'anho_arbol', 'actualizado_por', 'creado_por'], 'integer'],
    //         [['descripcion', 'fecha_instanciacion', 'actualizado_en', 'creado_en'], 'safe'],
    //         [['flujoReqDescripcion', 'codigoFlujo', 'codigoPaso','documentoPniaNombreDocumento'], 'safe']
    //     ];
    // }
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
    // public function searchReq($params)
    // {
    //     $query = DocumentoPnia::find();

    //     $query->joinWith(['flujoRequerimiento']);

    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);

    //     $this->load($params);

    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //         // $query->where('0=1');
    //         return $dataProvider;
    //     }

    //     $query->andFilterWhere([
    //         'documento_pnia_id' => $this->documento_pnia_id,
    //         'documento_lastupd' => $this->documento_lastupd,
    //         'actualizado_en' => $this->actualizado_en,
    //         'actualizado_por' => $this->actualizado_por,
    //         'creado_en' => $this->creado_en,
    //         'creado_por' => $this->creado_por,
    //     ]);

    //     $query->andFilterWhere(['like', 'ruta_documento', $this->ruta_documento])
    //         ->andFilterWhere(['like', 'nombre_documento', $this->nombre_documento])
    //         ->andFilterWhere(['like', 'documento_mimetype', $this->documento_mimetype])
    //         ->andFilterWhere(['like', 'documento_charset', $this->documento_charset]);

    //     if (isset($_SESSION['flujo_requerimiento_id'])) {
    //         //echo ($_SESSION['flujo_requerimiento_id']);
    //         //$query->andFilterWhere(['flujo_requerimiento_id' => $_SESSION['flujo_requerimiento_id']])

    //         //$query->andFilterWhere(['documento_pnia.flujo_requerimiento_id' => $_SESSION['flujo_requerimiento_id']]);
    //         $query->where(['flujo_requerimiento.codigo_requerimiento' => $_SESSION['codigo_requerimiento']]);
    //     } else {
    //         $query->andFilterWhere(['documento_pnia.flujo_requerimiento_id' => 0]);
    //     }

    //     return $dataProvider;
    // }

    public function search($params)
    {
        $query = DocumentoPnia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $id_persona = Yii::$app->user->identity->persona_id;

       if (isset($_SESSION['flujo_requerimiento_id'])){
            $db_nivel = Yii::$app->db;
            $sql_nivel = 'SELECT * FROM "flujo_paso" 
                   LEFT JOIN "staff_area" ON "flujo_paso"."area_responsable_id" = "staff_area"."staff_area_id" 
                   LEFT JOIN "flujo_requerimiento" ON "flujo_requerimiento"."codigo_flujo" = "flujo_paso"."flujo" 
                   WHERE "staff_area"."responsable" = '.$id_persona.'
                   AND "flujo_requerimiento"."flujo_requerimiento_id" = '.$_SESSION['flujo_requerimiento_id'];
            $queryItems_nivel = $db_nivel->createCommand($sql_nivel)->queryAll();

            $count = Yii::$app->db->createCommand('
                SELECT COUNT(*) FROM requerimiento_documento WHERE requerimiento_documento_id=:status
            ', [':status' => $_SESSION['flujo_requerimiento_id']])->queryScalar();

            if(isset($queryItems_nivel[0])){
                $dataProvider = new SqlDataProvider([
                    'sql' => '
                    select distinct(requerimiento_documento_id), 
                    nombre_documento,
                    documento_pnia.documento_pnia_id
                    from requerimiento_documento
                    join flujo_requerimiento on flujo_requerimiento.flujo_requerimiento_id=requerimiento_documento.flujo_requerimiento_id
                    join documento_pnia on documento_pnia.documento_pnia_id=requerimiento_documento.documento_pnia_id
                    join flujo_flujo on flujo_flujo.flujo_flujo_id=flujo_requerimiento.codigo_flujo
                    join flujo_paso on flujo_paso.flujo = flujo_flujo.flujo_flujo_id
                    where flujo_requerimiento.codigo_requerimiento='.$_SESSION['codigo_requerimiento'].' and flujo_paso.nivel<='.$queryItems_nivel[0]['nivel'],
                    'totalCount' => $count,
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);
            }
       }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }
    
    public function searchContratoDocumento($params)
    {
        $query = DocumentoPnia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $id_persona = Yii::$app->user->identity->persona_id;

       if (isset($_SESSION['flujo_requerimiento_id'])){
            $db_nivel = Yii::$app->db;
            $sql_nivel = 'SELECT * FROM "flujo_paso" 
                   LEFT JOIN "staff_area" ON "flujo_paso"."area_responsable_id" = "staff_area"."staff_area_id" 
                   LEFT JOIN "flujo_requerimiento" ON "flujo_requerimiento"."codigo_flujo" = "flujo_paso"."flujo" 
                   WHERE "staff_area"."responsable" = '.$id_persona.'
                   AND "flujo_requerimiento"."flujo_requerimiento_id" = '.$_SESSION['flujo_requerimiento_id'];
            $queryItems_nivel = $db_nivel->createCommand($sql_nivel)->queryAll();

            if (isset($_SESSION['codigo_interno_contrato'])){
                $count = Yii::$app->db->createCommand('
                SELECT COUNT(*) FROM contrato_documento WHERE contrato_id=:status
                ', [':status' =>$_SESSION['codigo_interno_contrato']])->queryScalar();
                
                if(isset($queryItems_nivel[0])){
                    $dataProvider = new SqlDataProvider([
                        'sql' => '
                        select distinct(contrato_documento_id), 
                        nombre_documento,
                        documento_pnia.documento_pnia_id
                        from contrato_documento
                        join contrato_contrato on contrato_contrato.contrato_contrato_id=contrato_documento.contrato_id
                        join documento_pnia on documento_pnia.documento_pnia_id=contrato_documento.documento_pnia_id
                        where contrato_contrato.contrato_contrato_id='.$_SESSION['codigo_interno_contrato'].' ',
                        'totalCount' => $count,
                        'pagination' => [
                            'pageSize' => 20,
                        ],
                    ]);
                }
            }
            

            
       }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }
    
    public function searchPatrimonioItem($params)
    {
        $query = DocumentoPnia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $id_persona = Yii::$app->user->identity->persona_id;

       if (isset($_SESSION['patrimonio_item_id'])){
                $count = Yii::$app->db->createCommand('
                SELECT COUNT(*) FROM contrato_documento WHERE patrimonio_item_id=:status
                ', [':status' =>$_SESSION['patrimonio_item_id']])->queryScalar();
                
            $dataProvider = new SqlDataProvider([
                'sql' => '
                select distinct(contrato_documento_id), 
                nombre_documento,
                documento_pnia.documento_pnia_id
                from contrato_documento
                join patrimonio_item on patrimonio_item.patrimonio_item_id=contrato_documento.patrimonio_item_id
                join documento_pnia on documento_pnia.documento_pnia_id=contrato_documento.documento_pnia_id
                where patrimonio_item.patrimonio_item_id='.$_SESSION['patrimonio_item_id'].' ',
                'totalCount' => $count,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
                
        }   
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }
    
    public function searchPatrimonioInventario($params)
    {
        $query = DocumentoPnia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $id_persona = Yii::$app->user->identity->persona_id;

       if (isset($_SESSION['patrimonio_inventario_id'])){
                $count = Yii::$app->db->createCommand('
                SELECT COUNT(*) FROM contrato_documento WHERE patrimonio_item_id=:status
                ', [':status' =>$_SESSION['patrimonio_inventario_id']])->queryScalar();
                
            $dataProvider = new SqlDataProvider([
                'sql' => '
                select distinct(contrato_documento_id), 
                nombre_documento,
                documento_pnia.documento_pnia_id
                from contrato_documento
                join patrimonio_inventario on patrimonio_inventario.patrimonio_inventario_id=contrato_documento.patrimonio_inventario_id
                join documento_pnia on documento_pnia.documento_pnia_id=contrato_documento.documento_pnia_id
                where patrimonio_inventario.patrimonio_inventario_id='.$_SESSION['patrimonio_inventario_id'].' ',
                'totalCount' => $count,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
                
        }   
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }
}
