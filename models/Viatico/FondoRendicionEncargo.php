<?php

namespace app\models\Viatico;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use app\models\Patrimonio\DocumentoPnia;
use app\models\Patrimonio\Metacodigo;
use app\models\rrhh\StaffPersona;
use Yii;

/**
 * This is the model class for table "fondo_rendicion_encargo".
 *
 * @property int $fondo_rendicion_encargo_id
 * @property int $fondo_fondo_id
 * @property int $flujo_requerimiento_id
 * @property int $tipo_flujo_metacodigo
 * @property int $estado_paso_metacodigo
 * @property int $responsable_persona_id
 * @property int $correlativo
 * @property double $total
 * @property int $documento_pnia_id
 * @property string $fecha_rendicion
 * @property string $informe_actividades_logros
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property DocumentoPnia $documentoPnia
 * @property FlujoRequerimiento $flujoRequerimiento
 * @property FondoFondo $fondoFondo
 * @property Metacodigo $tipoFlujoMetacodigo
 * @property Metacodigo $estadoPasoMetacodigo
 * @property StaffPersona $responsablePersona
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property FondoRendicionGenerico[] $fondoRendicionGenericos
 */
class FondoRendicionEncargo extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fondo_rendicion_encargo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fondo_fondo_id', 'flujo_requerimiento_id', 'responsable_persona_id', 'correlativo', 'documento_pnia_id'], 'default', 'value' => null],
            [['fondo_fondo_id', 'flujo_requerimiento_id', 'responsable_persona_id', 'correlativo', 'documento_pnia_id'], 'integer'],
            [['correlativo', 'total', 'documento_pnia_id'], 'required'],
            [['total'], 'number'],
            [['fecha_rendicion', 'actualizado_en', 'creado_en'], 'safe'],
            [['informe_actividades_logros'], 'string', 'max' => 255],
            [['documento_pnia_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentoPnia::className(), 'targetAttribute' => ['documento_pnia_id' => 'documento_pnia_id']],
            [['flujo_requerimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => FlujoRequerimiento::className(), 'targetAttribute' => ['flujo_requerimiento_id' => 'flujo_requerimiento_id']],
            [['fondo_fondo_id'], 'exist', 'skipOnError' => true, 'targetClass' => FondoFondo::className(), 'targetAttribute' => ['fondo_fondo_id' => 'fondo_fondo_id']],
//            [['tipo_flujo_metacodigo'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['tipo_flujo_metacodigo' => 'metacodigo_id']],
//            [['estado_paso_metacodigo'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['estado_paso_metacodigo' => 'metacodigo_id']],
            [['responsable_persona_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffPersona::className(), 'targetAttribute' => ['responsable_persona_id' => 'staff_persona_id']],
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
            'fondo_rendicion_encargo_id' => 'Fondo Rendicion Encargo ID',
            'fondo_fondo_id' => 'Fondo Fondo ID',
            'flujo_requerimiento_id' => 'Flujo Requerimiento ID',
//            'tipo_flujo_metacodigo' => 'Tipo Flujo Metacodigo',
//            'estado_paso_metacodigo' => 'Estado Paso Metacodigo',
            'responsable_persona_id' => 'Responsable Persona ID',
            'correlativo' => 'Correlativo',
            'total' => 'Total',
            'documento_pnia_id' => 'Documento Pnia ID',
            'fecha_rendicion' => 'Fecha Rendicion',
            'informe_actividades_logros' => 'Informe Actividades Logros',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentoPnia()
    {
        return $this->hasOne(DocumentoPnia::className(), ['documento_pnia_id' => 'documento_pnia_id']);
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
    public function getFondoFondo()
    {
        return $this->hasOne(FondoFondo::className(), ['fondo_fondo_id' => 'fondo_fondo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getTipoFlujoMetacodigo()
//    {
//        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'tipo_flujo_metacodigo']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getEstadoPasoMetacodigo()
//    {
//        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'estado_paso_metacodigo']);
//    }

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
    public function getFondoRendicionGenericos()
    {
        return $this->hasMany(FondoRendicionGenerico::className(), ['fondo_rendicion_encargo_id' => 'fondo_rendicion_encargo_id']);
    }
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {

            if($this->actualizado_por= Yii::$app->user->identity->usuario_id == 1)
                return 'Usuario master no puede agregar rendiciones';
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
                $this->fecha_rendicion = date('Y-m-d H:i:s');
//                $this->fecha_inicio = date('Y-m-d H:i:s');
            }
            $fondo_fondo_rendicion = FondoFondo::find()->where(['fondo_fondo_id' => $this->fondo_fondo_id])->one();
            $this->flujo_requerimiento_id = $fondo_fondo_rendicion->requerimiento_flujo_id;    
            $fondo_fondo_rendicion->ticket = true;
            $fondo_fondo_rendicion->save();   
            return true;
        }
        return false;
    }
    public function beforeDelete() {
        $fondo_fondo_rendicion = FondoFondo::find()->where(['fondo_fondo_id' => $this->fondo_fondo_id])->one();
        $fondo_fondo_rendicion->ticket = false;
        $fondo_fondo_rendicion->save();   
        return parent::beforeDelete();
    }
    
    public function asignarDocumentos($array_documentos_id){     
        foreach($array_documentos_id as $documento_actual){
            $objeto_requerimiento_documento = new RequerimientoDocumento();
            $objeto_requerimiento_documento->flujo_requerimiento_id = $this->flujo_requerimiento_id;
            $objeto_requerimiento_documento->documento_pnia_id = $documento_actual;
            $objeto_requerimiento_documento->save(false);
        }
    }
}
