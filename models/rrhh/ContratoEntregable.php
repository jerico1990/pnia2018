<?php

namespace app\models\rrhh;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\ModeloGenerico;
use app\models\Presupuesto\PresupuestoCabecera;
use app\models\Presupuesto\Periodo;
use app\models\Viatico\FlujoRequerimiento;
use app\models\Adquisicion\Adquisicion;
use Yii;

/**
 * This is the model class for table "contrato_entregable".
 *
 * @property int $contrato_entregable_id
 * @property int $codigo_contrato
 * @property string $descripcion
 * @property int $estado
 * @property double $monto
 * @property string $fecha
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ContratoContrato $codigoContrato
 * @property Metacodigo $estado0
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 */
class ContratoEntregable extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contrato_entregable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_contrato', 'estado', 'actualizado_por', 'creado_por'], 'integer'],
            [['descripcion'], 'string'],
            [['monto'], 'number'],
            [['fecha', 'actualizado_en', 'creado_en'], 'safe'],
            ['monto','validarMontoEntregable'],
            [['porcentaje'], 'validarPorcentaje'],
            //[['actualizado_por', 'creado_por'], 'required'],
            [['codigo_contrato'], 'exist', 'skipOnError' => true, 'targetClass' => ContratoContrato::className(), 'targetAttribute' => ['codigo_contrato' => 'contrato_contrato_id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['estado' => 'metacodigo_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['staff_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffArea::className(), 'targetAttribute' => ['staff_area_id' => 'staff_area_id']],
            [['periodo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Periodo::className(), 'targetAttribute' => ['periodo_id' => 'periodo_id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contrato_entregable_id' => Yii::t('app', 'Contrato Entregable ID'),
            'codigo_contrato' => Yii::t('app', 'Código Contrato'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'estado' => Yii::t('app', 'Estado'),
            'monto' => Yii::t('app', 'Monto'),
            'fecha' => Yii::t('app', 'Fecha'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'codigo_arbol' => 'Rama presupuesto',
            'periodo_id' => 'Periodo',
            'staff_area_id' => 'Área aprobadora',
            'periodo_id' => 'Periodo',
            'flag_conformidad' => 'Conformidad'
            
        ];
    }
    
    public function validarPorcentaje(){
        $objeto_contrato_contrato = new ContratoContrato();
        $objeto_contrato_contrato = $objeto_contrato_contrato->find()->where(['contrato_contrato_id'=>$this->codigo_contrato])->one();
        $monto_total = $objeto_contrato_contrato->monto; //monto total del contrato padre
        
        $total_todos_los_entregables = 0;
        $objeto_contrato_entregable = new ContratoEntregable();
        $objeto_contrato_entregable = $objeto_contrato_entregable->find()->all();
        foreach ($objeto_contrato_entregable as $entregable){
            $total_todos_los_entregables = $total_todos_los_entregables + $entregable->monto; 
        }
        $monto_final = $monto_total - $total_todos_los_entregables;
       
        $monto_calculado = ($this->porcentaje / 100 ) * $monto_final;
        
        if ($monto_final < $monto_calculado)
        {
            $this->addError('porcentaje', 'No puede excederse del monto total actual disponible en el contrato('. $monto_final.')');
        }
        if ($monto_calculado == 0){
            $this->addError('porcentaje', 'No es posible agregar más entregables.');
        }
    }

    public function validarMontoEntregable(){       
       $objeto_contrato_contrato = ContratoContrato::find()->where(['contrato_contrato_id'=>$this->codigo_contrato])->one();
        if($objeto_contrato_contrato->adquisicion_id>0){
            $objeto_adquisicion = Adquisicion::find()->where(['adquisicion_id'=>$objeto_contrato_contrato->adquisicion_id])->one();
            $objeto_flujo_requerimiento = FlujoRequerimiento::find()->where(['flujo_requerimiento_id'=>$objeto_adquisicion->flujo_requerimiento_id])->one();
            $diferencia = $objeto_flujo_requerimiento->monto - $objeto_contrato_contrato->monto;
            if($diferencia < $this->monto)
                $this->addError('monto',"No puede solicitar más dinero de lo aprobado y utilizado en otros entregables, disponible = ".$diferencia);
        }
    }

    static function getComboBoxPeriodosDisponibles(){
        return PresupuestoCabecera::getComboBoxPeriodosDisponibles($this->codigo_arbol);
    }

    public function getTodosEntregablesContrato($codigo_contrato){
        return $this->hasMany(ContratoContrato::className(), ['codigo_interno' => 'codigo_interno']);
    }

    public function findById($id){
        return static::findOne(['contrato_entregable_id'=>$id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodo()
    {
        return $this->hasOne(Periodo::className(), ['periodo_id' => 'periodo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrayEstadoDeEntregables()
    {
        return $array_estado_de_entregables   = Metacodigo::getComboBoxItems('Estado_de_Entregable');
    }
    
    public function getCodigoContrato()
    {
        return $this->hasOne(ContratoContrato::className(), ['contrato_contrato_id' => 'codigo_contrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoEntregables()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'estado']);
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
    public function getActualizadoPor()
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'actualizado_por']);
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
                if($this->flag_conformidad==null)
                    $this->flag_conformidad=0;
//                $objeto_contrato_contrato = new ContratoContrato();
//                $objeto_contrato_contrato = $objeto_contrato_contrato->find()->where(['contrato_contrato_id'=>$this->codigo_contrato])->one();
//                $objeto_contrato_contrato->monto = $objeto_contrato_contrato->monto+$this->monto;
//                $objeto_contrato_contrato->save();
                //codigo para guardar un monto como porcentaje
                $objeto_contrato_contrato = new ContratoContrato();
                $objeto_contrato_contrato = $objeto_contrato_contrato->find()->where(['contrato_contrato_id'=>$this->codigo_contrato])->one();
                $monto_total = $objeto_contrato_contrato->monto;

                $total_todos_los_entregables = 0;
                $objeto_contrato_entregable = new ContratoEntregable();
                $objeto_contrato_entregable = $objeto_contrato_entregable->find()->all();
                foreach ($objeto_contrato_entregable as $entregable){
                    $total_todos_los_entregables = $total_todos_los_entregables + $entregable->monto; 
                }
                $monto_final = $monto_total - $total_todos_los_entregables;
                $this->monto = ($this->porcentaje / 100 ) * $monto_final;
                
                if($objeto_contrato_contrato->adquisicion_id>0){
                    $objeto_adquisicion = Adquisicion::find()->where(['adquisicion_id'=>$objeto_contrato_contrato->adquisicion_id])->one();
                    $objeto_flujo_requerimiento = FlujoRequerimiento::find()->where(['flujo_requerimiento_id'=>$objeto_adquisicion->flujo_requerimiento_id])->one();
                    $this->periodo_id = $objeto_flujo_requerimiento->periodo_id;
                }
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes){
        if(!Yii::$app->user->isGuest){
            if($insert){
                $objeto_conformidad_entregable = new ConformidadEntregable();
                $objeto_conformidad_entregable->contrato_entregable_id = $this->contrato_entregable_id;
                $objeto_conformidad_entregable->flag_conformidad = 0;
                $objeto_conformidad_entregable->staff_area_id = $this->staff_area_id;
                $objeto_conformidad_entregable->save();
            }
            parent::afterSave($insert, $changedAttributes);
            return true;
        }
        return false;
    }

}
