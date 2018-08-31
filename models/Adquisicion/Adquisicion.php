<?php

namespace app\models\Adquisicion;
use app\models\Patrimonio\Metacodigo;
use app\models\Auditoria\Usuario;
use app\models\rrhh\ContratoContrato;
use app\models\Viatico\FlujoRequerimiento;
use \yii\helpers\ArrayHelper;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "adquisicion".
 *
 * @property int $adquisicion_id
 * @property int $flujo_requerimiento_id
 * @property int $contrato_contrato_id
 * @property int $codigo_referencia
 * @property int $referencia_actividad
 * @property string $nombre_firma
 * @property double $monto_adjudicado
 * @property double $monto_ejecutado
 * @property double $prestamo
 * @property string $componente
 * @property int $tipo_revision
 * @property int $categoria
 * @property string $enfoque_mercado
 * @property double $monto_estimado
 * @property int $estado_proceso
 * @property int $estado_actividad
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ContratoContrato $contratoContrato
 * @property FlujoRequerimiento $flujoRequerimiento
 * @property Metacodigo $tipoRevision
 * @property Metacodigo $categoria0
 * @property Metacodigo $estadoProceso
 * @property Metacodigo $estadoActividad
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class Adquisicion extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adquisicion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['flujo_requerimiento_id', 'tipo_revision', 'categoria', 'estado_proceso', 'estado_actividad'], 'required'],
            // [['flujo_requerimiento_id', 'codigo_referencia', 'referencia_actividad', 'tipo_revision', 'categoria', 'estado_proceso', 'estado_actividad', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['flujo_requerimiento_id', 'codigo_referencia', 'tipo_revision', 'categoria', 'estado_proceso', 'estado_actividad', 'actualizado_por', 'creado_por','componente'], 'integer'],
            [['monto_adjudicado', 'monto_ejecutado', 'prestamo', 'monto_estimado'], 'number'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['referencia_actividad'], 'string'],
            [['nombre_firma', 'enfoque_mercado'], 'string', 'max' => 255],
            [['flujo_requerimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => FlujoRequerimiento::className(), 'targetAttribute' => ['flujo_requerimiento_id' => 'flujo_requerimiento_id']],
            [['tipo_revision'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['tipo_revision' => 'metacodigo_id']],
            [['categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['categoria' => 'metacodigo_id']],
            [['estado_proceso'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['estado_proceso' => 'metacodigo_id']],
            [['estado_actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['estado_actividad' => 'metacodigo_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            // ['monto_estimado','validarMontoAdquisicion']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'adquisicion_id' => 'Adquisicion ID',
            'flujo_requerimiento_id' => 'Requerimiento relacionado',
            'codigo_referencia' => 'Codigo de referencia',
            'referencia_actividad' => 'Referencia actividad',
            'nombre_firma' => 'Nombre Firma',
            'monto_adjudicado' => 'Monto adjudicado',
            'monto_ejecutado' => 'Monto ejecutado',
            'prestamo' => 'Préstamo',
            'componente' => 'Componente',
            'tipo_revision' => 'Tipo de revisión',
            'categoria' => 'Categoría',
            'enfoque_mercado' => 'Enfoque mercado',
            'monto_estimado' => 'Monto estimado',
            'estado_proceso' => 'Estado proceso',
            'estado_actividad' => 'Estado de actividad',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }  

    static function montoEstimado($flujo_requerimiento_id){
        $objeto_flujo_requerimiento = FlujoRequerimiento::find()->where(['flujo_requerimiento_id'=>$flujo_requerimiento_id])->one();
        if($objeto_flujo_requerimiento->monto>=0)
            return $objeto_flujo_requerimiento->monto;
        else
            return -1;
    }

    

    public function validarMontoAdquisicion(){
        // $this->addError('monto_estimado','...');
    }

    public function getComboBoxItemsParaContrato(){
        $persona_id = Yii::$app->user->identity->persona_id;
        $objeto_metacodigo = new Metacodigo();
        $objeto_metacodigo = $objeto_metacodigo->find()->where(['nombre_lista'=>'Estado_paso','descripcion'=>'Contrato'])->one();

        $objeto_adquisicion = new Adquisicion();
        $array_adquisicion = $objeto_adquisicion->find()
            ->join( 'INNER JOIN','flujo_requerimiento','flujo_requerimiento.flujo_requerimiento_id = adquisicion.flujo_requerimiento_id')  
            ->join( 'INNER JOIN','flujo_paso','flujo_paso.flujo_paso_id = flujo_requerimiento.codigo_paso') 
            ->join( 'INNER JOIN','staff_area','staff_area.staff_area_id = flujo_paso.area_responsable_id') 
            ->andFilterWhere(['=', 'adquisicion.estado_proceso', $objeto_metacodigo->metacodigo_id])
            ->andFilterWhere(['!=', 'flujo_requerimiento.flag_procesado', '1'])
            ->andFilterWhere(['=', 'staff_area.responsable', $persona_id])
            ->andFilterWhere(['=', 'adquisicion.ticket', false])
            ->select(['adquisicion.adquisicion_id','adquisicion.codigo_referencia']) 
            ->all();

        return ArrayHelper::map($array_adquisicion, 'adquisicion_id', 'codigo_referencia');
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlujoRequerimiento()
    {
        return $this->hasOne(FlujoRequerimiento::className(), ['flujo_requerimiento_id' => 'flujo_requerimiento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoRevision()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'tipo_revision']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria0()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoProceso()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'estado_proceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoActividad()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'estado_actividad']);
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

    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
             if(!Yii::$app->user->isGuest)
             {
                 $this->actualizado_por= Yii::$app->user->identity->usuario_id;
             }
             else
             {
                 return false;
             }
            $this->actualizado_en = date('Y-m-d H:i:s');
            if ($this->isNewRecord) {
                $this->creado_por = Yii::$app->user->identity->usuario_id;
                $this->creado_en = date('Y-m-d H:i:s');

                
                $objeto_flujo_requerimiento = FlujoRequerimiento::find()->where(['flujo_requerimiento_id' => $this->flujo_requerimiento_id])->one();
                if($objeto_flujo_requerimiento->ticket!=true){
                    $objeto_flujo_requerimiento->ticket = true;
                    $this->prestamo=$objeto_flujo_requerimiento->ro_rooc;
                    $objeto_flujo_requerimiento->save();
                }
            }
            $objeto_flujo_requerimiento = FlujoRequerimiento::find()->where(['flujo_requerimiento_id'=>$this->flujo_requerimiento_id])->one();
            $this->estado_proceso = $objeto_flujo_requerimiento->estado_paso;
            return true;
        }
        return false;
    }
}
