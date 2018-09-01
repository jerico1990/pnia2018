<?php

namespace app\models\Adquisicion;
use app\models\ModeloGenerico;

use Yii;
use app\models\Utilitario\UtilitarioUbigeo;
use app\models\Viatico\ArbolArea;
use app\models\Presupuesto\PresupuestoCabecera;
use \yii\helpers\ArrayHelper;
/**
 * This is the model class for table "requerimiento_detalle".
 *
 * @property int $requerimiento_detalle_id
 * @property int $requerimiento_id
 * @property int $linea_nivel_id
 * @property string $descripcion
 * @property string $concepto
 * @property string $unidad_medida
 * @property int $cantidad
 * @property double $costo_unitario
 * @property double $monto_total
 * @property double $rooc
 * @property double $ro
 * @property string $especificacion_tecnica
 * @property string $tiempo_entrega
 * @property int $tipo_garantia_id
 * @property int $garantia_cantidad
 * @property string $lugar_entrega
 * @property string $fecha_entrega
 * @property string $forma_pago
 * @property string $resumen_especificacion_tecnica
 * @property string $otras_caractaristicas
 * @property int $forma_entrega
 * @property int $anio_fabricacion
 * @property string $lugar_fabricacion
 * @property string $staff_area_id
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 */
class RequerimientoDetalle extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public $FormaPagoDescripciones;
    public $FormaPagoTiempos;
    public $FormaPagoPorcentajes;
    public $FormaPagoCondiciones;

    public static function tableName()
    {
        return 'requerimiento_detalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FormaPagoDescripciones', 'FormaPagoTiempos', 'FormaPagoPorcentajes', 'FormaPagoCondiciones', 'linea_nivel_id', 'cantidad', 'tipo_garantia_id', 'garantia_cantidad', 'forma_entrega', 'anio_fabricacion', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['requerimiento_id', 'linea_nivel_id', 'cantidad', 'tipo_garantia_id', 'garantia_cantidad', 'forma_entrega', 'anio_fabricacion', 'actualizado_por', 'creado_por'], 'integer'],
            [['costo_unitario', 'monto_total', 'rooc', 'ro'], 'number'],
            [['especificacion_tecnica', 'forma_pago', 'resumen_especificacion_tecnica', 'otras_caractaristicas', 'staff_area_id'], 'string'],
            [['tiempo_entrega', 'fecha_entrega', 'actualizado_en', 'creado_en'], 'safe'],
            [['descripcion'], 'string', 'max' => 500],
            [['concepto'], 'string', 'max' => 250],
            [['unidad_medida'], 'string', 'max' => 50],
            [['lugar_entrega', 'lugar_fabricacion'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'requerimiento_detalle_id' => 'Requerimiento Detalle ID',
            'requerimiento_id' => 'Requerimiento ID',
            'linea_nivel_id' => 'Linea Nivel ID',
            'descripcion' => 'Descripcion',
            'concepto' => 'Concepto',
            'unidad_medida' => 'Unidad Medida',
            'cantidad' => 'Cantidad',
            'costo_unitario' => 'Costo Unitario',
            'monto_total' => 'Monto Total',
            'rooc' => 'Rooc',
            'ro' => 'Ro',
            'especificacion_tecnica' => 'Especificacion Tecnica',
            'tiempo_entrega' => 'Tiempo Entrega',
            'tipo_garantia_id' => 'Tipo Garantia ID',
            'garantia_cantidad' => 'Garantia Cantidad',
            'lugar_entrega' => 'Lugar Entrega',
            'fecha_entrega' => 'Fecha Entrega',
            'forma_pago' => 'Forma Pago',
            'resumen_especificacion_tecnica' => 'Resumen Especificacion Tecnica',
            'otras_caractaristicas' => 'Otras Caractaristicas',
            'forma_entrega' => 'Forma Entrega',
            'anio_fabricacion' => 'Anio Fabricacion',
            'lugar_fabricacion' => 'Lugar Fabricacion',
            'staff_area_id' => 'Staff Area ID',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    public function getSituacionRequerimientoDetalle(){
      $msg='';
      if($this->situacion_requerimiento_detalle_id==1){
        $msg='En digitación';
      }
      elseif($this->situacion_requerimiento_detalle_id==2){
        $msg='Por aprobar';
      }
      elseif($this->situacion_requerimiento_detalle_id==3){
        $msg='Requerimiento Aprobado';
      }
      elseif($this->situacion_requerimiento_detalle_id==4){
        $msg='Requerimiento Desaprobado';
      }
      elseif($this->situacion_requerimiento_detalle_id==5){
        $msg='VB Dirección de Operaciones';
      }
      elseif($this->situacion_requerimiento_detalle_id==6){
        $msg='VB Dirección de Operaciones Aprobado';
      }
      elseif($this->situacion_requerimiento_detalle_id==7){
        $msg='VB Dirección de Operaciones Rechazado';
      }
      elseif($this->situacion_requerimiento_detalle_id==8){
        $msg='Pedido de Certificación';
      }
      elseif($this->situacion_requerimiento_detalle_id==9){
        $msg='Certificación Aprobada';
      }
      elseif($this->situacion_requerimiento_detalle_id==10){
        $msg='Certificación Rechazada';
      }
      elseif($this->situacion_requerimiento_detalle_id==11){
        $msg='Calificación de adquisición';
      }
      elseif($this->situacion_requerimiento_detalle_id==12){
        $msg='Calificación de Adquisición Admitida';
      }
      elseif($this->situacion_requerimiento_detalle_id==13){
        $msg='Calificación de Adquisición Observada';
      }
      elseif($this->situacion_requerimiento_detalle_id==14){
        $msg='Pedido completo';
      }
      elseif($this->situacion_requerimiento_detalle_id==15){
        $msg='Pedido incompleto';
      }
      elseif($this->situacion_requerimiento_detalle_id==16){
        $msg='Registro de Postores';
      }
      elseif($this->situacion_requerimiento_detalle_id==17){
        $msg='Ganador de Postores';
      }
      elseif($this->situacion_requerimiento_detalle_id==18){
        $msg='Pedido de compromiso';
      }
      elseif($this->situacion_requerimiento_detalle_id==19){
        $msg='Compromiso Aprobado';
      }
      elseif($this->situacion_requerimiento_detalle_id==20){
        $msg='Compromiso Rechazado';
      }
      //acabo de descubrir q el pendex de klauss paga a uno de los chicos 1500. :/
      return $msg;
    }

    public function getIngresarAdjudicacion(){
      $ingresar = false;
      if($this->situacion_requerimiento_detalle_id==12 || $this->situacion_requerimiento_detalle_id==13 || $this->situacion_requerimiento_detalle_id==14 || $this->situacion_requerimiento_detalle_id==16 || $this->situacion_requerimiento_detalle_id==17 || $this->situacion_requerimiento_detalle_id==18 || $this->situacion_requerimiento_detalle_id==19){
        $ingresar = true;
      }
      return $ingresar;
    }

    public function getAdjudicacionId(){
      $adjudicacion = Adjudicacion::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id',[':requerimiento_detalle_id'=>$this->requerimiento_detalle_id])->one();
      return $adjudicacion->adjudicacion_id;
    }

    public function get4uitmenor(){
      //$adjudicacion = Adjudicacion::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id',[':requerimiento_detalle_id'=>$this->requerimiento_detalle_id])->one();
      return true;
    }

	  public function getDestinoIniUbigeo()
    {
        //return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_ini_ubigeo']);
        return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_ini_ubigeo'])->from(['destinoInicial' => UtilitarioUbigeo::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinoFinUbigeo()
    {
        //return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_fin_ubigeo']);
        return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_fin_ubigeo'])->from(['destinoFinal' => UtilitarioUbigeo::tableName()]);
    }

    static function getComboBoxItemsLineasPresupuesto($staff_area_id){

        $lineas =     PresupuestoCabecera::find()
                      ->select('presupuesto_cabecera.presupuesto_cabecera_id,presupuesto_cabecera.nombre_linea')
                      ->innerJoin('arbol_area','presupuesto_cabecera.presupuesto_cabecera_id=arbol_area.presupuesto_cabecera_id')
                      ->where('arbol_area.staff_area_id=:staff_area_id',[':staff_area_id'=>$staff_area_id])
                      ->all();

        return ArrayHelper::map($lineas, 'presupuesto_cabecera_id', 'nombre_linea');

    }

}
