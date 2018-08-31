<?php

namespace app\models\Viatico;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use app\models\Patrimonio\Metacodigo;
use app\models\rrhh\PniaEntidad;
use Yii;
use app\models\Viatico\FondoFondo;

/**
 * This is the model class for table "fondo_rendicion_generico".
 *
 * @property int $fondo_rendicion_generico_id
 * @property int $fondo_rendicion_viatico_id
 * @property int $fondo_rendicion_caja_chica_id
 * @property int $fondo_rendicion_encargo_id
 * @property int $tipo_afecto_igv_metacodigo
 * @property int $tipo_bien_servicio_metacodigo
 * @property int $tipo_documento_metacodigo
 * @property int $proveedor_pnia_entidad_id
 * @property double $importe
 * @property double $importe_gravado
 * @property double $importe_no_gravado
 * @property string $serie_numero
 * @property string $ruc
 * @property string $detalle_gasto
 * @property string $fecha_documento
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property FondoRendicionCajaChica $fondoRendicionCajaChica
 * @property FondoRendicionEncargo $fondoRendicionEncargo
 * @property FondoRendicionViatico $fondoRendicionViatico
 * @property Metacodigo $tipoAfectoIgvMetacodigo
 * @property Metacodigo $tipoBienServicioMetacodigo
 * @property Metacodigo $tipoDocumentoMetacodigo
 * @property PniaEntidad $proveedorPniaEntidad
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class FondoRendicionGenerico extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fondo_rendicion_generico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_afecto_igv_metacodigo', 'tipo_documento_metacodigo', 'proveedor_pnia_entidad_id', 'ruc'], 'required'],
            [['fondo_rendicion_viatico_id', 'fondo_rendicion_caja_chica_id', 'fondo_rendicion_encargo_id', 'tipo_afecto_igv_metacodigo', 'tipo_bien_servicio_metacodigo', 'tipo_documento_metacodigo', 'proveedor_pnia_entidad_id', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['fondo_rendicion_viatico_id', 'fondo_rendicion_caja_chica_id', 'fondo_rendicion_encargo_id', 'tipo_afecto_igv_metacodigo', 'tipo_bien_servicio_metacodigo', 'tipo_documento_metacodigo', 'proveedor_pnia_entidad_id', 'actualizado_por', 'creado_por'], 'integer'],
            ['ruc', 'validarRuc' ],
            //[['importe', 'importe_gravado', 'importe_no_gravado', 'importe_entrega', 'importe_viatico', 'importe_caja_chica'], 'number'],
            ['importe_entrega', 'validarImporteEntrega'],
            ['importe_viatico', 'validarImporteViatico'],
            ['importe_caja_chica', 'validarImporteCajaChica'],
            [['fecha_documento', 'actualizado_en', 'creado_en'], 'safe'],
            [['serie_numero', 'detalle_gasto'], 'string', 'max' => 255],
            [['ruc'], 'string', 'max' => 11],
            [['fondo_rendicion_caja_chica_id'], 'exist', 'skipOnError' => true, 'targetClass' => FondoRendicionCajaChica::className(), 'targetAttribute' => ['fondo_rendicion_caja_chica_id' => 'fondo_rendicion_caja_chica_id']],
            [['fondo_rendicion_encargo_id'], 'exist', 'skipOnError' => true, 'targetClass' => FondoRendicionEncargo::className(), 'targetAttribute' => ['fondo_rendicion_encargo_id' => 'fondo_rendicion_encargo_id']],
            [['fondo_rendicion_viatico_id'], 'exist', 'skipOnError' => true, 'targetClass' => FondoRendicionViatico::className(), 'targetAttribute' => ['fondo_rendicion_viatico_id' => 'fondo_rendicion_viatico_id']],
            [['tipo_afecto_igv_metacodigo'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['tipo_afecto_igv_metacodigo' => 'metacodigo_id']],
            [['tipo_bien_servicio_metacodigo'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['tipo_bien_servicio_metacodigo' => 'metacodigo_id']],
            [['tipo_documento_metacodigo'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['tipo_documento_metacodigo' => 'metacodigo_id']],
            [['proveedor_pnia_entidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => PniaEntidad::className(), 'targetAttribute' => ['proveedor_pnia_entidad_id' => 'pnia_entidad_id']],
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
            'fondo_rendicion_generico_id' => 'Fondo Rendicion Generico ID',
            'fondo_rendicion_viatico_id' => 'Fondo Rendicion Viatico ID',
            'fondo_rendicion_caja_chica_id' => 'Fondo Rendicion Caja Chica ID',
            'fondo_rendicion_encargo_id' => 'Fondo Rendicion Encargo ID',
            'tipo_afecto_igv_metacodigo' => 'Tipo Afecto Igv Metacodigo',
            'tipo_bien_servicio_metacodigo' => 'Tipo Bien Servicio Metacodigo',
            'tipo_documento_metacodigo' => 'Tipo Documento Metacodigo',
            'proveedor_pnia_entidad_id' => 'Proveedor Pnia Entidad ID',
            'importe' => 'Importe',
            'importe_gravado' => 'Importe Gravado',
            'importe_no_gravado' => 'Importe No Gravado',
            'serie_numero' => 'Número de Serie',
            'ruc' => 'RUC',
            'detalle_gasto' => 'Detalle del Gasto',
            'fecha_documento' => 'Fecha de Documento',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
            'importe_viatico' => 'Importe',
            'importe_caja_chica' => 'Importe',
            'importe_entrega' => 'Importe',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    //Función para validar que el importe total de las rendiciones genéricas no exceda al total de la rendición cabecera donde se encuentra
    public function validarImporteEntrega(){
        $importe_total_de_todas_las_rendiciones_encargo = 0;
        if (isset($_SESSION['fondo_rendicion_encargo_id'])){
            $model_rendicion_entrega = FondoRendicionEncargo::find()->where(['fondo_rendicion_encargo_id' => $_SESSION['fondo_rendicion_encargo_id']])->one();
            $importe_total_encargo = $model_rendicion_entrega->total; //se obtiene el total que no debe pasar del encargo
            $id_rendicion_encargo = $model_rendicion_entrega->fondo_rendicion_encargo_id;
            
            
            //obtener todas las rendiciones genericas donde tienen id de rendicion encargo y sumar sus importes y compararlos con el total del encargo para que no se pasen
            $model_rendicion_entrega_generico = FondoRendicionGenerico::find()->where(['fondo_rendicion_encargo_id' => $id_rendicion_encargo])->all();
            foreach ($model_rendicion_entrega_generico as $detalle_encargo){
                $importe_total_de_todas_las_rendiciones_encargo = $importe_total_de_todas_las_rendiciones_encargo + $detalle_encargo->importe_entrega;
            }
            $total_a_validar = $importe_total_de_todas_las_rendiciones_encargo + $this->importe_entrega;
            //$this->addError('importe_entrega', 'No puede excederse del importe total del Encargo'.$importe_total_encargo.' '.$id_rendicion_encargo.' '.$total_a_validar.' ');
            if($total_a_validar > $importe_total_encargo){
                $this->addError('importe_entrega', 'No puede excederse del importe total del Encargo('.$importe_total_encargo.')');
            }
            
        }
//        if (true){
//            $this->addError('importe_entrega', 'No puede excederse del importe total del Encargo');
//        }
    }
    
    public function validarImporteCajaChica(){
        $importe_total_de_todas_las_rendiciones_caja_chica = 0;
        if (isset($_SESSION['fondo_rendicion_caja_chica_id'])){
            $model_rendicion_caja_chica = FondoRendicionCajaChica::find()->where(['fondo_rendicion_caja_chica_id' => $_SESSION['fondo_rendicion_caja_chica_id']])->one();
            $importe_total_caja_chica = $model_rendicion_caja_chica->total_rendicion; //se obtiene el total que no debe pasar del encargo
            $id_rendicion_caja_chica = $model_rendicion_caja_chica->fondo_rendicion_caja_chica_id;
            
            //obtener todas las rendiciones genericas donde tienen id de rendicion encargo y sumar sus importes y compararlos con el total del encargo para que no se pasen
            $model_rendicion_caja_chica_generico = FondoRendicionGenerico::find()->where(['fondo_rendicion_caja_chica_id' => $id_rendicion_caja_chica])->all();
            foreach ($model_rendicion_caja_chica_generico as $detalle){
                $importe_total_de_todas_las_rendiciones_caja_chica = $importe_total_de_todas_las_rendiciones_caja_chica + $detalle->importe_caja_chica;
            }
            $total_a_validar = $importe_total_de_todas_las_rendiciones_caja_chica + $this->importe_caja_chica;
            if($total_a_validar > $importe_total_caja_chica){
                $this->addError('importe_caja_chica', 'No puede excederse del importe total de la Caja Chica('.$importe_total_caja_chica.')');
            }
            
        }
    }
    
    public function validarImporteViatico(){
        $importe_total_de_todas_las_rendiciones_viatico = 0;
        if (isset($_SESSION['fondo_rendicion_viatico_id'])){
            $model_rendicion_viatico = FondoRendicionViatico::find()->where(['fondo_rendicion_viatico_id' => $_SESSION['fondo_rendicion_viatico_id']])->one();
            $importe_total_viatico = $model_rendicion_viatico->anticipo_recibido; //se obtiene el total que no debe pasar del encargo
            $id_rendicion_viatico = $model_rendicion_viatico->fondo_rendicion_viatico_id;
            
            //obtener todas las rendiciones genericas donde tienen id de rendicion encargo y sumar sus importes y compararlos con el total del encargo para que no se pasen
            $model_rendicion_viatico_generico = FondoRendicionGenerico::find()->where(['fondo_rendicion_viatico_id' => $id_rendicion_viatico])->all();
            foreach ($model_rendicion_viatico_generico as $detalle){
                $importe_total_de_todas_las_rendiciones_viatico = $importe_total_de_todas_las_rendiciones_viatico + $detalle->importe_viatico;
            }
            $total_a_validar = $importe_total_de_todas_las_rendiciones_viatico + $this->importe_viatico;
            if($total_a_validar > $importe_total_viatico){
                $this->addError('importe_viatico', 'No puede excederse del importe total del Viático('.$importe_total_viatico.')');
            }
            
        }
    }
    
    //despues de insertarse una rendicion generica de entrega, se cargan los bienes y servicios para su fondo entrega
    //solo se ejecuta para entrega esta funcion
    public function asignarBienesServicios(){
        $total_bienes = 0;
        $total_servicios = 0;
        if (isset($_SESSION['fondo_rendicion_encargo_id'])){
            $metacodigo_tipo_bien = Metacodigo::getMetacodigoId('Tipo_Bien_Servicio', 'Bien');
            $metacodigo_tipo_servicio = Metacodigo::getMetacodigoId('Tipo_Bien_Servicio', 'Servicio');
            $modelos_entrega_generico_actuales = FondoRendicionGenerico::find()->where(['fondo_rendicion_encargo_id' => $_SESSION['fondo_rendicion_encargo_id']])->all();
            foreach ($modelos_entrega_generico_actuales as $detalle){
                if ($detalle->tipo_bien_servicio_metacodigo == $metacodigo_tipo_bien){
                    $total_bienes = $total_bienes + $detalle->importe_entrega;
                }
                if ($detalle->tipo_bien_servicio_metacodigo == $metacodigo_tipo_servicio){
                    $total_servicios = $total_servicios +  $detalle->importe_entrega;
                }
            }
            $model_rendicion_encargo = FondoRendicionEncargo::find()->where(['fondo_rendicion_encargo_id' => $_SESSION['fondo_rendicion_encargo_id']])->one();
            $id_fondo_entrega_a_actualizar = $model_rendicion_encargo->fondo_fondo_id;
            $model_rendicion_encargo_a_actualizar = FondoFondo::find()->where(['fondo_fondo_id' => $id_fondo_entrega_a_actualizar])->one();
            $model_rendicion_encargo_a_actualizar->total_bienes = $total_bienes;
            $model_rendicion_encargo_a_actualizar->total_servicios = $total_servicios;
            $model_rendicion_encargo_a_actualizar->save();
        }
    }
    
    //solo se ejecuta para caja chica
    //despues de insertar su rendicion generica
    public function asignarSaldos(){
        if (isset($_SESSION['fondo_rendicion_caja_chica_id'])){
            $model_rendicion_caja_chica = FondoRendicionCajaChica::find()->where(['fondo_rendicion_caja_chica_id' => $_SESSION['fondo_rendicion_caja_chica_id']])->one();
            $id_fondo_caja_chica = $model_rendicion_caja_chica->fondo_fondo_id;
            $model_fondo_caja_chica = FondoFondo::find()->where(['fondo_fondo_id' => $id_fondo_caja_chica])->one();
            $total_entregado_en_caja_chica = $model_fondo_caja_chica->total_entregado;
            
            
            //la primera vez los dos saldos son el importe total
            if($model_fondo_caja_chica->saldo_anterior_bienes == null){
                //saldo anterior bienes será saldo anterior en general
                $model_fondo_caja_chica->saldo_anterior_bienes = $total_entregado_en_caja_chica;
                $model_fondo_caja_chica->saldo_actual_bienes = $total_entregado_en_caja_chica - $this->importe_caja_chica;
            }      
            else{
                //si no es la primera vez
                $model_fondo_caja_chica->saldo_anterior_bienes = $model_fondo_caja_chica->saldo_actual_bienes;
                $model_fondo_caja_chica->saldo_actual_bienes = $model_fondo_caja_chica->saldo_actual_bienes - $this->importe_caja_chica;
            }
            
            $model_fondo_caja_chica->save();
        }
        
    }
    
    public function getFondoRendicionCajaChica()
    {
        return $this->hasOne(FondoRendicionCajaChica::className(), ['fondo_rendicion_caja_chica_id' => 'fondo_rendicion_caja_chica_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoRendicionEncargo()
    {
        return $this->hasOne(FondoRendicionEncargo::className(), ['fondo_rendicion_encargo_id' => 'fondo_rendicion_encargo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoRendicionViatico()
    {
        return $this->hasOne(FondoRendicionViatico::className(), ['fondo_rendicion_viatico_id' => 'fondo_rendicion_viatico_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoAfectoIgvMetacodigo()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'tipo_afecto_igv_metacodigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoBienServicioMetacodigo()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'tipo_bien_servicio_metacodigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoDocumentoMetacodigo()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'tipo_documento_metacodigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedorPniaEntidad()
    {
        return $this->hasOne(PniaEntidad::className(), ['pnia_entidad_id' => 'proveedor_pnia_entidad_id']);
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
                //no funciona porque las variables de sesion siempre existen
//                if (isset($_SESSION['fondo_rendicion_caja_chica_id'])){
//                    $this->fondo_rendicion_caja_chica_id = $_SESSION['fondo_rendicion_caja_chica_id'];
//                }
//                if (isset($_SESSION['fondo_rendicion_viatico_id'])){
//                    $this->fondo_rendicion_viatico_id = $_SESSION['fondo_rendicion_caja_chica_id'];
//                }
//                if (isset($_SESSION['fondo_rendicion_encargo_id'])){
//                    $this->fondo_rendicion_encargo_id = $_SESSION['fondo_rendicion_caja_chica_id'];
//                }
            }
           
            return true;
        }
        return false;
    }
}
