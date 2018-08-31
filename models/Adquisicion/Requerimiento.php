<?php


namespace app\models\Adquisicion;
use app\models\ModeloGenerico;
use app\models\Patrimonio\Metacodigo;
use app\models\Patrimonio\DocumentoPnia;
use \yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "requerimiento".
 *
 * @property int $requerimiento_id
 * @property string $descripcion
 * @property string $asunto
 * @property string $documento
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 */
class Requerimiento extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requerimiento';
    }

    /**
     * {@inheritdoc}
     */
     public function rules()
     {
         return [
             [['tipo_requerimiento_id', 'asunto'], 'required'],
             [['tipo_requerimiento_id', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
             [['tipo_requerimiento_id', 'actualizado_por', 'creado_por'], 'integer'],
             [['actualizado_en', 'creado_en'], 'safe'],
             [['descripcion'], 'string', 'max' => 5000],
             [['asunto'], 'string', 'max' => 250],
             [['documento'], 'string', 'max' => 150],
         ];
     }

     /**
      * {@inheritdoc}
      */
     public function attributeLabels()
     {
         return [
             'requerimiento_id' => 'Requerimiento ID',
             'tipo_requerimiento_id' => 'Tipo Requerimiento',
             'descripcion' => 'Descripcion',
             'asunto' => 'Asunto',
             'documento' => 'Documento',
             'actualizado_en' => 'Actualizado En',
             'actualizado_por' => 'Actualizado Por',
             'creado_en' => 'Creado En',
             'creado_por' => 'Creado Por',
         ];
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getTipoRequerimiento()
     {
         return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'tipo_requerimiento_id']);
     }

     public function getMetaCodigo(){
        return Metacodigo::findOne($this->tipo_requerimiento_id);
     }

     public function getRequerimientoDetallePedirCertificacionSIAF(){
        $countRequerimientoDetalles=(new \yii\db\Query())
                   ->from('requerimiento_detalle')
                   ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=6',[':requerimiento_id'=>$this->requerimiento_id])
                   ->count();
        return $countRequerimientoDetalles;
     }

     public function getRequerimientoDetalleAprobarCertificacionSIAF(){
        $countRequerimientoDetalles=(new \yii\db\Query())
                   ->from('requerimiento_detalle')
                   ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=8',[':requerimiento_id'=>$this->requerimiento_id])
                   ->count();
        return $countRequerimientoDetalles;
     }



     public function getRequerimientoDetalleEnviarAdjudicacion(){
        $countRequerimientoDetalles=(new \yii\db\Query())
                   ->from('requerimiento_detalle')
                   ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=1',[':requerimiento_id'=>$this->requerimiento_id])
                   ->count();
        return $countRequerimientoDetalles;
     }

     public function getSituacionRequerimiento(){
       $msg='';
       if($this->situacion_requerimiento_id==1){
         $msg='En digitación';
       }
       elseif($this->situacion_requerimiento_id==2){
         $msg='Por aprobar';
       }
       elseif($this->situacion_requerimiento_id==3){
         $msg='Requerimiento Aprobado';
       }
       elseif($this->situacion_requerimiento_id==4){
         $msg='Requerimiento Desaprobado';
       }
       elseif($this->situacion_requerimiento_id==5){
         $msg='VB Dirección de Operaciones';
       }
       elseif($this->situacion_requerimiento_id==6){
         $msg='VB Dirección de Operaciones Aprobado';
       }
       elseif($this->situacion_requerimiento_id==7){
         $msg='VB Dirección de Operaciones Rechazado';
       }
       elseif($this->situacion_requerimiento_id==8){
         $msg='Pedido de Certificación';
       }
       elseif($this->situacion_requerimiento_id==9){
         $msg='Certificación Aprobada';
       }
       elseif($this->situacion_requerimiento_id==10){
         $msg='Certificación Rechazada';
       }
       elseif($this->situacion_requerimiento_id==11){
         $msg='Calificación de adquisición';
       }
       elseif($this->situacion_requerimiento_id==12){
         $msg='Calificación de Adquisición Admitida';
       }
       elseif($this->situacion_requerimiento_id==13){
         $msg='Calificación de Adquisición Observada';
       }

       return $msg;
     }

     public function asignarDocumentos($array_documentos_id){
        foreach($array_documentos_id as $documento_actual){
            $objeto_contrato_documento = new \app\models\Viatico\RequerimientoDocumento();
            $objeto_contrato_documento->flujo_requerimiento_id = $this->requerimiento_id;
            $objeto_contrato_documento->documento_pnia_id = $documento_actual;
            $objeto_contrato_documento->save(false);
        }
     }

     public function getDocumentos(){
       $documento=DocumentoPnia::find()->where('tabla=:tabla and pk_tabla=:pk_tabla',[':tabla'=>'requerimiento',':pk_tabla'=>$this->requerimiento_id])->one();
       return $documento;
     }
}
