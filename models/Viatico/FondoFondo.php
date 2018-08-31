<?php

namespace app\models\Viatico;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\rrhh\StaffPersona;
use app\models\Patrimonio\DocumentoPnia;
use app\models\rrhh\PniaEntFinanciera;
use app\models\ModeloGenerico;
use \yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "fondo_fondo".
 *
 * @property int $fondo_fondo_id
 * @property int $responsable_persona_id
 * @property int $requerimiento_flujo_id
 * @property int $tipo_flujo_metacodigo
 * @property int $resolucion_directoral_pnia_documento_id
 * @property int $banco_entidad_financiera
 * @property string $motivo
 * @property double $saldo_anterior_bienes
 * @property double $saldo_anterior_servicios
 * @property double $saldo_actual_bienes
 * @property double $saldo_actual_servicios
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property double $total_bienes
 * @property double $total_servicios
 * @property double $total_entregado
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property DocumentoPnia $resolucionDirectoralPniaDocumento
 * @property FlujoRequerimiento $requerimientoFlujo
 * @property Metacodigo $tipoFlujoMetacodigo
 * @property PniaEntFinanciera $bancoEntidadFinanciera
 * @property StaffPersona $responsablePersona
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property FondoRendicionCajaChica[] $fondoRendicionCajaChicas
 * @property FondoRendicionEncargo[] $fondoRendicionEncargos
 * @property FondoRendicionViatico[] $fondoRendicionViaticos
 */
class FondoFondo extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */

    public $autocomplete_staff_persona;
    public static function tableName()
    {
        return 'fondo_fondo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['responsable_persona_id', , 'tipo_flujo_metacodigo', 'resolucion_directoral_pnia_documento_id', 'banco_entidad_financiera', 'autocomplete_staff_persona', 'total_bienes', 'total_servicios', 'total_entregado',], 'required'],
            [['requerimiento_flujo_id', 'tipo_flujo_metacodigo', 'resolucion_directoral_pnia_documento_id'], 'required'],
            [['responsable_persona_id', 'requerimiento_flujo_id', 'tipo_flujo_metacodigo', 'resolucion_directoral_pnia_documento_id', 'banco_entidad_financiera', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['responsable_persona_id', 'requerimiento_flujo_id', 'tipo_flujo_metacodigo', 'resolucion_directoral_pnia_documento_id', 'banco_entidad_financiera', 'actualizado_por', 'creado_por'], 'integer'],
            [['saldo_anterior_bienes', 'saldo_anterior_servicios', 'saldo_actual_bienes', 'saldo_actual_servicios', 'total_bienes', 'total_servicios', 'total_entregado'], 'number'],
            [['fecha_inicio', 'fecha_fin', 'actualizado_en', 'creado_en'], 'safe'],
            [['motivo'], 'string', 'max' => 255],
            [['resolucion_directoral_pnia_documento_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentoPnia::className(), 'targetAttribute' => ['resolucion_directoral_pnia_documento_id' => 'documento_pnia_id']],
            [['requerimiento_flujo_id'], 'exist', 'skipOnError' => true, 'targetClass' => FlujoRequerimiento::className(), 'targetAttribute' => ['requerimiento_flujo_id' => 'flujo_requerimiento_id']],
            [['tipo_flujo_metacodigo'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['tipo_flujo_metacodigo' => 'metacodigo_id']],
            [['banco_entidad_financiera'], 'exist', 'skipOnError' => true, 'targetClass' => PniaEntFinanciera::className(), 'targetAttribute' => ['banco_entidad_financiera' => 'pnia_ent_financiera_id']],
            [['responsable_persona_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffPersona::className(), 'targetAttribute' => ['responsable_persona_id' => 'staff_persona_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['autocomplete_staff_persona'],'string'],
            [['fecha_inicio'], 'required'],
            [['fecha_inicio'], 'safe'],
            ['fecha_fin', 'compare', 'compareAttribute' => 'fecha_inicio', 'operator' => '>'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fondo_fondo_id' => 'Fondo Fondo ID',
            'responsable_persona_id' => 'Responsable',
            'requerimiento_flujo_id' => 'Requerimiento Flujo ID',
            'tipo_flujo_metacodigo' => 'Tipo de Flujo',
            'resolucion_directoral_pnia_documento_id' => 'Documento Resolucion Directoral',
            'banco_entidad_financiera' => 'Entidad Financiera',
            'motivo' => 'Motivo',
            'saldo_anterior_bienes' => 'Saldo Anterior Bienes',
            'saldo_anterior_servicios' => 'Saldo Anterior Servicios',
            'saldo_actual_bienes' => 'Saldo Actual Bienes',
            'saldo_actual_servicios' => 'Saldo Actual Servicios',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'total_bienes' => 'Total Bienes',
            'total_servicios' => 'Total Servicios',
            'total_entregado' => 'Total Entregado',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
            'ticket' => 'Ticket',
        ];
    }

    public function findById($id){
        return static::findOne(['fondo_fondo_id'=>$id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {

            if($this->actualizado_por= Yii::$app->user->identity->usuario_id == 1)
                return 'Usuario master no puede agregar fondos';
             if(!Yii::$app->user->isGuest)
             {
                $this->actualizado_por= Yii::$app->user->identity->usuario_id;
                $model_persona = new StaffPersona();
                if(Yii::$app->user->identity->persona_id)
                {
                    // $persona = $model_persona->getPersonaPorId(Yii::$app->user->identity->persona_id);
                    // $persona_array = ArrayHelper::toArray($persona);
                    // $persona_id = $persona_array['staff_persona_id'];     
                    $persona_id = Yii::$app->user->identity->persona_id;
                }
                 
             }
             else
             {
                 return false;
             }
            $this->actualizado_en = date('Y-m-d H:i:s');
            if ($this->isNewRecord) {
                $this->creado_por = Yii::$app->user->identity->usuario_id;
                $this->creado_en = date('Y-m-d H:i:s');
                $this->responsable_persona_id = $persona_id;
                $this->fecha_inicio = date('Y-m-d H:i:s');
            }
            $model_flujo_requerimiento_actual = FlujoRequerimiento::find()->where(['codigo_requerimiento' => $this->requerimiento_flujo_id])->all();
            foreach ($model_flujo_requerimiento_actual as $flujo_requerimientos){
                $flujo_requerimientos->monto = $this->total_entregado;
                $flujo_requerimientos->ticket = true;
                $flujo_requerimientos->save();
            }
            return true;
        }
        return false;
    }
    
     public function beforeDelete() {
        $model_flujo_requerimiento_actual = FlujoRequerimiento::find()->where(['codigo_requerimiento' => $this->requerimiento_flujo_id])->all();
        foreach ($model_flujo_requerimiento_actual as $flujo_requerimientos){
            $flujo_requerimientos->monto = 0;
            $flujo_requerimientos->ticket = false;
            $flujo_requerimientos->save();
        }
        return parent::beforeDelete();
    }

    public function getResolucionDirectoralPniaDocumento()
    {
        return $this->hasOne(DocumentoPnia::className(), ['documento_pnia_id' => 'resolucion_directoral_pnia_documento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequerimientoFlujo()
    {
        return $this->hasOne(FlujoRequerimiento::className(), ['flujo_requerimiento_id' => 'requerimiento_flujo_id']);
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
    public function getBancoEntidadFinanciera()
    {
        return $this->hasOne(PniaEntFinanciera::className(), ['pnia_ent_financiera_id' => 'banco_entidad_financiera']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsablePersona()
    {
        return $this->hasOne(StaffPersona::className(), ['staff_persona_id' => 'responsable_persona_id']);
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
    public function getFondoRendicionCajaChicas()
    {
        return $this->hasMany(FondoRendicionCajaChica::className(), ['caja_chica_fondo_fondo' => 'fondo_fondo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoRendicionEncargos()
    {
        return $this->hasMany(FondoRendicionEncargo::className(), ['encargo_fondo_fondo' => 'fondo_fondo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoRendicionViaticos()
    {
        return $this->hasMany(FondoRendicionViatico::className(), ['viatico_fondo_fondo' => 'fondo_fondo_id']);
    }

    /**
     * @param null $tipo_flujo_metacodigo_id
     * @param null $responsable_persona_id
     * @return [fondo_fondo_id => motivo]
     */
    static function getComboBoxItems($tipo_flujo_metacodigo_id = null, $responsable_persona_id = null){
        if($tipo_flujo_metacodigo_id == null OR $responsable_persona_id == null){
            $items  = FondoFondo::find()->all();
        }else{
            $items  = FondoFondo::find()->where(['tipo_flujo_metacodigo' => $tipo_flujo_metacodigo_id ,
                                                 'responsable_persona_id' => $responsable_persona_id])->all();
        }

        return ArrayHelper::map($items,'fondo_fondo_id', 'motivo');

    }
    
    static function getComboBoxItemsPorMetacodigo($tipo_flujo_metacodigo_id){

        $items  = FondoFondo::find()->where(['tipo_flujo_metacodigo' => $tipo_flujo_metacodigo_id])
                    ->andFilterWhere(['=', 'ticket', false])
                    ->all();
        return ArrayHelper::map($items,'fondo_fondo_id', 'motivo');

    }
    
//    public function afterSave($insert, $changedAttributes){
//        if(!Yii::$app->user->isGuest){
//            if($insert){
//                $model_flujo_requerimiento_actual = FlujoRequerimiento::find()->where(['flujo_requerimiento_id' => $this->requerimiento_flujo_id])->one();
//                $model_flujo_requerimiento_actual->monto = $this->total_entregado;
//                $model_flujo_requerimiento_actual->save();
//                $this->save();
//            }
//            parent::afterSave($insert, $changedAttributes);
//            return true;
//        }
//        return false;
//    }
}
