<?php

namespace app\models\Viatico;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\rrhh\StaffArea;
use \yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "flujo_flujo".
 *
 * @property int $flujo_flujo_id
 * @property string $nombre_flujo
 * @property int $tipo_flujo_metacodigo
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Metacodigo $tipoFlujoMetacodigo
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property FlujoPaso[] $flujoPasos
 * @property FlujoRequerimiento[] $flujoRequerimientos
 */
class FlujoFlujo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'flujo_flujo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_flujo_metacodigo', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['tipo_flujo_metacodigo', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            // [['actualizado_por', 'creado_por'], 'required'],
            [['nombre_flujo'], 'string', 'max' => 255],
            [['tipo_flujo_metacodigo'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['tipo_flujo_metacodigo' => 'metacodigo_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'flujo_flujo_id' => 'Flujo Flujo ID',
            'nombre_flujo' => 'Nombre Flujo',
            'tipo_flujo_metacodigo' => 'Tipo flujo',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    static function getComboBoxItemsRequerimientos(){
        $persona_id = Yii::$app->user->identity->persona_id;
        $objeto_metacodigo_adquisicion = Metacodigo::find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Adquisición'])->one();
        $objeto_metacodigo_tramite_documentario = Metacodigo::find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Trámite Documentario'])->one();

        $items  = FlujoFlujo::find()
            ->join( 'LEFT JOIN','flujo_paso','flujo_paso.flujo = flujo_flujo.flujo_flujo_id') 
            ->join( 'LEFT JOIN','staff_area','staff_area.staff_area_id = flujo_paso.area_responsable_id') 
            ->andWhere([ 
                'or',
                ['staff_area.responsable' => $persona_id], ['flujo_paso.area_responsable_id' => null]
            ])
//            ->andFilterWhere(['=', 'staff_area.responsable' , $persona_id])
            ->andFilterWhere(['!=', 'tipo_flujo_metacodigo' , $objeto_metacodigo_adquisicion->metacodigo_id])
            ->andFilterWhere(['!=', 'tipo_flujo_metacodigo' , $objeto_metacodigo_tramite_documentario->metacodigo_id])
            ->andFilterWhere(['=', 'flujo_paso.nivel' , 1])
            ->all();
        return ArrayHelper::map($items, 'flujo_flujo_id', 'nombre_flujo');
    }

    static function getComboBoxItemsAdquisicion(){
        $persona_id = Yii::$app->user->identity->persona_id;
        $objeto_metacodigo = Metacodigo::find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Adquisición'])
            ->one();

        $items  = FlujoFlujo::find()
            ->join( 'LEFT JOIN','flujo_paso','flujo_paso.flujo = flujo_flujo.flujo_flujo_id') 
            ->join( 'LEFT JOIN','staff_area','staff_area.staff_area_id = flujo_paso.area_responsable_id') 
//            ->andFilterWhere(['=', 'staff_area.responsable' , $persona_id])
            ->andWhere([ 
            'or',
                ['staff_area.responsable' => $persona_id], ['flujo_paso.area_responsable_id' => null]
            ])
            ->andFilterWhere(['=', 'tipo_flujo_metacodigo' , $objeto_metacodigo->metacodigo_id])
            ->andFilterWhere(['=', 'flujo_paso.nivel' , 1])
            ->all();
        return ArrayHelper::map($items, 'flujo_flujo_id', 'nombre_flujo');
    }

    static function getComboBoxItemsTramiteDocumentario(){
        $persona_id = Yii::$app->user->identity->persona_id;
        $objeto_metacodigo = Metacodigo::find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Trámite Documentario'])
            ->one();

        $items  = FlujoFlujo::find()
            ->join( 'LEFT JOIN','flujo_paso','flujo_paso.flujo = flujo_flujo.flujo_flujo_id') 
            ->join( 'LEFT JOIN','staff_area','staff_area.staff_area_id = flujo_paso.area_responsable_id') 
            //->andFilterWhere(['=', 'staff_area.responsable' , $persona_id])
            ->andWhere([ 
                'or',
                    ['staff_area.responsable' => $persona_id], ['flujo_paso.area_responsable_id' => null]
            ])
            ->andFilterWhere(['=', 'tipo_flujo_metacodigo' , $objeto_metacodigo->metacodigo_id])
            ->andFilterWhere(['=', 'flujo_paso.nivel' , 1])
            ->all();
        return ArrayHelper::map($items, 'flujo_flujo_id', 'nombre_flujo');
    }

    public function getPrimerPaso(){
        $objeto_flujo_paso = FlujoPaso::find()->where(['flujo'=>$this->flujo_flujo_id])->one();
        $objeto_primer_flujo_paso = $objeto_flujo_paso->findById($objeto_flujo_paso->primer_flujo_paso);
        return $objeto_primer_flujo_paso;
    }
    
    /**
     * [getComboBoxItems retorna los items de un comboBox basandose en el tipo de flujo(metacodigo) requerido]
     * @param  integer $tipo_flujo [viático : 1, rendición: 2,caja chica: 3,otherwise: (vacio)]
     * @return [array('flujo_flujo_id' => 'nombre_flujo')]              [Array de data para un ComboBox]
     */
    static function getComboBoxItems($tipo_flujo = 0){
        
        switch ($tipo_flujo) {
            case 1:
                $metacodigo_descripcion = Yii::$app->params['tipoFlujo']['tipo_viatico'];
                break;
            case 2:
                $metacodigo_descripcion = Yii::$app->params['tipoFlujo']['tipo_rendicion'];
                break;
            case 3:
                $metacodigo_descripcion = Yii::$app->params['tipoFlujo']['tipo_caja_chica'];
                break;
            default:
                $items  = FlujoFlujo::find()->all();
                return ArrayHelper::map($items, 'flujo_flujo_id', 'nombre_flujo');
        }

        $metacodigoAsinado = Metacodigo::find()->where([
            'nombre_lista' => Yii::$app->params['metacodigoFlags']['Tipo_flujo'],
            'descripcion'  => $metacodigo_descripcion
        ])->one();

        $items  = FlujoFlujo::find()->where([
            'tipo_flujo_metacodigo' => $metacodigoAsinado->metacodigo_id
            ])->all();
        return ArrayHelper::map($items, 'flujo_flujo_id', 'nombre_flujo');
    }
    
    static function getComboBoxItems1(){
        
        $items  = FlujoFlujo::find()->where([
            'nombre_flujo' => 'Trámite Documentario'
            ])->all();
        return ArrayHelper::map($items, 'flujo_flujo_id', 'nombre_flujo');
    }

    public function getFlujos() 
    {  
        return static::find()->orderBy(['nombre_flujo' => SORT_ASC])->all();
    }

    static function getComboBoxItemsProcesos(){
        $objeto_metacodigo = new Metacodigo();
        $filtro_tramite_documentario = $objeto_metacodigo->find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Trámite Documentario'])->one();
        $filtro_adquisicion = $objeto_metacodigo->find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Adquisición'])->one();
        

        $items  = FlujoFlujo::find()
            // ->andFilterWhere(['!=', 'tipo_flujo_metacodigo', $filtro_tramite_documentario->metacodigo_id])
            // ->andFilterWhere(['!=', 'tipo_flujo_metacodigo', $filtro_adquisicion->metacodigo_id])
            ->all();
        return ArrayHelper::map($items, 'flujo_flujo_id', 'nombre_flujo');
    }

    public static function findById($id){
        return static::findOne(['flujo_flujo_id' => $id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoFlujoMetacodigo()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'tipo_flujo_metacodigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor()
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'actualizado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor()
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlujoPasos()
    {
        return $this->hasMany(FlujoPaso::className(), ['flujo' => 'flujo_flujo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlujoRequerimientos()
    {
        return $this->hasMany(FlujoRequerimiento::className(), ['codigo_flujo' => 'flujo_flujo_id']);
    }

    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
             if(!Yii::$app->user->isGuest)
             {
                if ($this->isNewRecord) {
                    $this->creado_por = Yii::$app->user->identity->usuario_id;
                    $this->creado_en = date('Y-m-d H:i:s');
                    // $fecha_primera_valorizacion = date('Y-m-d H:i:s');
                    // $this->valorizar($fecha_primera_valorizacion);
                }
                $this->actualizado_por= Yii::$app->user->identity->usuario_id;
                $this->actualizado_en = date('Y-m-d H:i:s');

                return true;
             } else {
                return false;
             }
        }
        return false;
    }

    public static function getFlujoPorTipoMetacodigo($metacodigo_id){
        return static::find()->where(['tipo_flujo_metacodigo' => $metacodigo_id])->all();
    }
    
}
