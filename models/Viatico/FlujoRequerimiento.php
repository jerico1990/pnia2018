<?php

namespace app\models\Viatico;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\rrhh\StaffPersona;
use app\models\rrhh\StaffArea;
use \yii\helpers\ArrayHelper;
use app\models\Viatico\FlujoPaso;
use app\models\Patrimonio\DocumentoPnia;
use app\models\Viatico\RequerimientoDocumento;
use app\models\Adquisicion\Adquisicion;
use app\models\Viatico\FlujoFlujo;
use app\models\Presupuesto\PresupuestoCabecera;
use app\models\Presupuesto\Periodo;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "flujo_requerimiento".
 *
 * @property int $flujo_requerimiento_id
 * @property string $descripcion
 * @property int $emisor_persona_id
 * @property int $codigo_flujo
 * @property int $codigo_paso
 * @property int $estado_paso
 * @property string $fecha_instanciacion
 * @property int $codigo_arbol
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ArbolPnia $codigoArbol
 * @property FlujoFlujo $codigoFlujo
 * @property FlujoPaso $codigoPaso
 * @property Metacodigo $estadoPaso
 * @property StaffPersona $emisorPersona
 * @property StaffPersona $aprobadorPaso
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property FondoFondo[] $fondoFondos
 * @property FondoRendicionCajaChica[] $fondoRendicionCajaChicas
 * @property FondoRendicionEncargo[] $fondoRendicionEncargos
 * @property FondoRendicionViatico[] $fondoRendicionViaticos
 */
class FlujoRequerimiento extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'flujo_requerimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emisor_persona_id', 'codigo_flujo', 'codigo_paso', 'estado_paso', 'codigo_arbol', 'actualizado_por', 'creado_por','ro_rooc'], 'default', 'value' => null],
            [['emisor_persona_id', 'codigo_flujo', 'codigo_paso', 'estado_paso', 'codigo_arbol', 'actualizado_por', 'creado_por','periodo_id'], 'integer'],
            [['codigo_flujo','monto'],'required'],
            [['actualizado_en', 'creado_en','fecha_esperada'], 'safe'],
            ['monto','number'],
            [['descripcion'], 'string', 'max' => 255],
            [['codigo_arbol'], 'exist', 'skipOnError' => true, 'targetClass' => PresupuestoCabecera::className(), 'targetAttribute' => ['codigo_arbol' => 'presupuesto_cabecera_id']],
            [['codigo_flujo'], 'exist', 'skipOnError' => true, 'targetClass' => FlujoFlujo::className(), 'targetAttribute' => ['codigo_flujo' => 'flujo_flujo_id']],
            [['codigo_paso'], 'exist', 'skipOnError' => true, 'targetClass' => FlujoPaso::className(), 'targetAttribute' => ['codigo_paso' => 'flujo_paso_id']],
            [['estado_paso'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['estado_paso' => 'metacodigo_id']],
            [['emisor_persona_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffPersona::className(), 'targetAttribute' => ['emisor_persona_id' => 'staff_persona_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            ['observacion', 'string'],
            ['codigo_requerimiento','integer'],
            // ['monto','validarMontoRequerimiento'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'flujo_requerimiento_id' => 'Flujo Requerimiento ID',
            'descripcion' => 'Descripcion',
            'emisor_persona_id' => 'Emisor',
            'codigo_flujo' => 'Requerimiento',
            'codigo_paso' => 'Flujo paso',
            'estado_paso' => 'Estado paso',
            'fecha_instanciacion' => 'Fecha instanciación',
            'fecha_esperada' => 'Fecha esperada',
            'codigo_arbol' => 'Línea - presupuesto',
            'periodo_id' => 'Periodo',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
            'area_aprobadora_id' => 'Área aprobadora',
            'observacion' => 'Observación',
            'flag_procesado' => 'Flag procesado',
            'codigo_requerimiento' => 'Código de requerimiento',
            'monto' => 'Monto requerido',
            'ro_rooc' => 'Ro/Rooc'


        ];
    }

    static function getComboBoxPeriodosDisponibles(){
        return PresupuestoCabecera::getComboBoxPeriodosDisponibles($this->codigo_arbol);
    }

    public function getComboBoxParaAdquisiciones(){
        $persona_id = Yii::$app->user->identity->persona_id;
        $objeto_metacodigo = new Metacodigo();
        $objeto_metacodigo = $objeto_metacodigo->find()->where(['nombre_lista'=>'Estado_paso','descripcion'=>'Adquisición'])->one();        

        $objeto_flujo_requerimiento = new FlujoRequerimiento();
        $array_flujo_requerimiento = $objeto_flujo_requerimiento->find()
            ->join( 'INNER JOIN','flujo_paso','flujo_paso.flujo_paso_id = flujo_requerimiento.codigo_paso') 
            ->join( 'INNER JOIN','staff_area','staff_area.staff_area_id = flujo_paso.area_responsable_id')  
            ->andFilterWhere(['=', 'staff_area.responsable', $persona_id])
            ->andFilterWhere(['=', 'estado_paso', $objeto_metacodigo->metacodigo_id])
            ->andFilterWhere(['=', 'flujo_requerimiento.ticket', false])
            ->andFilterWhere(['!=', 'flag_procesado', 1])
            ->select(['flujo_requerimiento.flujo_requerimiento_id','flujo_requerimiento.descripcion']) 
            ->all();

        $array_flujo_requerimiento = ArrayHelper::map($array_flujo_requerimiento, 'flujo_requerimiento_id', 'descripcion');
        return $array_flujo_requerimiento;
    }

    static function validarMontoRequerimiento($codigo_arbol, $periodo_id, $ro_rooc, $monto){
        $presupuesto_disponible = PresupuestoCabecera::find()->where(['presupuesto_cabecera_id'=>$codigo_arbol])->one();
        $presupuesto_disponible = $presupuesto_disponible->obtenerPresupuestoDisponible($periodo_id);
        if($ro_rooc==1)
            if($monto>$presupuesto_disponible['ro'])
                return 0;

        if($ro_rooc==0)
            if($monto>$presupuesto_disponible['rooc'])
                return 0;
        return 1;
    }

    public function getPasoActual(){
        $objeto_flujo_paso = new FlujoPaso();
        $objeto_actual_flujo_paso = $objeto_flujo_paso->findById($this->codigo_paso);

        return ArrayHelper::map($objeto_actual_flujo_paso, 'flujo_paso_id_id', 'nombre_paso');
        
    }

    //devuelve las opciones (nombre de paso y flujo paso id) del siguiente nivel del flujo paso(?)
    public function getOpcionesSiguienteNivel(){
        $array_flujo_paso = $this->codigoPaso->getFlujoPasosSiguientes();

        $rpta = [];
        foreach ($array_flujo_paso as $flujo_paso){
            if ($flujo_paso->areaResponsable){
                $rpta[$flujo_paso->flujo_paso_id] = $flujo_paso->nombre_paso ." | ".$flujo_paso->areaResponsable->descripcion;
            }
            else{
                $rpta[$flujo_paso->flujo_paso_id] = $flujo_paso->nombre_paso ." | Área requisitoria";
            }
            
        }
        return $rpta;
        return ArrayHelper::map($array_flujo_paso,'flujo_paso_id','nombre_paso');
    }

    public function getOpcionesSiguienteNivel22(){
        $objeto_flujo_paso = new FlujoPaso();
        $objeto_actual_flujo_paso = $objeto_flujo_paso->findById($this->codigo_paso);
        $siguiente_nivel = $objeto_actual_flujo_paso->nivel +1;
        $array_flujo_paso = FlujoPaso::find()->where([
            'nivel' => $siguiente_nivel,
            'primer_flujo_paso' => $objeto_actual_flujo_paso->primer_flujo_paso
        ])->all();

        return ArrayHelper::map($array_flujo_paso,'flujo_paso_id','nombre_paso');
    }

    public function avanzarPaso($flujo_paso_id,$observacion){
        
        $this->observacion = $observacion;
        $this->flag_procesado = '1';
        $this->save();
        
        $objeto_flujo_flujo = new FlujoFlujo();
        $objeto_flujo_flujo = $objeto_flujo_flujo->find()->where(['flujo_flujo_id'=>$this->codigo_flujo])->one();
        $primer_flujo_paso = $objeto_flujo_flujo->getPrimerPaso();

        $objeto_flujo_paso = new FlujoPaso();
        $objeto_flujo_paso = $objeto_flujo_paso->findById($flujo_paso_id);
        
        $objeto_area = StaffArea::find()->where(['responsable' => $this->emisor_persona_id])->one();

        $nuevo_flujo_requerimiento = new FlujoRequerimiento();
        $nuevo_flujo_requerimiento->codigo_requerimiento = $this->codigo_requerimiento;
        $nuevo_flujo_requerimiento->descripcion = $this->descripcion;
        $nuevo_flujo_requerimiento->emisor_persona_id = $this->emisor_persona_id;
        $nuevo_flujo_requerimiento->codigo_flujo = $this->codigo_flujo;
        $nuevo_flujo_requerimiento->codigo_paso = $flujo_paso_id;
        $nuevo_flujo_requerimiento->estado_paso = $objeto_flujo_paso->estado_paso_metacodigo;
        $nuevo_flujo_requerimiento->codigo_arbol = $this->codigo_arbol;
        $nuevo_flujo_requerimiento->periodo_id = $this->periodo_id;
        $nuevo_flujo_requerimiento->monto = $this->monto;
        if($objeto_flujo_paso->area_responsable_id){
            $nuevo_flujo_requerimiento->area_aprobadora_id = $objeto_flujo_paso->area_responsable_id;
        }
        else{
            $nuevo_flujo_requerimiento->area_aprobadora_id = $objeto_area->staff_area_id;
        }
        
        $nuevo_flujo_requerimiento->ro_rooc = $this->ro_rooc;

        $fecha_esperada = strtotime ('+'.$objeto_flujo_paso->cantidad_dias.' day', strtotime($this->fecha_esperada));
        $fecha_esperada_date = date('Y-m-d H:i:s', $fecha_esperada);
        $nuevo_flujo_requerimiento->fecha_esperada = $fecha_esperada_date;


        $nuevo_flujo_requerimiento->save();

        

        $objeto_metacodigo = new Metacodigo();
        $objeto_metacodigo = $objeto_metacodigo->find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Adquisición'])->one();
        if($objeto_flujo_flujo->tipo_flujo_metacodigo == $objeto_metacodigo->metacodigo_id ){/////////
            $objeto_adquisicion = Adquisicion::find()->where(['flujo_requerimiento_id'=>$this->flujo_requerimiento_id])->one();

            if($objeto_adquisicion){
                $objeto_adquisicion->flujo_requerimiento_id = $nuevo_flujo_requerimiento->flujo_requerimiento_id;
                $objeto_adquisicion->save(false);
            }
        }
    }

    public function findById($id){
        return static::findOne(['flujo_requerimiento_id' => $id]);
    }

    static function getComboBoxItems(){
        $items  = FlujoRequerimiento::find()->all();
        return ArrayHelper::map($items, 'flujo_requerimiento_id', 'descripcion');
    }

    //filtrados para flujo de persona logeada y aprobados
    static function getComboBoxItemsFiltrados($tipo_fondo){
        $persona_id = Yii::$app->user->identity->persona_id;
        $metacodigo = new Metacodigo();
        $metacodigo_filtrado_id_estado = $metacodigo->getMetacodigoId('Estado_paso', 'Aprobado');
        //falta especificar si es caja chica, viatico, etc dependiendo de que controlador se mande
        $metacodigo_filtrado_id_tipo = $metacodigo->getMetacodigoId('Tipo_flujo', $tipo_fondo);
        //jalar todos los fluj req donde el tipo de flujo flujo sea viatico
        $items = FlujoRequerimiento::find()
            ->joinWith(['codigoFlujo'])
            ->where(['flujo_flujo.tipo_flujo_metacodigo' => $metacodigo_filtrado_id_tipo])
            ->andFilterWhere(['=', 'flujo_requerimiento.emisor_persona_id', $persona_id])
            ->andFilterWhere(['=', 'flujo_requerimiento.estado_paso', $metacodigo_filtrado_id_estado])
            ->andFilterWhere(['=', 'flujo_requerimiento.ticket', false])
            ->all();
            
        //var_dump($items);

        return ArrayHelper::map($items, 'codigo_requerimiento', 'descripcion');
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
    public function getCodigoArbol()
    {
        return $this->hasOne(PresupuestoCabecera::className(), ['presupuesto_cabecera_id' => 'codigo_arbol']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigoFlujo()
    {
        return $this->hasOne(FlujoFlujo::className(), ['flujo_flujo_id' => 'codigo_flujo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigoPaso()
    {
        return $this->hasOne(FlujoPaso::className(), ['flujo_paso_id' => 'codigo_paso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoPaso()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'estado_paso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmisorPersona()
    {
        return $this->hasOne(StaffPersona::className(), ['staff_persona_id' => 'emisor_persona_id'])->from(['emisorPersona' => StaffPersona::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaAprobadora()
    {
        return $this->hasOne(StaffArea::className(), ['staff_area_id' => 'area_aprobadora_id'])->from(['areaAprobadora' => StaffArea::tableName()]);
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
    public function getFondoFondos()
    {
        return $this->hasMany(FondoFondo::className(), ['requerimiento_flujo_id' => 'flujo_requerimiento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoRendicionCajaChicas()
    {
        return $this->hasMany(FondoRendicionCajaChica::className(), ['requerimiento_flujo' => 'flujo_requerimiento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoRendicionEncargos()
    {
        return $this->hasMany(FondoRendicionEncargo::className(), ['requerimiento_flujo_id' => 'flujo_requerimiento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoRendicionViaticos()
    {
        return $this->hasMany(FondoRendicionViatico::className(), ['requerimiento_flujo' => 'flujo_requerimiento_id']);
    }

    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
             if(Yii::$app->user->isGuest)
                return false;     

            $this->actualizado_por= Yii::$app->user->identity->usuario_id;   
            $this->actualizado_en = date('Y-m-d H:i:s');

            if ($this->isNewRecord) {
                $this->creado_por = Yii::$app->user->identity->usuario_id;
                $this->creado_en = date('Y-m-d H:i:s');
                $this->fecha_instanciacion = date('Y-m-d H:i:s');

                if(!$this->emisor_persona_id)
                    $this->emisor_persona_id = Yii::$app->user->identity->persona_id;

                $objeto_flujo_flujo = new FlujoFlujo();
                $objeto_flujo_flujo = $objeto_flujo_flujo->findById($this->codigo_flujo);
                $primer_flujo_paso = $objeto_flujo_flujo->getPrimerPaso();
                $persona_id = Yii::$app->user->identity->persona_id;
                $objeto_area = StaffArea::find()->where(['responsable' => $this->emisor_persona_id])->one();
                
                if(!$this->codigo_paso)
                    $this->codigo_paso = $primer_flujo_paso->flujo_paso_id;
                
//                $paso_actual = FlujoPaso::find()->where(['flujo_paso_id' => $this->codigo_paso])->one();
//                //llenar el campo de area_id_que_crea para guardar al usuario en el nivel 1 que esta iniciando el requerimiento
//                //solo se tiene que guardar una vez, si no tiene valor ese campo
//                if ($paso_actual->nivel == 1 && $paso_actual->area_responsable_id == null){
//                    $this->area_id_que_crea = $objeto_area->staff_area_id;
//                    $primer_flujo_paso->save();
//                }
                

                if(!$this->estado_paso)
                    $this->estado_paso = $primer_flujo_paso->estado_paso_metacodigo;
                if(!$this->area_aprobadora_id){
                    if ($primer_flujo_paso->area_responsable_id){
                        $this->area_aprobadora_id = $primer_flujo_paso->area_responsable_id;
                    }
                    else{
                        $this->area_aprobadora_id = $objeto_area->staff_area_id;
                    }
                }
                if(!$this->fecha_esperada)
                    $this->fecha_esperada = date('Y-m-d H:i:s');

                $objeto_metacodigo = new Metacodigo();
                $objeto_metacodigo = $objeto_metacodigo->find()->where(['nombre_lista'=>'Estado_paso','descripcion'=>'Desaprobado'])->one();

                if($this->estado_paso==$objeto_metacodigo->metacodigo_id){
                    $this->estadoPasoDesaprobado();
                }
                else
                    $this->procesarPresupuesto();
                //para llenar el campo de ticket cuando se crea un requerimiento, si hay uno asociado a un fondo le pone true para que no salga de nuevo en fondos disponibles 
                $model_fondo = FondoFondo::find()->all();                 
                foreach ($model_fondo as $fondo){                     
                    if($fondo->requerimiento_flujo_id){                         
                        if ($fondo->requerimiento_flujo_id == $this->codigo_requerimiento){
                            $this->ticket = true;
                        } 
                        else{                             
                            $this->ticket = false;                                   
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes){
        if(!Yii::$app->user->isGuest){
            if($insert){
                if(!$this->codigo_requerimiento){
                    $this->codigo_requerimiento = $this->flujo_requerimiento_id;
                }

                $this->save();
            }
            parent::afterSave($insert, $changedAttributes);
            return true;
        }
        return false;
    }

    public function estadoPasoDesaprobado(){
        $this->flag_procesado='0';
        $monto = $this->monto - $this->monto - $this->monto;
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);
        if($this->getUltimoProcesamiento()!='')
            $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $monto, $this->getUltimoProcesamiento());

    }
    
    public function asignarDocumentos($array_documentos_id){     
        foreach($array_documentos_id as $documento_actual){
            $objeto_requerimiento_documento = new RequerimientoDocumento();
            $objeto_requerimiento_documento->flujo_requerimiento_id = $this->flujo_requerimiento_id;
            $objeto_requerimiento_documento->documento_pnia_id = $documento_actual;
            $objeto_requerimiento_documento->save(false);
        }
    }
    
    public function getSearchListaRequerimientos()
    {
        $searchModelListaRequerimientos = new FlujoRequerimientoSearch();
        return $searchModelListaRequerimientos;
    }
    
    public function getDataProviderListaRequerimientos($codigo_requerimiento)
    {
        $searchModelListaRequerimientos = new FlujoRequerimientoSearch();
        $dataProviderListaRequerimientos = $searchModelListaRequerimientos->searchListaRequerimientos(Yii::$app->request->queryParams, $codigo_requerimiento);
        return $dataProviderListaRequerimientos;
    }


    public function getUltimoProcesamiento(){

        $objeto_flujo_paso = FlujoPaso::find()->where(['flujo_paso_id'=>$this->codigo_paso])->one();

        while (true) {
            if($objeto_flujo_paso->nivel==1){
                return false;
            }

            if (isset($objeto_flujo_paso->nivel_siguiente) and $objeto_flujo_paso->nivel_siguiente != null){
                $objeto_flujo_paso = $objeto_flujo_paso->find()->where([
                    'flujo'=>$objeto_flujo_paso->flujo,
                    'nivel_siguiente'=>$objeto_flujo_paso->nivel])->one();
            }else{
                $objeto_flujo_paso = $objeto_flujo_paso->find()->where([
                        'flujo'=>$objeto_flujo_paso->flujo,
                        'nivel'=>$objeto_flujo_paso->nivel-1]
                )->one();
            }

            /*
            $objeto_flujo_paso = $objeto_flujo_paso->find()->where([
                'flujo'=>$objeto_flujo_paso->flujo,
                'nivel_siguiente'=>$objeto_flujo_paso->nivel])->one();

            if ($objeto_flujo_paso == null){
                $objeto_flujo_paso = $objeto_flujo_paso->find()->where([
                    'flujo'=>$objeto_flujo_paso->flujo,
                    'nivel'=>$objeto_flujo_paso->nivel-1])->one();
            }// */

            switch ($objeto_flujo_paso->proceso_presupuesto) {
                case 'Certificado':
                    if($this->ro_rooc==1)
                        return 'presupuesto_certificado_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_certificado_rooc';
                    break;
                case 'Comprometido':
                    if($this->ro_rooc==1)
                        return 'presupuesto_compromiso_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_compromiso_rooc';
                    break;
                case 'Devengado':
                    if($this->ro_rooc==1)
                        return 'presupuesto_devengado_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_devengado_rooc';
                    break;
                case 'Girado':
                    if($this->ro_rooc==1)
                        return 'presupuesto_girado_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_girado_rooc';
                    break;
                case 'Pagado':
                    if($this->ro_rooc==1)
                        return 'presupuesto_pagado_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_pagado_rooc';
                    break;
                case 'Ejecutado':
                    if($this->ro_rooc==1)
                        return 'presupuesto_ejecutado_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_ejecutado_rooc';
                    break;
            }
        }
    }

    public function getUltimoProcesamiento22(){
        $objeto_flujo_paso = new FlujoPaso();
        $objeto_flujo_paso = $objeto_flujo_paso->find()->where(['flujo_paso_id'=>$this->codigo_paso])->one();

        while (true) {   
            if($objeto_flujo_paso->nivel==1){
                return false;
            }

            $objeto_flujo_paso = $objeto_flujo_paso->find()->where(['flujo'=>$objeto_flujo_paso->flujo,'nivel'=>$objeto_flujo_paso->nivel-1])->one();

            switch ($objeto_flujo_paso->proceso_presupuesto) {
                case 'Certificado':
                    if($this->ro_rooc==1)
                        return 'presupuesto_certificado_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_certificado_rooc';
                    break;
                case 'Comprometido':
                    if($this->ro_rooc==1)
                        return 'presupuesto_compromiso_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_compromiso_rooc';
                    break;
                case 'Devengado':
                    if($this->ro_rooc==1)
                        return 'presupuesto_devengado_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_devengado_rooc';
                    break;
                case 'Girado':
                    if($this->ro_rooc==1)
                        return 'presupuesto_girado_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_girado_rooc';
                    break;
                case 'Pagado':
                    if($this->ro_rooc==1)
                        return 'presupuesto_pagado_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_pagado_rooc';
                    break;
                case 'Ejecutado':
                    if($this->ro_rooc==1)
                        return 'presupuesto_ejecutado_ro';
                    if($this->ro_rooc==0)
                        return 'presupuesto_ejecutado_rooc';
                    break;     
            }
        }        
    }

    public function procesarPresupuesto(){           
        $objeto_flujo_paso = new FlujoPaso();
        $opcion = $objeto_flujo_paso->find()->where(['flujo_paso_id'=>$this->codigo_paso])->one()->proceso_presupuesto;
        
        switch ($opcion) {
            case 'Certificado':
                $ultimo_procesamiento = $this->getUltimoProcesamiento();
                if($ultimo_procesamiento==false)
                    return $this->crearRequerimientoCertificado();
                else
                    return $this->moverRequerimientoACertificado($ultimo_procesamiento);
                break;
            case 'Comprometido':
                $ultimo_procesamiento = $this->getUltimoProcesamiento();
                if($ultimo_procesamiento==false)
                    return $this->crearRequerimientoComprometido();
                else
                    return $this->moverRequerimientoAComprometido($ultimo_procesamiento);
                break;
            case 'Devengado':
                $ultimo_procesamiento = $this->getUltimoProcesamiento();
                if($ultimo_procesamiento==false)
                    return $this->crearRequerimientoDevengado();
                else
                    return $this->moverRequerimientoADevengado($ultimo_procesamiento);
                break;
            case 'Girado':
                $ultimo_procesamiento = $this->getUltimoProcesamiento();
                if($ultimo_procesamiento==false)
                    return $this->crearRequerimientoGirado();
                else
                    return $this->moverRequerimientoAGirado($ultimo_procesamiento);
                break;
            case 'Pagado':
                $ultimo_procesamiento = $this->getUltimoProcesamiento();
                if($ultimo_procesamiento==false)
                    return $this->crearRequerimientoPagado();
                else
                    return $this->moverRequerimientoAPagado($ultimo_procesamiento);
                break;
            case 'Ejecutado':
                $ultimo_procesamiento = $this->getUltimoProcesamiento();
                if($ultimo_procesamiento==false)
                    return $this->crearRequerimientoEjecutado();
                else
                    return $this->moverRequerimientoAEjecutado($ultimo_procesamiento);
                break;
        }

    }
    
    public function crearRequerimientoCertificado(){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_certificado_ro');  
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_certificado_rooc');

    }

    public function crearRequerimientoComprometido(){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_compromiso_ro');  
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_compromiso_rooc');

    }

    public function crearRequerimientoDevengado(){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_devengado_ro');
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_devengado_rooc');
    }

    public function crearRequerimientoGirado(){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_girado_ro');
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_girado_rooc');
    }

    public function crearRequerimientoPagado(){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_pagado_ro');
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_pagado_rooc');
    }

    public function crearRequerimientoEjecutado(){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_ejecutado_ro');
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->crearRequerimiento($this->periodo_id, $this->monto,'presupuesto_ejecutado_rooc');
    }


    public function moverRequerimientoACertificado($de_campo){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_certificado_ro',$this->monto);
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_certificado_rooc',$this->monto);
    }
    
    public function moverRequerimientoAComprometido($de_campo){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_compromiso_ro',$this->monto);
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_compromiso_rooc',$this->monto);
    }

    public function moverRequerimientoADevengado($de_campo){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_devengado_ro',$this->monto);
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_devengado_rooc',$this->monto);
    }

    public function moverRequerimientoAGirado($de_campo){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_girado_ro',$this->monto);
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_girado_rooc',$this->monto);
    }

    public function moverRequerimientoAPagado($de_campo){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_pagado_ro',$this->monto);
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_pagado_rooc',$this->monto);
    }

    public function moverRequerimientoAEjecutado($de_campo){
        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($this->codigo_arbol);

        if($this->ro_rooc==1)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_ejecutado_ro',$this->monto);
        if($this->ro_rooc==0)
            return $objeto_presupuesto_cabecera->moverMontos($this->periodo_id,$de_campo,'presupuesto_ejecutado_rooc',$this->monto);
    }

    
}
