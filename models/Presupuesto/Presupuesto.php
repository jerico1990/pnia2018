<?php

namespace app\models\Presupuesto;

use app\models\ModeloGenerico;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use Yii;

/**
 * This is the model class for table "presupuesto".
 *
 * @property int $presupuesto_id
 * @property int $periodo_id
 * @property int $presupuesto_cabecera_id
 * @property double $presupuesto_plan_ro
 * @property double $presupuesto_plan_rooc
 * @property double $presupuesto_certificado_ro
 * @property double $presupuesto_certificado_rooc
 * @property double $presupuesto_planificado_ro
 * @property double $presupuesto_planificado_rooc
 * @property double $presupuesto_ejecutado_ro
 * @property double $presupuesto_ejecutado_rooc
 * @property double $presupuesto_saldo_ro
 * @property double $presupuesto_saldo_rooc
 * @property double $presupuesto_saldo_anual_ro
 * @property double $presupuesto_saldo_anual_rooc
 * @property int $estado
 * @property double $presupuesto_compromiso_ro
 * @property double $presupuesto_compromiso_rooc
 * @property double $presupuesto_devengado_ro
 * @property double $presupuesto_devengado_rooc
 * @property double $presupuesto_girado_ro
 * @property double $presupuesto_girado_rooc
 * @property double $presupuesto_pagado_ro
 * @property double $presupuesto_pagado_rooc
 * @property double $presupuesto_ejecucion_posterior_ro
 * @property double $presupuesto_ejecucion_posterior_rooc
 * @property double $presupuesto_prestado_ro
 * @property double $presupuesto_prestado_rooc
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Metacodigo $estado0
 * @property Periodo $periodo
 * @property PresupuestoCabecera $presupuestoCabecera
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class Presupuesto extends ModeloGenerico
{
    /// variables adicionales:
    public $linea_id_fk;
    public $por_prestar_ro;// = 0;
    public $por_prestar_rooc;// = 0;
    public $esta_actualizado = false;
    public $copia_previa  = null;
    public $plan_alterado = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'presupuesto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actualizado_en', 'creado_en', 'copia_previa','plan_alterado'], 'safe'],
            [['periodo_id', 'presupuesto_cabecera_id', 'estado'], 'required'],
            [['periodo_id', 'presupuesto_cabecera_id', 'estado', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['periodo_id', 'presupuesto_cabecera_id', 'estado', 'actualizado_por', 'creado_por'], 'integer'],
            [[  'presupuesto_plan_ro', 'presupuesto_plan_rooc',
                'presupuesto_certificado_ro', 'presupuesto_certificado_rooc',
                'presupuesto_planificado_ro', 'presupuesto_planificado_rooc',
                'presupuesto_ejecutado_ro'  , 'presupuesto_ejecutado_rooc',
                'presupuesto_saldo_ro'      , 'presupuesto_saldo_rooc',
                'presupuesto_saldo_anual_ro', 'presupuesto_saldo_anual_rooc',
                'presupuesto_compromiso_ro' , 'presupuesto_compromiso_rooc',
                'presupuesto_devengado_ro'  , 'presupuesto_devengado_rooc',
                'presupuesto_girado_ro'     , 'presupuesto_girado_rooc',
                'presupuesto_pagado_ro'     , 'presupuesto_pagado_rooc',
                'presupuesto_ejecucion_posterior_ro', 'presupuesto_ejecucion_posterior_rooc',
                'presupuesto_prestado_ro'   , 'presupuesto_prestado_rooc',
                'por_prestar_ro'            ,'por_prestar_rooc'], 'number'],
            [[  'presupuesto_plan_ro'       ,'presupuesto_plan_rooc',
                'presupuesto_certificado_ro', 'presupuesto_certificado_rooc',
                'presupuesto_ejecutado_ro'  ,'presupuesto_ejecutado_rooc',
                'presupuesto_compromiso_ro' ,'presupuesto_compromiso_rooc',
                'presupuesto_devengado_ro'  ,'presupuesto_devengado_rooc',
                'presupuesto_girado_ro'     ,'presupuesto_girado_rooc',
                'presupuesto_pagado_ro'     ,'presupuesto_pagado_rooc'], 'verificarPresupuestos'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['estado' => 'metacodigo_id']],
            [['periodo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Periodo::className(), 'targetAttribute' => ['periodo_id' => 'periodo_id']],
            [['presupuesto_cabecera_id'], 'exist', 'skipOnError' => true, 'targetClass' => PresupuestoCabecera::className(), 'targetAttribute' => ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']],
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
            'presupuesto_id' => 'Presupuesto ID',
            'periodo_id' => 'Periodo ID',
            'presupuesto_cabecera_id' => 'Presupuesto Cabecera ID',
            'presupuesto_plan_ro'   => 'Presupuesto Plan Ro',
            'presupuesto_plan_rooc' => 'Presupuesto Plan Rooc',
            'presupuesto_certificado_ro'    => 'Presupuesto Certificado Ro',
            'presupuesto_certificado_rooc'  => 'Presupuesto Certificado Rooc',
            'presupuesto_planificado_ro'    => 'Presupuesto Planificado Ro',
            'presupuesto_planificado_rooc'  => 'Presupuesto Planificado Rooc',
            'presupuesto_ejecutado_ro'      => 'Presupuesto Ejecutado Ro',
            'presupuesto_ejecutado_rooc'    => 'Presupuesto Ejecutado Rooc',
            'presupuesto_saldo_ro'          => 'Presupuesto Saldo Ro',
            'presupuesto_saldo_rooc'        => 'Presupuesto Saldo Rooc',
            'presupuesto_saldo_anual_ro'    => 'Presupuesto Saldo Anual Ro',
            'presupuesto_saldo_anual_rooc'  => 'Presupuesto Saldo Anual Rooc',
            'presupuesto_compromiso_ro'     => 'Presupuesto Compromiso Ro',
            'presupuesto_compromiso_rooc'   => 'Presupuesto Compromiso Rooc',
            'presupuesto_devengado_ro'   => 'Presupuesto Devengado Ro',
            'presupuesto_devengado_rooc' => 'Presupuesto Devengado Rooc',
            'presupuesto_girado_ro'     => 'Presupuesto Girado Ro',
            'presupuesto_girado_rooc'   => 'Presupuesto Girado Rooc',
            'presupuesto_pagado_ro'     => 'Presupuesto Pagado Ro',
            'presupuesto_pagado_rooc'   => 'Presupuesto Pagado Rooc',
            'presupuesto_ejecucion_posterior_ro'    => 'Presupuesto Ejecucion Posterior Ro',
            'presupuesto_ejecucion_posterior_rooc'  => 'Presupuesto Ejecucion Posterior Rooc',
            'presupuesto_prestado_ro'   => 'Presupuesto Prestado Ro',
            'presupuesto_prestado_rooc' => 'Presupuesto Prestado Rooc',
            'estado' => 'Estado',
            'actualizado_en'    => 'Actualizado En',
            'actualizado_por'   => 'Actualizado Por',
            'creado_en'     => 'Creado En',
            'creado_por'    => 'Creado Por',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'estado']);
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
    public function getPresupuestoCabecera()
    {
        return $this->hasOne(PresupuestoCabecera::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']);
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
     * @return \yii\db\ActiveQuery   LineaNivel
     */
    public function getLinea()
    {
        return $this->hasOne(LineaNivel::className(),['linea_nivel_id' => 'linea_nivel_id'])
            ->viaTable(PresupuestoCabecera::tableName(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id'])
            ->leftJoin(Linea::tableName(),'linea.linea_id = linea_nivel.linea_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoActual()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'estado']);
    }

    /**
     * @return bool : Determina si un capo ha de ser solo de lectura o  no
     */
    public function esDeSoloLectura(){
        return !$this->periodo->estatus_abierto;
    }

    /**
     * @return \yii\db\ActiveQuery : periodos relacionados a los presupuestos asignados a esta cabecera
     */
    public function getPeriodos(){
        return $this->hasOne(Periodo::className(),['periodo_id' => 'periodo_id'])
            ->viaTable(Presupuesto::tableName(),['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']);
    }

    /**
     * @return Presupuesto|null : crea una copia del objeto actual, como un objeto nuevo, listo para guardar
     */
    public function getACopy()
    {
        if(Yii::$app->user->isGuest)
        {
            return null;
        }

        $clon = new Presupuesto(
            $this->getAttributes([
                'presupuesto_cabecera_id',
                'periodo_id',
                'estado',
                'presupuesto_plan_ro',
                'presupuesto_plan_rooc',
                'presupuesto_certificado_ro',
                'presupuesto_certificado_rooc',
                'presupuesto_planificado_ro',
                'presupuesto_planificado_rooc',
                'presupuesto_ejecutado_ro',
                'presupuesto_ejecutado_rooc',
                'presupuesto_saldo_ro',
                'presupuesto_saldo_rooc',
                'presupuesto_saldo_anual_ro',
                'presupuesto_saldo_anual_rooc',
                'presupuesto_compromiso_ro',
                'presupuesto_compromiso_rooc',
                'presupuesto_devengado_ro',
                'presupuesto_devengado_rooc',
                'presupuesto_girado_ro',
                'presupuesto_girado_rooc',
                'presupuesto_pagado_ro',
                'presupuesto_pagado_rooc',
                'presupuesto_prestado_ro',
                'presupuesto_prestado_rooc',
                'presupuesto_ejecucion_posterior_ro',
                'presupuesto_ejecucion_posterior_rooc'
            ]));
        $clon->isNewRecord    = true;
        $clon->actualizado_por= Yii::$app->user->identity->usuario_id;
        $clon->actualizado_en = date('Y-m-d H:i:s');
        $clon->creado_por     = Yii::$app->user->identity->usuario_id;
        $clon->creado_en      = date('Y-m-d H:i:s');

        return $clon;
    }

    /**
     * @param bool $reiniciar_plan_Ro_y_Rooc                = false : no debe reiniciarse pues es un dato ingresado manualmente
     * @param bool $reiniciar_planificado_Ro_y_Rooc         = true  : se reinicia pues es re-calculado en la validación
     * @param bool $reiniciar_ejecucion_posterior_Ro_y_Rooc = true  : se reinicia pues debe sumarse desde los hijos
     * @param bool $reiniciar_prestado_plan_Ro_yRooc        = false : se reinicia pues debe sumarse desde los hijos
     */
    public function reiniciarPresupuestos($reiniciar_plan_Ro_y_Rooc = false,
                                          $reiniciar_planificado_Ro_y_Rooc = true,
                                          $reiniciar_ejecucion_posterior_Ro_y_Rooc = true,
                                          $reiniciar_prestado_plan_Ro_yRooc = false)
    {
        if ($reiniciar_plan_Ro_y_Rooc){
            $this->presupuesto_plan_ro         = 0;
            $this->presupuesto_plan_rooc       = 0;
        }
        if ($reiniciar_planificado_Ro_y_Rooc){
            $this->presupuesto_planificado_ro  = 0;
            $this->presupuesto_planificado_rooc= 0;
        }
        if ($reiniciar_prestado_plan_Ro_yRooc){
            $this->presupuesto_prestado_ro   = 0;
            $this->presupuesto_prestado_rooc = 0;
        }
        if($reiniciar_ejecucion_posterior_Ro_y_Rooc){
            $this->presupuesto_ejecucion_posterior_ro = 0;
            $this->presupuesto_ejecucion_posterior_rooc = 0;
        }

        $this->presupuesto_ejecutado_ro    = 0;
        $this->presupuesto_ejecutado_rooc  = 0;
        $this->presupuesto_saldo_ro        = 0;
        $this->presupuesto_saldo_rooc      = 0;
        $this->presupuesto_compromiso_ro   = 0;
        $this->presupuesto_compromiso_rooc = 0;
        $this->presupuesto_devengado_ro    = 0;
        $this->presupuesto_devengado_rooc  = 0;
        $this->presupuesto_girado_ro       = 0;
        $this->presupuesto_girado_rooc     = 0;
        $this->presupuesto_pagado_ro       = 0;
        $this->presupuesto_pagado_rooc     = 0;
        $this->presupuesto_saldo_anual_ro  = 0;
        $this->presupuesto_saldo_anual_rooc= 0;

    }

    /**
     * @param $presupuesto_hijo : le suma al presupuesto actual, el presupuesto hijo
     * @param bool $sumar_plan_Ro_y_Rooc : if true -> sumara tambien planRo y Rooc
     * @param bool $sumar_planificado_Ro_y_Rooc : if true -> sumara tambien planificadoRo y Rooc
     */
    public function sumarPresupuesto($presupuesto_hijo, $sumar_plan_Ro_y_Rooc = false,
                                     $sumar_planificado_Ro_y_Rooc = false,
                                     $sumar_ejecucion_posterior_Ro_y_Rooc = true ,
                                     $sumar_prestado_Ro_y_Rooc = true){
        if ((!isset($presupuesto_hijo) OR $presupuesto_hijo == null)){
            return;
        }
        if ($sumar_plan_Ro_y_Rooc) {
            $this->presupuesto_plan_ro   += $presupuesto_hijo->presupuesto_plan_ro;
            $this->presupuesto_plan_rooc += $presupuesto_hijo->presupuesto_plan_rooc;
        }

        if ($sumar_planificado_Ro_y_Rooc){
            $this->presupuesto_planificado_ro    += $presupuesto_hijo->presupuesto_planificado_ro;
            $this->presupuesto_planificado_rooc  += $presupuesto_hijo->presupuesto_planificado_rooc;
        }

        if ($sumar_ejecucion_posterior_Ro_y_Rooc){
            $this->presupuesto_ejecucion_posterior_ro   += $presupuesto_hijo->presupuesto_ejecucion_posterior_ro;
            $this->presupuesto_ejecucion_posterior_rooc += $presupuesto_hijo->presupuesto_ejecucion_posterior_rooc;
        }

        if ($sumar_prestado_Ro_y_Rooc){
            $this->presupuesto_prestado_ro   += $presupuesto_hijo->presupuesto_prestado_ro;
            $this->presupuesto_prestado_rooc += $presupuesto_hijo->presupuesto_prestado_rooc;
        }

        $this->presupuesto_certificado_ro    += $presupuesto_hijo->presupuesto_certificado_ro;
        $this->presupuesto_certificado_rooc  += $presupuesto_hijo->presupuesto_certificado_rooc;

        $this->presupuesto_compromiso_ro   	 += $presupuesto_hijo->presupuesto_compromiso_ro;
        $this->presupuesto_compromiso_rooc 	 += $presupuesto_hijo->presupuesto_compromiso_rooc;

        $this->presupuesto_devengado_ro    	 += $presupuesto_hijo->presupuesto_devengado_ro;
        $this->presupuesto_devengado_rooc  	 += $presupuesto_hijo->presupuesto_devengado_rooc;

        $this->presupuesto_girado_ro       	 += $presupuesto_hijo->presupuesto_girado_ro;
        $this->presupuesto_girado_rooc     	 += $presupuesto_hijo->presupuesto_girado_rooc;

        $this->presupuesto_pagado_ro       	 += $presupuesto_hijo->presupuesto_pagado_ro;
        $this->presupuesto_pagado_rooc     	 += $presupuesto_hijo->presupuesto_pagado_rooc;

        $this->presupuesto_ejecutado_ro    	 += $presupuesto_hijo->presupuesto_ejecutado_ro;
        $this->presupuesto_ejecutado_rooc  	 += $presupuesto_hijo->presupuesto_ejecutado_rooc;

    }

    /**
     * @param $presupuesto_hijo : le resta al presupuesto actual, el presupuesto hijo
     * @param bool $restar_plan_Ro_y_Rooc : if true -> restara tambien planRo y Rooc
     * @param bool $restar_planificado_Ro_y_Rooc : if true -> restara tambien planificadoRo y Rooc
     */
    public function restarPresupuesto($presupuesto_hijo, $restar_plan_Ro_y_Rooc = false,
                                      $restar_planificado_Ro_y_Rooc =false,
                                      $restar_ejecucion_posterior_ro_y_rooc = true,
                                      $restar_prestado_Ro_y_Rooc = true){
        if ((!isset($presupuesto_hijo) OR $presupuesto_hijo == null)){
            return;
        }

        if ($restar_plan_Ro_y_Rooc) {
            $this->presupuesto_plan_ro -= $presupuesto_hijo->presupuesto_plan_ro;
            $this->presupuesto_plan_rooc -= $presupuesto_hijo->presupuesto_plan_rooc;
        }

        if ($restar_planificado_Ro_y_Rooc){
            $this->presupuesto_planificado_ro    -= $presupuesto_hijo->presupuesto_planificado_ro;
            $this->presupuesto_planificado_rooc  -= $presupuesto_hijo->presupuesto_planificado_rooc;
        }

        if ($restar_ejecucion_posterior_ro_y_rooc){
            $this->presupuesto_ejecucion_posterior_ro   -= $presupuesto_hijo->presupuesto_ejecucion_posterior_ro;
            $this->presupuesto_ejecucion_posterior_rooc -= $presupuesto_hijo->presupuesto_ejecucion_posterior_rooc;
        }

        if ($restar_prestado_Ro_y_Rooc){
            $this->presupuesto_prestado_ro   -= $presupuesto_hijo->presupuesto_prestado_ro;
            $this->presupuesto_prestado_rooc -= $presupuesto_hijo->presupuesto_prestado_rooc;
        }

        $this->presupuesto_certificado_ro    -= $presupuesto_hijo->presupuesto_certificado_ro;
        $this->presupuesto_certificado_rooc  -= $presupuesto_hijo->presupuesto_certificado_rooc;

        $this->presupuesto_compromiso_ro   	 -= $presupuesto_hijo->presupuesto_compromiso_ro;
        $this->presupuesto_compromiso_rooc 	 -= $presupuesto_hijo->presupuesto_compromiso_rooc;

        $this->presupuesto_devengado_ro    	 -= $presupuesto_hijo->presupuesto_devengado_ro;
        $this->presupuesto_devengado_rooc  	 -= $presupuesto_hijo->presupuesto_devengado_rooc;

        $this->presupuesto_girado_ro       	 -= $presupuesto_hijo->presupuesto_girado_ro;
        $this->presupuesto_girado_rooc     	 -= $presupuesto_hijo->presupuesto_girado_rooc;

        $this->presupuesto_pagado_ro       	 -= $presupuesto_hijo->presupuesto_pagado_ro;
        $this->presupuesto_pagado_rooc     	 -= $presupuesto_hijo->presupuesto_pagado_rooc;

        $this->presupuesto_ejecutado_ro    	 -= $presupuesto_hijo->presupuesto_ejecutado_ro;
        $this->presupuesto_ejecutado_rooc  	 -= $presupuesto_hijo->presupuesto_ejecutado_rooc;

    }

    /**
     * Actualiza los presupuestos a nivel local, depende de la posición del presupuesto en el árbol de presupuestos(Raiz/Rama/Hoja)
     */
    public function actualizarLocalmente($ejecutado_posterior_ro , $ejecutado_posterior_rooc){

        $this->presupuesto_ejecucion_posterior_ro   += $ejecutado_posterior_ro;
        $this->presupuesto_ejecucion_posterior_rooc += $ejecutado_posterior_rooc;

        $this->presupuesto_planificado_ro   = $this->presupuesto_devengado_ro  + $this->presupuesto_girado_ro
                                            + $this->presupuesto_pagado_ro     + $this->presupuesto_ejecutado_ro
                                            + $this->presupuesto_compromiso_ro + $this->presupuesto_certificado_ro;

        $this->presupuesto_planificado_rooc = $this->presupuesto_devengado_rooc  + $this->presupuesto_girado_rooc
                                            + $this->presupuesto_pagado_rooc     + $this->presupuesto_ejecutado_rooc
                                            + $this->presupuesto_compromiso_rooc + $this->presupuesto_certificado_rooc;

        /*
        $mi_cabecera = $this->presupuestoCabecera;

        if($mi_cabecera->esHoja()){
            $this->presupuesto_plan_ro    = $this->presupuesto_planificado_ro;//   + $this->presupuesto_ejecucion_posterior_ro;
            $this->presupuesto_plan_rooc  = $this->presupuesto_planificado_rooc;// + $this->presupuesto_ejecucion_posterior_rooc;
            $this->presupuesto_saldo_ro   = 0;
            $this->presupuesto_saldo_rooc = 0;
        }else{// */
            /// por_prestar es una variable local que guardara cuanto se prestara el presupuesto actual

            $this->presupuesto_saldo_ro   = $this->presupuesto_plan_ro
                                          + $this->presupuesto_prestado_ro
                                          - $this->presupuesto_planificado_ro
                                          - $this->presupuesto_ejecucion_posterior_ro;

            /// ROOC

            $this->presupuesto_saldo_rooc = $this->presupuesto_plan_rooc
                                          + $this->presupuesto_prestado_rooc
                                          - $this->presupuesto_planificado_rooc
                                          - $this->presupuesto_ejecucion_posterior_rooc;
        // }
    }

    /**
     * Internamente establece si el padre tiene suficiente saldo,
     * caso contrario, y si el anterior puede prestar => returna true y establece saldo_insuficiente = true
     * @return bool : valida el presupuesto actual en base a su jerarquia (raiz/rama/hoja)
     */
    public function validarPresupuesto(){
        if ($this->esta_actualizado){
            return true;
        }
        $this->esta_actualizado = true;

        $mi_cabecera = $this->presupuestoCabecera;

        if($mi_cabecera->esRaiz()){
            $plan_ro   =  $mi_cabecera->getPresupuestos()->where('periodo_id != 1')->sum('presupuesto_plan_ro');
            $plan_rooc =  $mi_cabecera->getPresupuestos()->where('periodo_id != 1')->sum('presupuesto_plan_rooc');
            if ($this->periodo_id == 1){

                /// Aquí se valida verticalmente el plan, no hay padre, solo hijos
                // respecto a los hijos: verifica si hay suficiente dinero en plan ro/rooc para satisfacer a los hijos
                $plan_hijos     = $mi_cabecera->getSumPlanHijos(1);
                if ( $this->presupuesto_plan_ro   < $plan_hijos['ro'] OR
                    $this->presupuesto_plan_rooc  < $plan_hijos['rooc']) {
                    return false;
                }

                /// Aquí se valida horizontalmente el plan y se actualiza el saldo
                $this->presupuesto_saldo_ro   = $this->presupuesto_plan_ro   - $plan_ro;
                $this->presupuesto_saldo_rooc = $this->presupuesto_plan_rooc - $plan_rooc;

                return  $this->presupuesto_saldo_ro   >= 0 AND
                        $this->presupuesto_saldo_rooc >= 0;
            }else{
                $this->actualizarLocalmente(0,0);

                if ($this->presupuesto_saldo_ro < 0 OR $this->presupuesto_saldo_rooc < 0 ){
                    return false;
                }

                $estado_previo  = Presupuesto::findOne($this->presupuesto_id);
                $temp_plan_ro   = $this->presupuesto_plan_ro   - $estado_previo->presupuesto_plan_ro;
                $temp_plan_rooc = $this->presupuesto_plan_rooc - $estado_previo->presupuesto_plan_rooc;

                // esto permite comprobar si tiene un plan valido horizontalmente (respecto al periodo 0x0)
                if ( $temp_plan_ro != 0 OR $temp_plan_rooc != 0){
                    $presupuesto_origen = $mi_cabecera->getPresupuestos()->where(['periodo_id' => 1])->one();
                    if (($presupuesto_origen->presupuesto_saldo_ro - $temp_plan_ro < 0 ) OR
                        ($presupuesto_origen->presupuesto_saldo_rooc - $temp_plan_rooc < 0 )){
                        return false;
                    }
                }

                // esto permite comprobar si hay suficiente plan para respetar los plan-hijos
                $plan_hijos = $mi_cabecera->getSumPlanHijos($this->periodo_id);
                if ( $this->presupuesto_plan_ro   < $plan_hijos['ro'] OR
                     $this->presupuesto_plan_rooc < $plan_hijos['rooc']) {
                    return false;
                }else{
                    $this->plan_alterado = true;
                    $this->copia_previa = $estado_previo;
                    return true;
                }

            }
        }else{

        //if($mi_cabecera->esRama()){

            if ($this->periodo_id == 1){
                $estado_previo  = Presupuesto::findOne($this->presupuesto_id);
                $temp_plan_ro   = $this->presupuesto_plan_ro   - $estado_previo->presupuesto_plan_ro;
                $temp_plan_rooc = $this->presupuesto_plan_rooc - $estado_previo->presupuesto_plan_rooc;

                /// Aquí se valida verticalmente el plan, no hay padre, solo hijos
                // respecto a los hijos: verifica si hay suficiente dinero en plan ro/rooc para satisfacer a los hijos
                $plan_hijos     = $mi_cabecera->getSumPlanHijos(1);
                if ( $this->presupuesto_plan_ro   < $plan_hijos['ro'] OR
                     $this->presupuesto_plan_rooc < $plan_hijos['rooc']) {
                    return false;
                }

                // respecto al padre: verifica si hay suficiente dinero en el padre, en plan ro/rooc, para satisfacer a este($this) y sus hermanos
                $cabecera_padre    = $mi_cabecera->presupuestoCabeceraPadre;
                $plan_usado_padre  = $cabecera_padre->getSumPlanHijos($this->periodo_id);
                $presupuesto_padre = $cabecera_padre->getPresupuestoEn($this->periodo_id);

                if ($presupuesto_padre->presupuesto_plan_ro   < ($plan_usado_padre['ro'] + $temp_plan_ro) OR
                    $presupuesto_padre->presupuesto_plan_rooc < ($plan_usado_padre['rooc'] + $temp_plan_rooc)){
                    return false;
                }

                /// Aquí se valida horizontalmente el plan y se actualiza el saldo
                $planes_ro   =  $mi_cabecera->getPresupuestos()->where('periodo_id != 1')->sum('presupuesto_plan_ro');
                $planes_rooc =  $mi_cabecera->getPresupuestos()->where('periodo_id != 1')->sum('presupuesto_plan_rooc');

                $this->presupuesto_saldo_ro   = $this->presupuesto_plan_ro   - $planes_ro;
                $this->presupuesto_saldo_rooc = $this->presupuesto_plan_rooc - $planes_rooc;

                return  $this->presupuesto_saldo_ro   >= 0 AND
                        $this->presupuesto_saldo_rooc >= 0;
            }else{

                $this->actualizarLocalmente(0,0);

                if ($this->presupuesto_saldo_ro < 0 OR $this->presupuesto_saldo_rooc < 0 ){
                    return false;
                }

                $estado_previo  = Presupuesto::findOne($this->presupuesto_id);
                $temp_plan_ro   = $this->presupuesto_plan_ro   - $estado_previo->presupuesto_plan_ro;
                $temp_plan_rooc = $this->presupuesto_plan_rooc - $estado_previo->presupuesto_plan_rooc;

                if ( $temp_plan_ro != 0 OR $temp_plan_rooc != 0){
                    $presupuesto_origen = $mi_cabecera->getPresupuestos()->where(['periodo_id' => 1])->one();

                    // Aquí se comprueba si se tienen un planes validos horizontalmente (respecto al periodo 0x0)
                    if (($presupuesto_origen->presupuesto_saldo_ro   - $temp_plan_ro < 0 ) OR
                        ($presupuesto_origen->presupuesto_saldo_rooc - $temp_plan_rooc < 0 )){
                        return false;
                    }

                    // Aquí se comprueba si tienes un planes validos verticalmente (respecto al $this->periodo_id)
                    // respecto a los hijos: verifica si hay suficiente dinero en plan ro/rooc para satisfacer a los hijos
                    $plan_hijos         = $mi_cabecera->getSumPlanHijos($this->periodo_id);
                    if ( $this->presupuesto_plan_ro   < $plan_hijos['ro'] OR
                         $this->presupuesto_plan_rooc < $plan_hijos['rooc'] ) {
                        return false;
                    }

                    // respecto al padre: verifica si hay suficiente dinero en el padre, en plan ro/rooc, para satisfacer a este($this) y sus hermanos
                    $cabecera_padre    = $mi_cabecera->presupuestoCabeceraPadre;
                    $plan_usado_padre  = $cabecera_padre->getSumPlanHijos($this->periodo_id);
                    $presupuesto_padre = $cabecera_padre->getPresupuestoEn($this->periodo_id);

                    if ($presupuesto_padre->presupuesto_plan_ro   < ($plan_usado_padre['ro'] + $temp_plan_ro) OR
                        $presupuesto_padre->presupuesto_plan_rooc < ($plan_usado_padre['rooc'] + $temp_plan_rooc)){
                        return false;
                    }

                    // Si el plan Ro o Rooc fueron modificados y son validos, entonces se activa el flag "plan alterado"
                    // ello permite la actualización del presupuesto en el periodo 0x0
                    $this->plan_alterado = true;
                }

                $this->copia_previa = $estado_previo;

                // Apartir de aqui empezaran los procesos de prestamo
                return true;
            }
        }
        /*
        if($mi_cabecera->esHoja()){
            if ($this->periodo_id == 1){
                return false;
            }

            $this->actualizarLocalmente(0,0);
            $estado_previo     = Presupuesto::findOne(['presupuesto_id' => $this->presupuesto_id]);
            $cabecera_padre    = $mi_cabecera->presupuestoCabeceraPadre;
            $plan_usado_padre  = $cabecera_padre->getSumPlanHijos($this->periodo_id);
            $presupuesto_padre = $cabecera_padre->getPresupuestoEn($this->periodo_id);

            $temp_plan_ro      = $this->presupuesto_plan_ro
                               - $estado_previo->presupuesto_plan_ro;
            $temp_plan_rooc    = $this->presupuesto_plan_rooc
                               - $estado_previo->presupuesto_plan_rooc;

            if (($presupuesto_padre->presupuesto_plan_ro   + $presupuesto_padre->presupuesto_prestado_ro  )
                    < ($plan_usado_padre['ro']   + $temp_plan_ro)
                OR
                ($presupuesto_padre->presupuesto_plan_rooc + $presupuesto_padre->presupuesto_prestado_rooc)
                    < ($plan_usado_padre['rooc'] + $temp_plan_rooc)
            ){

                $saldo_disponible_prev   = $cabecera_padre->getPresupuestoDisponibleHasta($this->periodo_id);
                $prestamo_requerido_ro   = $temp_plan_ro
                                         - ($presupuesto_padre->presupuesto_plan_ro
                                         + $presupuesto_padre->presupuesto_prestado_ro
                                         - $plan_usado_padre['ro']);

                $prestamo_requerido_rooc = $temp_plan_rooc
                                         - ($presupuesto_padre->presupuesto_plan_rooc
                                         + $presupuesto_padre->presupuesto_prestado_rooc
                                         - $plan_usado_padre['rooc']);

                if ( $saldo_disponible_prev['ro']   < $prestamo_requerido_ro OR
                     $saldo_disponible_prev['rooc'] < $prestamo_requerido_rooc ){
                    return false;
                }
                $this->presupuesto_prestado_ro   += $prestamo_requerido_ro;
                $this->presupuesto_prestado_rooc += $prestamo_requerido_rooc;

                $this->presupuesto_plan_ro       = $this->presupuesto_planificado_ro   - $this->presupuesto_prestado_ro;
                $this->presupuesto_plan_rooc     = $this->presupuesto_planificado_rooc - $this->presupuesto_prestado_rooc;
            }
            $this->copia_previa = $estado_previo;
            return true;
        }
        //*/

        return true;
    }

    public function validarPresupuesto22(){
        if ($this->esta_actualizado){
            return true;
        }
        $this->esta_actualizado = true;

        $mi_cabecera = $this->presupuestoCabecera;

        if($mi_cabecera->esRaiz()){
            $plan_ro   =  $mi_cabecera->getPresupuestos()->where('periodo_id != 1')->sum('presupuesto_plan_ro');
            $plan_rooc =  $mi_cabecera->getPresupuestos()->where('periodo_id != 1')->sum('presupuesto_plan_rooc');
            if ($this->periodo_id == 1){

                /// Aquí se valida verticalmente el plan, no hay padre, solo hijos
                // respecto a los hijos: verifica si hay suficiente dinero en plan ro/rooc para satisfacer a los hijos
                $plan_hijos     = $mi_cabecera->getSumPlanHijos(1);
                if ( $this->presupuesto_plan_ro   < $plan_hijos['ro'] OR
                    $this->presupuesto_plan_rooc  < $plan_hijos['rooc']) {
                    return false;
                }

                /// Aquí se valida horizontalmente el plan y se actualiza el saldo
                $this->presupuesto_saldo_ro   = $this->presupuesto_plan_ro   - $plan_ro;
                $this->presupuesto_saldo_rooc = $this->presupuesto_plan_rooc - $plan_rooc;

                return  $this->presupuesto_saldo_ro   >= 0 AND
                    $this->presupuesto_saldo_rooc >= 0;
            }else{
                $this->actualizarLocalmente(0,0);

                if ($this->presupuesto_saldo_ro < 0 OR $this->presupuesto_saldo_rooc < 0 ){
                    return false;
                }

                $estado_previo  = Presupuesto::findOne($this->presupuesto_id);
                $temp_plan_ro   = $this->presupuesto_plan_ro   - $estado_previo->presupuesto_plan_ro;
                $temp_plan_rooc = $this->presupuesto_plan_rooc - $estado_previo->presupuesto_plan_rooc;

                // esto permite comprobar si tiene un plan valido horizontalmente (respecto al periodo 0x0)
                if ( $temp_plan_ro != 0 OR $temp_plan_rooc != 0){
                    $presupuesto_origen = $mi_cabecera->getPresupuestos()->where(['periodo_id' => 1])->one();
                    if (($presupuesto_origen->presupuesto_saldo_ro - $temp_plan_ro < 0 ) OR
                        ($presupuesto_origen->presupuesto_saldo_rooc - $temp_plan_rooc < 0 )){
                        return false;
                    }
                }

                // esto permite comprobar si hay suficiente plan para respetar los plan-hijos
                $plan_hijos = $mi_cabecera->getSumPlanHijos($this->periodo_id);
                if ( $this->presupuesto_plan_ro   < $plan_hijos['ro'] OR
                    $this->presupuesto_plan_rooc < $plan_hijos['rooc']) {
                    return false;
                }else{
                    $this->plan_alterado = true;
                    $this->copia_previa = $estado_previo;
                    return true;
                }

            }
        }

        if($mi_cabecera->esRama()){

            if ($this->periodo_id == 1){
                $estado_previo  = Presupuesto::findOne($this->presupuesto_id);
                $temp_plan_ro   = $this->presupuesto_plan_ro   - $estado_previo->presupuesto_plan_ro;
                $temp_plan_rooc = $this->presupuesto_plan_rooc - $estado_previo->presupuesto_plan_rooc;

                /// Aquí se valida verticalmente el plan, no hay padre, solo hijos
                // respecto a los hijos: verifica si hay suficiente dinero en plan ro/rooc para satisfacer a los hijos
                $plan_hijos     = $mi_cabecera->getSumPlanHijos(1);
                if ( $this->presupuesto_plan_ro   < $plan_hijos['ro'] OR
                    $this->presupuesto_plan_rooc < $plan_hijos['rooc']) {
                    return false;
                }

                // respecto al padre: verifica si hay suficiente dinero en el padre, en plan ro/rooc, para satisfacer a este($this) y sus hermanos
                $cabecera_padre    = $mi_cabecera->presupuestoCabeceraPadre;
                $plan_usado_padre  = $cabecera_padre->getSumPlanHijos($this->periodo_id);
                $presupuesto_padre = $cabecera_padre->getPresupuestoEn($this->periodo_id);

                if ($presupuesto_padre->presupuesto_plan_ro   < ($plan_usado_padre['ro'] + $temp_plan_ro) OR
                    $presupuesto_padre->presupuesto_plan_rooc < ($plan_usado_padre['rooc'] + $temp_plan_rooc)){
                    return false;
                }

                /// Aquí se valida horizontalmente el plan y se actualiza el saldo
                $planes_ro   =  $mi_cabecera->getPresupuestos()->where('periodo_id != 1')->sum('presupuesto_plan_ro');
                $planes_rooc =  $mi_cabecera->getPresupuestos()->where('periodo_id != 1')->sum('presupuesto_plan_rooc');

                $this->presupuesto_saldo_ro   = $this->presupuesto_plan_ro   - $planes_ro;
                $this->presupuesto_saldo_rooc = $this->presupuesto_plan_rooc - $planes_rooc;

                return  $this->presupuesto_saldo_ro   >= 0 AND
                    $this->presupuesto_saldo_rooc >= 0;
            }else{

                $this->actualizarLocalmente(0,0);

                if ($this->presupuesto_saldo_ro < 0 OR $this->presupuesto_saldo_rooc < 0 ){
                    return false;
                }

                $estado_previo  = Presupuesto::findOne($this->presupuesto_id);
                $temp_plan_ro   = $this->presupuesto_plan_ro   - $estado_previo->presupuesto_plan_ro;
                $temp_plan_rooc = $this->presupuesto_plan_rooc - $estado_previo->presupuesto_plan_rooc;

                if ( $temp_plan_ro != 0 OR $temp_plan_rooc != 0){
                    $presupuesto_origen = $mi_cabecera->getPresupuestos()->where(['periodo_id' => 1])->one();

                    // Aquí se comprueba si se tienen un planes validos horizontalmente (respecto al periodo 0x0)
                    if (($presupuesto_origen->presupuesto_saldo_ro   - $temp_plan_ro < 0 ) OR
                        ($presupuesto_origen->presupuesto_saldo_rooc - $temp_plan_rooc < 0 )){
                        return false;
                    }

                    // Aquí se comprueba si tienes un planes validos verticalmente (respecto al $this->periodo_id)
                    // respecto a los hijos: verifica si hay suficiente dinero en plan ro/rooc para satisfacer a los hijos
                    $plan_hijos         = $mi_cabecera->getSumPlanHijos($this->periodo_id);
                    if ( $this->presupuesto_plan_ro   < $plan_hijos['ro'] OR
                        $this->presupuesto_plan_rooc < $plan_hijos['rooc'] ) {
                        return false;
                    }

                    // respecto al padre: verifica si hay suficiente dinero en el padre, en plan ro/rooc, para satisfacer a este($this) y sus hermanos
                    $cabecera_padre    = $mi_cabecera->presupuestoCabeceraPadre;
                    $plan_usado_padre  = $cabecera_padre->getSumPlanHijos($this->periodo_id);
                    $presupuesto_padre = $cabecera_padre->getPresupuestoEn($this->periodo_id);

                    if ($presupuesto_padre->presupuesto_plan_ro   < ($plan_usado_padre['ro'] + $temp_plan_ro) OR
                        $presupuesto_padre->presupuesto_plan_rooc < ($plan_usado_padre['rooc'] + $temp_plan_rooc)){
                        return false;
                    }

                    // Si el plan Ro o Rooc fueron modificados y son validos, entonces se activa el flag "plan alterado"
                    // ello permite la actualización del presupuesto en el periodo 0x0
                    $this->plan_alterado = true;
                }

                $this->copia_previa = $estado_previo;

                // Apartir de aqui empezaran los procesos de prestamo
                return true;
            }
        }

        if($mi_cabecera->esHoja()){
            if ($this->periodo_id == 1){
                return false;
            }

            $this->actualizarLocalmente(0,0);
            $estado_previo     = Presupuesto::findOne(['presupuesto_id' => $this->presupuesto_id]);
            $cabecera_padre    = $mi_cabecera->presupuestoCabeceraPadre;
            $plan_usado_padre  = $cabecera_padre->getSumPlanHijos($this->periodo_id);
            $presupuesto_padre = $cabecera_padre->getPresupuestoEn($this->periodo_id);

            $temp_plan_ro      = $this->presupuesto_plan_ro
                - $estado_previo->presupuesto_plan_ro;
            $temp_plan_rooc    = $this->presupuesto_plan_rooc
                - $estado_previo->presupuesto_plan_rooc;

            if (($presupuesto_padre->presupuesto_plan_ro   + $presupuesto_padre->presupuesto_prestado_ro  )
                < ($plan_usado_padre['ro']   + $temp_plan_ro)
                OR
                ($presupuesto_padre->presupuesto_plan_rooc + $presupuesto_padre->presupuesto_prestado_rooc)
                < ($plan_usado_padre['rooc'] + $temp_plan_rooc)
            ){

                $saldo_disponible_prev   = $cabecera_padre->getPresupuestoDisponibleHasta($this->periodo_id);
                $prestamo_requerido_ro   = $temp_plan_ro
                    - ($presupuesto_padre->presupuesto_plan_ro
                        + $presupuesto_padre->presupuesto_prestado_ro
                        - $plan_usado_padre['ro']);

                $prestamo_requerido_rooc = $temp_plan_rooc
                    - ($presupuesto_padre->presupuesto_plan_rooc
                        + $presupuesto_padre->presupuesto_prestado_rooc
                        - $plan_usado_padre['rooc']);

                if ( $saldo_disponible_prev['ro']   < $prestamo_requerido_ro OR
                    $saldo_disponible_prev['rooc'] < $prestamo_requerido_rooc ){
                    return false;
                }
                $this->presupuesto_prestado_ro   += $prestamo_requerido_ro;
                $this->presupuesto_prestado_rooc += $prestamo_requerido_rooc;

                $this->presupuesto_plan_ro       = $this->presupuesto_planificado_ro   - $this->presupuesto_prestado_ro;
                $this->presupuesto_plan_rooc     = $this->presupuesto_planificado_rooc - $this->presupuesto_prestado_rooc;
            }
            $this->copia_previa = $estado_previo;
            return true;
        }
        return true;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function verificarPresupuestos($attribute){
        if($this->isNewRecord){
            return true;
        }
        if (! $this->validarPresupuesto()){
            $this->addError($attribute,'Este cambio invalida el presupuesto');
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        $cabecera_actual = $this->presupuestoCabecera;//->presupuestoCabeceraPadre;
        if ( $cabecera_actual != null){
            if ($cabecera_actual->esRaiz() AND $this->periodo_id != 1 AND $this->plan_alterado ){
                $cabecera_actual->getPresupuestoEn(1)->save();//$this->periodo_id)->$cabecera_padre->save();
            }

            if ($cabecera_actual->esRama() AND $this->periodo_id != 1){
                if ($this->copia_previa != null){
                    if ($this->plan_alterado){
                        $cabecera_actual->getPresupuestoEn(1)->save();
                    }else{
                        $this->restarPresupuesto($this->copia_previa);
                        $presupuesto_padre = $cabecera_actual->presupuestoCabeceraPadre->getPresupuestoEn($this->periodo_id);
                        $presupuesto_padre->sumarPresupuesto($this);

                        $presupuesto_padre->save();


                    }
                }
            }
            /*
            if ($cabecera_actual->esHoja() AND $this->periodo_id != 1){
                if ($this->copia_previa != null ){
                    $this->restarPresupuesto($this->copia_previa);
                    $presupuesto_padre = $cabecera_actual->presupuestoCabeceraPadre->getPresupuestoEn($this->periodo_id);
                    $presupuesto_padre->sumarPresupuesto($this);
                    $presupuesto_padre->save();

                    if ($this->presupuesto_prestado_ro != 0){
                        /// busco donantes en RO
                        $donacion_requerida = $this->presupuesto_prestado_ro; // la diferencia ya fue hecha al restar su previa
                        $candidatos_a_donante = $this->presupuestoCabecera->presupuestoCabeceraPadre->getPresupuestosDonantesRo($this->periodo_id);
                        foreach ($candidatos_a_donante as $candidato){

                            if ( $candidato->presupuesto_saldo_ro < $donacion_requerida ){
                                $donacion_requerida -= $candidato->presupuesto_saldo_ro;
                                $candidato->presupuesto_ejecucion_posterior_ro += $candidato->presupuesto_saldo_ro;
                                $candidato->presupuesto_saldo_ro = 0;
                                $candidato->save();
                            }else{
                                $candidato->presupuesto_ejecucion_posterior_ro += $donacion_requerida;
                                $candidato->presupuesto_saldo_ro -= $donacion_requerida;
                                $donacion_requerida = 0;
                                $candidato->save();
                            }
                            if ($donacion_requerida <= 0){
                                break;
                            }

                        }
                    }

                    if ($this->presupuesto_prestado_rooc != 0){
                        /// busco donantes en ROOC
                        $donacion_requerida   = $this->presupuesto_prestado_rooc; // la diferencia ya fue hecha al restar su previa
                        $candidatos_a_donante = $this->presupuestoCabecera->presupuestoCabeceraPadre->getPresupuestosDonantesRooc($this->periodo_id);
                        foreach ($candidatos_a_donante as $candidato){

                            if ( $candidato->presupuesto_saldo_rooc < $donacion_requerida ){
                                $donacion_requerida -= $candidato->presupuesto_saldo_rooc;
                                $candidato->presupuesto_ejecucion_posterior_rooc += $candidato->presupuesto_saldo_rooc;
                                $candidato->presupuesto_saldo_rooc = 0;
                                $candidato->save();
                            }else{
                                $candidato->presupuesto_ejecucion_posterior_rooc += $donacion_requerida;
                                $candidato->presupuesto_saldo_rooc -= $donacion_requerida;
                                $donacion_requerida = 0;
                                $candidato->save();
                            }
                            if ($donacion_requerida <= 0){
                                break;
                            }

                        }
                    }
                }
            }
            // */
        }
    }

    public function cierrePresupuestal($traspasar_saldos = true){
        $this->presupuesto_plan_ro   += ($this->presupuesto_prestado_ro
                                        - $this->presupuesto_ejecucion_posterior_ro);
        $this->presupuesto_plan_rooc += ($this->presupuesto_prestado_ro
                                        - $this->presupuesto_ejecucion_posterior_ro);
        $this->presupuesto_saldo_ro   = $this->presupuesto_plan_ro   - $this->presupuesto_planificado_ro;
        $this->presupuesto_saldo_rooc = $this->presupuesto_plan_rooc - $this->presupuesto_planificado_rooc;
        $this->presupuesto_prestado_ro   = 0;
        $this->presupuesto_prestado_rooc = 0;
        $this->presupuesto_ejecucion_posterior_ro   = 0;
        $this->presupuesto_ejecucion_posterior_rooc = 0;
        $this->esta_actualizado = true;
        $traspaso = ['ro'=>0,'rooc'=>0];
        if ($traspasar_saldos){
            $traspaso['ro']   = $this->presupuesto_saldo_ro;
            $traspaso['rooc'] = $this->presupuesto_saldo_rooc;
            $this->presupuesto_saldo_ro   = 0;
            $this->presupuesto_saldo_rooc = 0;
        }
        $this->save();
        return $traspaso;
    }

}
