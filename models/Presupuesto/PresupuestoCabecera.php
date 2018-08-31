<?php

namespace app\models\Presupuesto;
use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;

use app\models\Patrimonio\Metacodigo;
use app\models\Viatico\ArbolArea;
use app\models\Viatico\FlujoRequerimiento;
use kartik\editable\Editable;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

use Yii;

/**
 * This is the model class for table "presupuesto_cabecera".
 *
 * @property int $presupuesto_cabecera_id
 * @property int $presupuesto_version_id
 * @property int $partida_id
 * @property int $presupuesto_cabecera_padre_id
 * @property int $presupuesto_cabecera_id_original
 * @property int $jerarquia
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 * @property int $linea_fk
 *
 * @property int indice_linea
 *
 * @property string nombre_linea
 * @property string numeracion_linea
 * @property int nivel
 * @property int tipo_presupuesto
 *
 * @property int $presupuesto_contrato_id
 * @property int $objetivo_estrategico_id
 * @property int $accion_estrategica_id
 * @property int $codigo_meta_id
 * @property int $categoria_producto_id
 *
 * @property ArbolArea[] $arbolAreas
 * @property FlujoRequerimiento[] $flujoRequerimientos
 * @property Presupuesto[] $presupuestos
 *
 * @property CodigoMeta $codigoMeta
 * @property Partida $partida
 * @property PresupuestoCabecera $presupuestoCabeceraPadre
 * @property PresupuestoCabecera[] $presupuestoCabeceras
 * @property PresupuestoVersion $presupuestoVersion
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property PresupuestoContrato $presupuestoContrato
 *
 * @property MetaFinanciera $metaFinanciera
 * @property MetaFisica $metaFisica
 *
 */
class PresupuestoCabecera extends ModeloGenerico
{
    /// variables adicionales:
    public $meta_financiera_id;
    public $meta_fisica_id;
    public $linea_fk;
    public $periodo_inicio;
    public $esta_actualizado = false;
    public $es_factibilidad  = true;
    public $linea_elegida ;
    public $desde_interfaz_final = false;
    public $temp_categoria;
    public $temp_producto;
    //public $tipo_proyecto; // pip1(1), pip2(2), pip3(3)

    /// para obtimización
    public	$presupuesto_enero;
    public	$presupuesto_febrero;
    public	$presupuesto_marzo;
    public	$presupuesto_abril;
    public	$presupuesto_mayo;
    public	$presupuesto_junio;
    public	$presupuesto_julio;
    public	$presupuesto_agosto;
    public	$presupuesto_setiembre;
    public	$presupuesto_octubre;
    public	$presupuesto_noviembre;
    public	$presupuesto_diciembre;

    // presupuesto Meta Financiera
    public $meta_financiera_descripcion;
    public $meta_financiera_avance_actual;
    public $meta_financiera_avance_total;
    public $meta_financiera_unidad_medida_id;

    public $meta_financiera_precio_unitario_ro;
    public $meta_financiera_precio_unitario_rooc;
    public $meta_financiera_monto_total_ro;
    public $meta_financiera_monto_total_rooc;

    // presupuesto Meta Fisica
    public $meta_fisica_descripcion;
    public $meta_fisica_avance_actual;
    public $meta_fisica_avance_total;
    public $meta_fisica_unidad_medida_id;
//STack
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'presupuesto_cabecera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meta_financiera_avance_actual', 'meta_financiera_avance_total',
                'meta_financiera_precio_unitario_ro','meta_financiera_precio_unitario_rooc',
                'meta_financiera_monto_total_ro','meta_financiera_monto_total_rooc',
                'meta_fisica_avance_actual', 'meta_fisica_avance_total'], 'number'],
            [['periodo_inicio','presupuesto_enero','presupuesto_febrero','presupuesto_marzo','presupuesto_abril','presupuesto_mayo','presupuesto_junio','presupuesto_julio','presupuesto_agosto','presupuesto_setiembre','presupuesto_octubre','presupuesto_noviembre','presupuesto_diciembre'],'safe'],
            [['nombre_linea','numeracion_linea','meta_fisica_descripcion','meta_financiera_descripcion'],'string'],

            [['indice_linea'],'required', 'when' => function($model){return !$model->esta_actualizado AND (!isset($model->presupuesto_cabecera_padre_id) OR $model->presupuesto_cabecera_padre_id == null);}],
            [['nombre_linea'],'required', 'when' => function($model){return $model->isNewRecord AND !$model->esta_actualizado;}],
            [['periodo_inicio'],'required', 'when' => function($model){return !$model->esta_actualizado AND !$model->es_factibilidad;}],

            [['presupuesto_version_id', 'partida_id', 'presupuesto_cabecera_padre_id', 'presupuesto_cabecera_id_original', 'jerarquia', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['presupuesto_version_id', 'partida_id', 'presupuesto_cabecera_padre_id', 'presupuesto_cabecera_id_original', 'jerarquia', 'actualizado_por', 'creado_por', 'linea_elegida','presupuesto_contrato_id', 'objetivo_estrategico_id', 'accion_estrategica_id', 'categoria_producto_id','temp_categoria','temp_producto', 'indice_linea','nivel','meta_financiera_unidad_medida_id','meta_fisica_unidad_medida_id','meta_fisica_id','meta_financiera_id','codigo_meta_id','tipo_presupuesto'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['codigo_meta_id'], 'exist', 'skipOnError' => true, 'targetClass' => CodigoMeta::className(), 'targetAttribute' => ['codigo_meta_id' => 'codigo_meta_id']],
            [['partida_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partida::className(), 'targetAttribute' => ['partida_id' => 'partida_id']],
            [['presupuesto_cabecera_padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => PresupuestoCabecera::className(), 'targetAttribute' => ['presupuesto_cabecera_padre_id' => 'presupuesto_cabecera_id']],
            [['presupuesto_version_id'], 'exist', 'skipOnError' => true, 'targetClass' => PresupuestoVersion::className(), 'targetAttribute' => ['presupuesto_version_id' => 'presupuesto_version_id']],
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
            'presupuesto_cabecera_id' => 'Presupuesto Cabecera ID',
            'presupuesto_version_id'  => 'Presupuesto Version ID',
            'partida_id' => 'Partida',
            'presupuesto_cabecera_padre_id' => 'Presupuesto Padre',
            'presupuesto_cabecera_id_original' => 'Presupuesto Cabecera Id Original',
            'indice_linea'  => 'Numeración',
            'numeracion_linea' => 'Numeración',
            'nombre_linea'  => 'Nombre',
            'jerarquia' => 'Jerarquia',
            'meta_fisica_id'     => 'Meta Fisica',
            'meta_financiera_id' => 'Meta Financiera',
            'actualizado_en'  => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en'  => 'Creado En',
            'creado_por' => 'Creado Por',
            'presupuesto_contrato_id' => 'Presupuesto Contrato',
            'objetivo_estrategico_id' => 'Objetivo Estrategico',
            'accion_estrategica_id'   => 'Accion Estrategica',
            'categoria_producto_id' => 'Categoria/Producto',
            'temp_categoria'  => 'Categoria',
            'temp_producto'   => 'Producto',
            'tipo_presupuesto' => 'Tipo Presupuesto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigoMeta()
    {
        return $this->hasMany(CodigoMeta::className(), ['codigo_meta_id' => 'codigo_meta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArbolAreas()
    {
        return $this->hasMany(ArbolArea::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlujoRequerimientos()
    {
        return $this->hasMany(FlujoRequerimiento::className(), ['codigo_arbol' => 'presupuesto_cabecera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestos()
    {
        return $this->hasMany(Presupuesto::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoContrato()
    {
        return $this->hasOne(PresupuestoContrato::className(), ['presupuesto_contrato_id' => 'presupuesto_contrato_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartida()
    {
        return $this->hasOne(Partida::className(), ['partida_id' => 'partida_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriaProducto()
    {
        return $this->hasOne(CategoriaProducto::className(), ['categoria_producto_id' => 'categoria_producto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoCabeceraPadre()
    {
        return $this->hasOne(PresupuestoCabecera::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_padre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoCabecerasHijos()
    {
        return $this->hasMany(PresupuestoCabecera::className(), ['presupuesto_cabecera_padre_id' => 'presupuesto_cabecera_id']);
    }

    /**
     * @param $periodo_id
     * @return array : [ro => monto_ro, rooc => monto_rooc]
     */
    public function getSumPlanHijos($periodo_id){
        $rpta = [];
        $rpta['ro']   = $this->hasMany(Presupuesto::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id'])
            ->viaTable(PresupuestoCabecera::tableName(),['presupuesto_cabecera_padre_id' => 'presupuesto_cabecera_id'])->where('periodo_id = '.$periodo_id)->sum('presupuesto_plan_ro');
        $rpta['rooc'] = $this->hasMany(Presupuesto::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id'])
            ->viaTable(PresupuestoCabecera::tableName(),['presupuesto_cabecera_padre_id' => 'presupuesto_cabecera_id'])->where('periodo_id = '.$periodo_id)->sum('presupuesto_plan_rooc');
        return $rpta;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoVersion()
    {
        return $this->hasOne(PresupuestoVersion::className(), ['presupuesto_version_id' => 'presupuesto_version_id']);
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
     * @return string : nombre de la linea
     */
    public function getNombreLinea(){
        return $this->nombre_linea;
    }

    /**
     * @return bool
     */
    public function esHoja(){
        return $this->jerarquia == 2;
    }

    /**
     * @return bool
     */
    public function esRama(){
        return $this->jerarquia == 1;
    }

    /**
     * @return bool
     */
    public function esRaiz(){
        return $this->jerarquia == 0;
    }

    static function anhoBusqueda(){
        if (isset($_SESSION['anho_busqueda']) AND $_SESSION['anho_busqueda'] != null){
            $anho_busqueda = $_SESSION['anho_busqueda'];
        }else{
            $anho_busqueda = date('Y');
        }
        return $anho_busqueda;
    }

    public function savePeriodos(){

        $originalModel = PresupuestoCabecera::findOne(['presupuesto_cabecera_id' => $this->linea_elegida]);
        $anho       = (int)$this->periodo_inicio;
        //$anho_ini = (int)$this->periodo_inicio;
        //$anho_fin = (int)$this->periodo_fin;
        $primer_estado_metacodigo = Metacodigo::findOne([
            'descripcion'  => Yii::$app->params['presupuesto_estado']['primer_estado'],
            'nombre_lista' => Yii::$app->params['metacodigoFlags']['Estado_Presupuesto']
        ]);
        //for ($anho = $anho_ini; $anho <= $anho_fin ; $anho++){
        for ($mes = 1; $mes < 13 ; $mes++){

            $miPeriodo = Periodo::findOne(['anho' => $anho, 'mes' => $mes]);

            if (!(isset($miPeriodo) && $miPeriodo != null)){
                $nuevo_periodo = new Periodo();
                $nuevo_periodo->anho = $anho;
                $nuevo_periodo->mes = $mes;

                if ($mes < 4){
                    $trimestre = 1;
                }elseif ($mes < 7){
                    $trimestre = 2;
                }elseif ($mes < 10){
                    $trimestre = 3;
                }else{
                    $trimestre = 4;
                }
                $nuevo_periodo->trimestre = $trimestre;
                $nuevo_periodo->save();
                $miPeriodo = $nuevo_periodo;
            }

            $originalModel->crearNuevoPresupuesto($miPeriodo,$primer_estado_metacodigo);

            foreach ($originalModel->getAncestros() as $ancestro_actual){
                $ancestro_actual->crearNuevoPresupuesto($miPeriodo,$primer_estado_metacodigo);
            }
        }
        //}

        return true;
    }

    /**
     * @param $array_presupuestos_periodo_id
     * @return array : campo de columnas para la index_view
     */
    static function getColumnFields($array_presupuestos_periodo_id){

        $cabeza_columnas = [
            /*
            [
                'class' => 'kartik\grid\CheckboxColumn',
                'width' => '20px',
            ],/*
              /*
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'nombre_partida',
            ], // */
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'numeracion_presupuesto',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'nombre_presupuesto',
            ],/*
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'presupuesto_version_id',
            ],/// */
        ];

        $nombre_meses = [
            0  => 'Error',
            1  => 'Enero',  2  => 'Febrero',    3  => 'Marzo',
            4  => 'Abril',  5  => 'Mayo',       6  => 'Junio',
            7  => 'Julio',  8  => 'Agosto',     9  => 'Septiembre',
            10 => 'Octubre',11 => 'Noviembre',  12 => 'Diciembre',
        ];
        $todos_los_periodos = Periodo::find()->all();
        $periodos=[];
        foreach ($todos_los_periodos as $periodo_actual) {
            $periodos[$periodo_actual->periodo_id]['mes']  = $nombre_meses[$periodo_actual->mes];
            $periodos[$periodo_actual->periodo_id]['anho'] = $periodo_actual->anho;
            $periodos[$periodo_actual->periodo_id]['estatus'] = $periodo_actual->estatus_abierto;
        }
        // */

        $presupuesto_columnas = [];

        foreach ($array_presupuestos_periodo_id as $periodo_id => $presupuesto_id){
            $nombres=[];
            if ($periodo_id == 1){
                $nombres['Planificado Total Ro'] = 'Factibilidad Ro';
                $nombres['Comprometido Ro']      = 'Comprometido Total Ro';
                $nombres['Devengado Ro']         = 'Devengado Total Ro';
                $nombres['Girado Ro']            = 'Girado Total Ro';
                $nombres['Pagado Ro']            = 'Pagado Total Ro';
                $nombres['Ejecutado Ro']         = 'Ejecutado Total Ro';
                $nombres['Saldo Actual Ro']      = 'Saldo Factibilidad Ro';
                $nombres['Saldo Anual Ro']       = 'Saldo Anual Total Ro';


                $nombres['Planificado Total Rooc'] = 'Factibilidad Rooc';
                $nombres['Comprometido Rooc']      = 'Comprometido Total Rooc';
                $nombres['Devengado Rooc']         = 'Devengado Total Rooc';
                $nombres['Girado Rooc']            = 'Girado Total Rooc';
                $nombres['Pagado Rooc']            = 'Pagado Total Rooc';
                $nombres['Ejecutado Rooc']         = 'Ejecutado Total Rooc';
                $nombres['Saldo Actual Rooc']      = 'Saldo Factibilidad Rooc';
                $nombres['Saldo Anual Rooc']       = 'Saldo Anual Total Rooc';

            }else{
                $nombres['Planificado Total Ro'] = 'Planificado Ro : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Comprometido Ro']      = 'Comprometido Ro : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Devengado Ro']         = 'Devengado Ro : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Girado Ro']            = 'Girado Ro : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Pagado Ro']            = 'Pagado Ro : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Ejecutado Ro']         = 'Ejecutado Ro : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Saldo Actual Ro']      = 'Saldo Actual Ro : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Saldo Anual Ro']       = 'Saldo Anual Actual Ro : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];

                $nombres['Planificado Total Rooc'] = 'Planificado Rooc : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Comprometido Rooc']      = 'Comprometido Rooc : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Devengado Rooc']         = 'Devengado Rooc : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Girado Rooc']            = 'Girado Rooc : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Pagado Rooc']            = 'Pagado Rooc : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Ejecutado Rooc']         = 'Ejecutado Rooc : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Saldo Actual Rooc']      = 'Saldo Actual Rooc : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
                $nombres['Saldo Anual Rooc']       = 'Saldo Anual Actual Rooc : '.$periodos[$periodo_id]['mes'].' '.$periodos[$periodo_id]['anho'];
            }
            $columnas_pX =
                [
                    /*
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'p'.$presupuesto_id.'_presupuesto_id',
                    ],//*/
                    /*
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'p'.$presupuesto_id.'_presupuesto_plan_ro',
                    ],// */
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Planificado Total Ro'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_plan_ro';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $es_hoja = $data['es_hoja'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'type'=>"cute-input",
                                    'disabled' => $es_hoja,
                                ]
                            );
                        },
                        //'width' => '20px'
                        //'options' => ['style' => 'width:90px; color:red '],//'style'=>"width:90px;",
                        //'contentOptions' => ['style' => "width:90px; background-color:red;"],
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        //'class' => 'kartik\grid\EditableColumn',
                        'attribute' => 'presupuesto_plan_rooc',
                        'header' => $nombres['Planificado Total Rooc'],
                        'value'  => $presupuesto_id,
                        /*
                        'content' => function($data,$key,$index,$column){
                                        $campo = 'presupuesto_plan_rooc';
                                        $valor_campo = $data['p'.$column->value.'_'.$campo];
                                        $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                                        $index_campo = 'p'.$real_index.'_'.$campo;
                                        return '<button type="button" id="'.$index_campo.'"
                                                class="kv-editable-value kv-editable-link"
                                                data-toggle="popover-x"
                                                data-placement="right"
                                                data-target="#presupuesto-0-presupuesto_plan_ro-popover">'.$valor_campo.'</button>';
                                        //return '<div class="text_content">'.htmlentities($valor_campo).'</div>';
                                    },// */
                        /*
                        'editableOptions' => [
                            'header' => 'Company',
                            'inputType' => Editable::INPUT_TEXT,
                            'options' => [
                                'pluginOptions' => [

                                ]
                            ]
                        ],// */


                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_plan_rooc';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $es_hoja = $data['es_hoja'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'type'=>"cute-input",
                                    'disabled' => $es_hoja,
                                ]
                            );
                        },
                    ],

                    /// nuevo modelo comentado
                    /*
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Planificado Total Ro'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_plan_ro';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $es_hoja = $data['p'.$column->value.'_es_hoja'];
                            $index_campo = 'p'.$real_index.'_'.$campo;

                            return Editable::widget([
                                'asPopover' => true,
                                'name'  => $campo,
                                'value' => ''.$valor_campo,
                                //'header' => 'Name',
                                'size'=>'md',
                                'options' => ['class'=>'form-control', 'placeholder'=>'Enter person name...']
                            ]);
                        },
                    ],
                    /// */
                ];

            $columnas_pX2 = [];
            if ($periodo_id != 1) {
                $columnas_pX2 = [
                    /*
                    ['class' => '\kartik\grid\DataColumn', 'attribute' => 'p' . $presupuesto_id . '_presupuesto_compromiso_ro', 'label' => $nombres['Comprometido Ro'],],
                    ['class' => '\kartik\grid\DataColumn', 'attribute' => 'p' . $presupuesto_id . '_presupuesto_compromiso_rooc', 'label' => $nombres['Comprometido Ro'],],//*/

                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Comprometido Ro'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_compromiso_ro';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Comprometido Rooc'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_compromiso_rooc';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],
                    // */
                    /*
                    ['class' => '\kartik\grid\DataColumn', 'attribute' => 'p' . $presupuesto_id . '_presupuesto_devengado_ro', 'label' => $nombres['Devengado Ro'],],
                    ['class' => '\kartik\grid\DataColumn', 'attribute' => 'p' . $presupuesto_id . '_presupuesto_devengado_rooc', 'label' => $nombres['Devengado Rooc'],],
                    // */

                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Devengado Ro'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_devengado_ro';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Devengado Rooc'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_devengado_rooc';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],
                    //*/
                    /*
                    ['class' => '\kartik\grid\DataColumn', 'attribute' => 'p' . $presupuesto_id . '_presupuesto_girado_ro', 'label' => $nombres['Girado Ro'],],
                    ['class' => '\kartik\grid\DataColumn', 'attribute' => 'p' . $presupuesto_id . '_presupuesto_girado_rooc', 'label' => $nombres['Girado Rooc'],],// */

                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Girado Ro'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_girado_ro';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Girado Rooc'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_girado_rooc';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],// */
                    /*
                    ['class' => '\kartik\grid\DataColumn', 'attribute' => 'p' . $presupuesto_id . '_presupuesto_pagado_ro', 'label' => $nombres['Pagado Ro'],],
                    ['class' => '\kartik\grid\DataColumn', 'attribute' => 'p' . $presupuesto_id . '_presupuesto_pagado_rooc', 'label' => $nombres['Pagado Rooc'],],// */

                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Pagado Ro'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_pagado_ro';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Pagado Rooc'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_pagado_rooc';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ], //*/
                    /*
                    ['class' => '\kartik\grid\DataColumn', 'attribute' => 'p' . $presupuesto_id . '_presupuesto_ejecutado_ro', 'label' => $nombres['Ejecutado Ro'],],
                    ['class' => '\kartik\grid\DataColumn', 'attribute' => 'p' . $presupuesto_id . '_presupuesto_ejecutado_rooc', 'label' => $nombres['Ejecutado Rooc'],],// */

                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Ejecutado Ro'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_ejecutado_ro';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Ejecutado Rooc'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_ejecutado_rooc';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],
                    // */
                    //['class' => '\kartik\grid\DataColumn', 'header' => $nombres['Saldo Actual Ro'], 'attribute' => 'p' . $presupuesto_id . '_presupuesto_saldo_ro',],// */
                    /*
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Saldo Actual Ro'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_saldo_ro';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],// */
                    //['class' => '\kartik\grid\DataColumn', 'header' => $nombres['Saldo Actual Rooc'], 'attribute' => 'p' . $presupuesto_id . '_presupuesto_saldo_rooc',],
                    /*
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Saldo Actual Rooc'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_saldo_rooc';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ], // */

                    //['class' => '\kartik\grid\DataColumn', 'header' => $nombres['Saldo Anual Ro'], 'attribute' => 'p' . $presupuesto_id . '_presupuesto_saldo_anual_ro',],// */
                    /*
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'header' => $nombres['Saldo Anual Ro'],
                        'value' => $presupuesto_id,
                        'content' => function($data,$key,$index,$column){
                            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                            $campo = 'presupuesto_saldo_anual_ro';
                            $valor_campo = $data['p'.$column->value.'_'.$campo];
                            $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                            $index_campo = 'p'.$real_index.'_'.$campo;
                            return Html::textInput(
                                $index_campo,
                                $valor_campo,
                                [
                                    'id'=> $index_campo,
                                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                    'disabled' => ($valor_campo == null),
                                ]
                            );
                        },
                        'width' => '20px'
                    ],// */
                    //['class' => '\kartik\grid\DataColumn', 'header' => $nombres['Saldo Anual Rooc'], 'attribute' => 'p' . $presupuesto_id . '_presupuesto_saldo_anual_rooc',],
                    /*
                        [
                            'class'=>'\kartik\grid\DataColumn',
                            'header' => $nombres['Saldo Anual Rooc'],
                            'value' => $presupuesto_id,
                            'content' => function($data,$key,$index,$column){
                                //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
                                $campo = 'presupuesto_saldo_anual_rooc';
                                $valor_campo = $data['p'.$column->value.'_'.$campo];
                                $real_index  = $data['p'.$column->value.'_presupuesto_id'];
                                $index_campo = 'p'.$real_index.'_'.$campo;
                                return Html::textInput(
                                    $index_campo,
                                    $valor_campo,
                                    [
                                        'id'=> $index_campo,
                                        'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                                        'disabled' => ($valor_campo == null),
                                    ]
                                );
                            },
                            'width' => '20px'
                        ],// */
                ];
            }

            foreach ($columnas_pX as $columna){
                $presupuesto_columnas[] = $columna;
            }

            foreach ($columnas_pX2 as $columna){
                $presupuesto_columnas[] = $columna;
            }

            $presupuesto_columnas[] = ['class' => '\kartik\grid\DataColumn', 'header' => $nombres['Saldo Actual Ro'], 'attribute' => 'p' . $presupuesto_id . '_presupuesto_saldo_ro',];
            $presupuesto_columnas[] = ['class' => '\kartik\grid\DataColumn', 'header' => $nombres['Saldo Actual Rooc'], 'attribute' => 'p' . $presupuesto_id . '_presupuesto_saldo_rooc',];
        }


        $cola_columnas = [];
        /*[
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'vAlign'=>'middle',
                'urlCreator' => function($action, $model, $key, $index) {
                    return Url::to([$action,'id'=>$key]);
                },
                'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
                'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
                'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'Are you sure?',
                    'data-confirm-message'=>'Are you sure want to delete this item'],
            ],
        ]; // */

        foreach ($presupuesto_columnas as $columna){
            $cabeza_columnas[] = $columna;
        }

        //$columnas = array_merge($cabeza_columnas,$presupuesto_columnas);
        $columnas = array_merge($cabeza_columnas,$cola_columnas);

        return $columnas;
    }

    /**
     * @param $array_presupuestos_periodo_id
     * @return array : campo de columnas para la index_view
     */
    static function getColumnFieldsFinalFactibilidad(){

        $columnas = [

            [
                'class' =>'\kartik\grid\DataColumn',
                'label' => 'Numeración Presupuesto',
                'attribute'=>'numeracion_linea',
                'value' => 'numeracion_linea'//.nombre_linea'
            ],
            [
                'class' =>'\kartik\grid\DataColumn',
                'label' => 'Nombre de Linea',
                'attribute'=>'nombre_linea',
                'value' => 'nombre_linea'//.nombre_linea'
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Contrato',
                'attribute'=>'presupuestoContrato.contrato_descripcion',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Factibilidad Ro',
                'content' => function($data,$key,$index,$column){
                    $nombre_campo= 'presupuesto_plan_ro';
                    $valor_campo = $data['factibilidadPlanRo'];// $data['factibilidadRo.presupuesto_plan_ro'];//$data['p'.$column->value.'_'.$campo];
                    $presupuesto_id = $data['factibilidadId'];
                    $index_campo = 'inner_index_'.$presupuesto_id.'_'.$nombre_campo; /// indice en la view
                    $es_hoja     = false;//$data['p'.$column->value.'_es_hoja'] == 1;
                    return \yii\helpers\Html::textInput(
                        $index_campo,
                        $valor_campo,
                        [
                            'id'=> $index_campo,
                            'onchange'=> 'actualizarVariable('.$presupuesto_id.',\''.$nombre_campo.'\',\''.$index_campo.'\')',
                            'type'=>"cute-input",
                            'disabled' => $es_hoja,
                        ]
                    );
                },
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Factibilidad Rooc',
                'content' => function($data,$key,$index,$column){
                    $nombre_campo= 'presupuesto_plan_rooc';
                    $valor_campo    = $data['factibilidadPlanRooc'];// $data['factibilidadRo.presupuesto_plan_ro'];//$data['p'.$column->value.'_'.$campo];
                    $presupuesto_id = $data['factibilidadId'];
                    $index_campo = 'inner_index_'.$presupuesto_id.'_'.$nombre_campo; /// indice en la view
                    $es_hoja     = false;//$data['p'.$column->value.'_es_hoja'] == 1;
                    return \yii\helpers\Html::textInput(
                        $index_campo,
                        $valor_campo,
                        [
                            'id'=> $index_campo,
                            'onchange'=> 'actualizarVariable('.$presupuesto_id.',\''.$nombre_campo.'\',\''.$index_campo.'\')',
                            'type'=>"cute-input",
                            'disabled' => $es_hoja,
                        ]
                    );
                },
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Factibilidad Total',
                'attribute'=>'sumaFactibilidad',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Avance (%)',
                'attribute'=>'porcentajeAvance',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Saldo Ro',
                'attribute'=>'factibilidad.presupuesto_saldo_ro',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Saldo Rooc',
                'attribute'=>'factibilidad.presupuesto_saldo_rooc',
            ],

//*/

        ];


        $columnas[] =
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'vAlign'=>'middle',
                'urlCreator' => function($action, $model, $key, $index) {
                    return Url::to([$action,'id'=>$key]);
                },
                'viewOptions'  =>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
                'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
                'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'Are you sure?',
                    'data-confirm-message'=>'Are you sure want to delete this item'],
            ]; // */


        return $columnas;
    }


    /**
     * @param $array_presupuestos_periodo_id
     * @return array : campo de columnas para la index_view
     */
    static function getColumnFieldsFinalPeriodos(){

        $nombre_meses = [
            0  => 'Error',
            1  => 'Enero',  2  => 'Febrero',    3  => 'Marzo',
            4  => 'Abril',  5  => 'Mayo',       6  => 'Junio',
            7  => 'Julio',  8  => 'Agosto',     9  => 'Septiembre',
            10 => 'Octubre',11 => 'Noviembre',  12 => 'Diciembre',
        ];

        $cabeza_columnas = [
            [
                'class' =>'\kartik\grid\DataColumn',
                'label' => 'Numeración Presupuesto',
                'attribute'=>'numeracion_linea',
                'value' => 'numeracion_linea'//.nombre_linea'
            ],
            [
                'class' =>'\kartik\grid\DataColumn',
                'label' => 'Nombre de Linea',
                'attribute'=>'nombre_linea',
                'value' => 'nombre_linea'//.nombre_linea'
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Contrato',
                'attribute'=>'presupuestoContrato.contrato_descripcion',
            ],/*
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'nombrePresupuesto',
                'contentOptions' => ['style' => 'position: relative;',],

            ],/*
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'presupuesto_version_id',
                //'width' => '90px',
                //'style' => "width:100px;",
            ],// */
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Factibilidad Ro',
                'content' => function($data,$key,$index,$column){
                    $nombre_campo= 'presupuesto_plan_ro';
                    $valor_campo = $data['factibilidadPlanRo'];// $data['factibilidadRo.presupuesto_plan_ro'];//$data['p'.$column->value.'_'.$campo];
                    $presupuesto_id = $data['factibilidadId'];
                    $index_campo = 'inner_index_'.$presupuesto_id.'_'.$nombre_campo; /// indice en la view
                    $es_hoja     = false;//$data['p'.$column->value.'_es_hoja'] == 1;
                    return \yii\helpers\Html::textInput(
                        $index_campo,
                        $valor_campo,
                        [
                            'id'=> $index_campo,
                            'onchange'=> 'actualizarVariable('.$presupuesto_id.',\''.$nombre_campo.'\',\''.$index_campo.'\')',
                            'type'=>"cute-input",
                            'disabled' => $es_hoja,
                        ]
                    );
                },
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Factibilidad Rooc',
                'content' => function($data,$key,$index,$column){
                    $nombre_campo= 'presupuesto_plan_rooc';
                    $valor_campo    = $data['factibilidadPlanRooc'];// $data['factibilidadRo.presupuesto_plan_ro'];//$data['p'.$column->value.'_'.$campo];
                    $presupuesto_id = $data['factibilidadId'];
                    $index_campo = 'inner_index_'.$presupuesto_id.'_'.$nombre_campo; /// indice en la view
                    $es_hoja     = false;//$data['p'.$column->value.'_es_hoja'] == 1;
                    return \yii\helpers\Html::textInput(
                        $index_campo,
                        $valor_campo,
                        [
                            'id'=> $index_campo,
                            'onchange'=> 'actualizarVariable('.$presupuesto_id.',\''.$nombre_campo.'\',\''.$index_campo.'\')',
                            'type'=>"cute-input",
                            'disabled' => $es_hoja,
                        ]
                    );
                },
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Factibilidad Total',
                'attribute'=>'sumaFactibilidad',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'factibilidad.presupuesto_saldo_ro',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'factibilidad.presupuesto_saldo_rooc',
            ],

        ];

        $anho_busqueda = PresupuestoCabecera::anhoBusqueda();

        $presupuestos = [
            1  => 'presupuestoEnero',
            2  => 'presupuestoFebrero',
            3  => 'presupuestoMarzo',
            4  => 'presupuestoAbril',
            5  => 'presupuestoMayo',
            6  => 'presupuestoJunio',
            7  => 'presupuestoJulio',
            8  => 'presupuestoAgosto',
            9  => 'presupuestoSeptiembre',
            10 => 'presupuestoOctubre',
            11 => 'presupuestoNoviembre',
            12 => 'presupuestoDiciembre',
        ];

        $presupuesto_columnas = [];


        foreach ($presupuestos as $index => $presupuesto ){

            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Planificado Ro : '.$nombre_meses[$index].' '.$anho_busqueda,
                'value' => $presupuesto,
                'content' => function($data,$key,$index,$column){
                    $presupuesto = $column->value;
                    $nombre_campo  = 'presupuesto_plan_ro';
                    $valor_campo   = $data[$presupuesto.'Ro'];
                    $presupuesto_id = $data[$presupuesto.'Id'];
                    $index_campo = 'inner_index_'.$presupuesto_id.'_'.$nombre_campo; /// indice en la view
                    $es_hoja     = $data[$presupuesto.'Id'] == null;//false;//$data['p'.$column->value.'_es_hoja'] == 1;
                    return \yii\helpers\Html::textInput(
                        $index_campo,
                        $valor_campo,
                        [
                            'id'=> $index_campo,
                            'onchange'=> 'actualizarVariable('.$presupuesto_id.',\''.$nombre_campo.'\',\''.$index_campo.'\')',
                            'type'=>"cute-input",
                            'disabled' => $es_hoja,
                        ]
                    );
                },
            ];

            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Planificado Rooc : '.$nombre_meses[$index].' '.$anho_busqueda,
                'value' => $presupuesto,
                'content' => function($data,$key,$index,$column){
                    $presupuesto = $column->value;
                    $nombre_campo  = 'presupuesto_plan_rooc';
                    $valor_campo   = $data[$presupuesto.'Rooc'];
                    $presupuesto_id = $data[$presupuesto.'Id'];
                    $index_campo = 'inner_index_'.$presupuesto_id.'_'.$nombre_campo; /// indice en la view
                    $es_hoja     = $data[$presupuesto.'Id'] == null;//false;//$data['p'.$column->value.'_es_hoja'] == 1;
                    return \yii\helpers\Html::textInput(
                        $index_campo,
                        $valor_campo,
                        [
                            'id'=> $index_campo,
                            'onchange'=> 'actualizarVariable('.$presupuesto_id.',\''.$nombre_campo.'\',\''.$index_campo.'\')',
                            'type'=>"cute-input",
                            'disabled' => $es_hoja,
                        ]
                    );
                },
            ];
// */
            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Planificado Suma : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'Suma',
            ]; // */

//            $cabeza_columnas[] = [
//                'class'=>'\kartik\grid\DataColumn',
//                'header' => 'Planificado Ro : '.$nombre_meses[$index].' '.$anho_busqueda,
//                'attribute'=> $presupuesto.'.presupuesto_plan_ro',
//            ];
//            $cabeza_columnas[] = [
//                'class'=>'\kartik\grid\DataColumn',
//                'header' => 'Planificado Rooc : '.$nombre_meses[$index].' '.$anho_busqueda,
//                'attribute'=> $presupuesto.'.presupuesto_plan_rooc',
//            ];

            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Certificado Ro : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_certificado_ro',
            ];
            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Certificado Rooc : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_certificado_rooc',
            ];

            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Comprometido Ro : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_compromiso_ro',
            ];
            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Comprometido Rooc : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_compromiso_rooc',
            ];

            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Devengado Ro : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_devengado_ro',
            ];
            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Devengado Rooc : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_devengado_rooc',
            ];

            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Girado Ro : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_girado_ro',
            ];
            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Girado Rooc : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_girado_rooc',
            ];

            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Pagado Ro : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_pagado_ro',
            ];
            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Pagado Rooc : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_pagado_rooc',
            ];

            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Ejecutado Ro : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_ejecutado_ro',
            ];
            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Ejecutado Rooc : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_ejecutado_rooc',
            ];

            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Saldo Ro : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_saldo_ro',
            ];
            $cabeza_columnas[] = [
                'class'=>'\kartik\grid\DataColumn',
                'header' => 'Saldo Rooc : '.$nombre_meses[$index].' '.$anho_busqueda,
                'attribute'=> $presupuesto.'.presupuesto_saldo_rooc',
            ];

        }

        foreach ($presupuesto_columnas as $columna){
            $cabeza_columnas[] = $columna;
        }

        $columnas = array_merge($cabeza_columnas,$presupuesto_columnas);

        return $columnas;
    }

    /**
     * @param $insert
     * @return bool
     */
    public function beforeSave($insert){
        if ($this->esta_actualizado){
            if(Yii::$app->user->isGuest) return false;
            $this->actualizado_por= Yii::$app->user->identity->usuario_id;
            $this->actualizado_en = date('Y-m-d H:i:s');
            return true;
        }
        if (parent::beforeSave($insert)) {
            if(Yii::$app->user->isGuest) return false;

            $this->actualizado_por= Yii::$app->user->identity->usuario_id;
            $this->actualizado_en = date('Y-m-d H:i:s');

            if(isset($this->temp_categoria)){
                $this->categoria_producto_id = $this->temp_categoria;
            }elseif (isset($this->temp_producto)){
                $this->categoria_producto_id = $this->temp_producto;
            }

            if ($this->isNewRecord) {
                $this->creado_por = Yii::$app->user->identity->usuario_id;
                $this->creado_en = date('Y-m-d H:i:s');

                $ultima_version = PresupuestoVersion::getUltimaVersion($this->desde_interfaz_final);

                if ($ultima_version == null){
                    $ultima_version = new PresupuestoVersion();
                    $ultima_version->fecha = date('Y-m-d');
                    $ultima_version->nro_version = 1;
                    $ultima_version->save();
                    $this->presupuesto_version_id = $ultima_version->presupuesto_version_id;
                }else{
                    $this->presupuesto_version_id = $ultima_version->presupuesto_version_id;
                }

                $cabecera_padre = $this->presupuestoCabeceraPadre;
                if ($cabecera_padre == null){
                    $this->nivel = 1;
                    $this->numeracion_linea = $this->indice_linea;
                    $this->jerarquia = 0; /// si no tiene padre, entonces es una Raiz(0)

                }else{

                    $mi_numeracion = PresupuestoCabecera::find()->where(
                            ['presupuesto_cabecera_padre_id' => $this->presupuesto_cabecera_padre_id])->count() + 1;

                    $this->nivel = $cabecera_padre->nivel+1;
                    $this->numeracion_linea = $cabecera_padre->numeracion_linea.'.'.$mi_numeracion;
                    $this->indice_linea = $cabecera_padre->indice_linea;

                    $this->jerarquia = 2; /// si tiene padre, entonces es una Hoja

                    if ($cabecera_padre->presupuesto_contrato_id != null){
                        $this->presupuesto_contrato_id = $cabecera_padre->presupuesto_contrato_id;
                    }
                    if ($cabecera_padre->codigo_meta_id != null){
                        $this->codigo_meta_id = $cabecera_padre->codigo_meta_id;
                    }
                    if ($cabecera_padre->tipo_presupuesto != null){
                        $this->tipo_presupuesto = $cabecera_padre->tipo_presupuesto;
                    }

                }
            }
            return true;
        }
        return false;
    }

    /**
     * actualiza la Jerarquia del Padre, requiere del modelo extra : PresupuestoCabeceraResumido
     */
    public function actualizarJerarquiaPadre(){
        if ($this->presupuesto_cabecera_padre_id != null){
            $cabecera_padre = PresupuestoCabecera::findOne(['presupuesto_cabecera_id' => $this->presupuesto_cabecera_padre_id ]);
            $cabecera_padre->esta_actualizado = true;
            if ($cabecera_padre->jerarquia == 2){
                $cabecera_padre->jerarquia = 1;
                $cabecera_padre->save();
            }
        }
    }

    /**
     * @return PresupuestoCabecera[] : linea de ascendencia: padre, abuelo, bis-abuelo
     */
    public function getAncestros(){
        $ancestros = [];
        $presupuesto_cabecera_iterator = $this;
        $index  = 0;
        while (isset($presupuesto_cabecera_iterator->presupuesto_cabecera_padre_id) &&
            $presupuesto_cabecera_iterator->presupuesto_cabecera_padre_id != null){
            $presupuesto_cabecera_iterator = $presupuesto_cabecera_iterator->presupuestoCabeceraPadre;
            $ancestros[$index] = $presupuesto_cabecera_iterator;
            $index++;
        }
        return $ancestros;
    }

    /**
     * @return \yii\db\ActiveQuery : periodos relacionados a los presupuestos asignados a esta cabecera
     */
    public function getPeriodos(){
        return $this->hasOne(Periodo::className(),['periodo_id' => 'periodo_id'])
            ->viaTable(Presupuesto::tableName(),['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']);
    }

    /**
     * @param $periodo_id
     * @return null|Presupuesto : presupuesto con el periodo consultado, null si no existe
     */
    public function getPresupuestoEn($periodo_id){
        return $this->getPresupuestos()->where('presupuesto.periodo_id = '.$periodo_id)->one();
    }

    /**
     * @param $periodo_id : periodo en consulta
     * @return array : ['ro'=> saldo en ro, 'rooc' => saldo en rooc]
     */
    public function getPresupuestoDisponibleHasta($periodo_id){
        $saldos = [];
        $saldos['ro']   = $this->getPresupuestos()->where("periodo_id < ".$periodo_id." AND periodo_id > 1")->sum("presupuesto.presupuesto_saldo_ro");
        $saldos['rooc'] = $this->getPresupuestos()->where("periodo_id < ".$periodo_id." AND periodo_id > 1")->sum("presupuesto.presupuesto_saldo_rooc");
        return $saldos;
    }

    public function getPresupuestosDonantesRo($periodo_id){
        return $this->getPresupuestos()->where("presupuesto.periodo_id < ".$periodo_id." AND presupuesto.periodo_id > 1 AND presupuesto.presupuesto_saldo_ro > 0 ")->all();
    }

    public function getPresupuestosDonantesRooc($periodo_id){
        return $this->getPresupuestos()->where("periodo_id < ".$periodo_id." AND periodo_id > 1 AND presupuesto.presupuesto_saldo_rooc > 0 ")->all();
    }

    /**
     * @param $periodo : Periodo donde se creara el presupuesto
     * @param $primer_estado_metacodigo : estado metacodigo asignado al presupuesto
     */
    public function crearNuevoPresupuesto($periodo,$primer_estado_metacodigo){
        if ($this->getPeriodos()->where('periodo.periodo_id = '.$periodo->periodo_id)->count() < 1 ){
            $nuevo_presupuesto = new Presupuesto();
            $nuevo_presupuesto->presupuesto_cabecera_id = $this->presupuesto_cabecera_id;
            $nuevo_presupuesto->periodo_id = $periodo->periodo_id;
            $nuevo_presupuesto->estado = $primer_estado_metacodigo->metacodigo_id;
            $nuevo_presupuesto->save();
        }
    }

    //// FUNCIONES - INTERFAZ DE CONEXIÓN - INICIO

    /**
     * @return array(presupuesto_cabecera_id => presupuesto_cabecera_id)
     */
    static function getComboBoxItemsConMetas(){
        $ultima_version = PresupuestoVersion::getUltimaVersion();
        if ($ultima_version == null){ return []; }

        $items = PresupuestoCabecera::find()->where([
            'presupuesto_version_id' => $ultima_version->presupuesto_version_id,
            'jerarquia' => 2])
            ->andWhere('(nivel = 6 or nivel =8 or nivel = 9)')
            ->all();

        $array=[];
        foreach ($items as $actual_item) {
            $array[$actual_item->presupuesto_cabecera_id_original] = $actual_item->getNombreLinea();
        }
        return $array;
    }

    /**
     * @return array(presupuesto_cabecera_id => presupuesto_cabecera_id)
     */
    static function getComboBoxItems($solo_hijos = true){
        $ultima_version = PresupuestoVersion::getUltimaVersion();
        if ($ultima_version == null){ return []; }

        if ($solo_hijos){
            $items = PresupuestoCabecera::find()->where(['presupuesto_version_id' => $ultima_version->presupuesto_version_id,
                'jerarquia' => 2 ])->all();
        }else{
            $items = PresupuestoCabecera::find()->where('presupuesto_version_id = '.$ultima_version->presupuesto_version_id)->all();
        }
        $array=[];
        foreach ($items as $actual_item) {
            $array[$actual_item->presupuesto_cabecera_id_original] = $actual_item->getNombreLinea();
        }
        return $array;
    }


    /**
     * @return array(presupuesto_cabecera_id => presupuesto_cabecera_id)
     */
    static function getComboBoxItemsVerdaderoId($solo_hijos = true,$version_de_session = false){
        $ultima_version = PresupuestoVersion::getUltimaVersion($version_de_session);
        if ($ultima_version == null){ return []; }

        if ($solo_hijos){
            $items = PresupuestoCabecera::find()->where(['presupuesto_version_id' => $ultima_version->presupuesto_version_id,
                'jerarquia' => 2 ])->all();
        }else{
            $items = PresupuestoCabecera::find()->where('presupuesto_version_id = '.$ultima_version->presupuesto_version_id)->all();
        }
        $array=[];
        foreach ($items as $actual_item) {
            $array[$actual_item->presupuesto_cabecera_id] = $actual_item->getNumeracionPresupuesto()."\t".$actual_item->getNombreLinea();
            //$array[$actual_item->presupuesto_cabecera_id] = [[$actual_item->getNombreLinea()]];
        }

        return $array;
    }

    /**
     * @param $presupuesto_cabecera_id : identificador de la cabecera almacenada en el requerimiento
     * @return array(periodo_id => anho-mes)
     */
    static function getComboBoxPeriodosDisponibles($presupuesto_cabecera_id){
        $presupuesto_cabecera = PresupuestoCabecera::findOne(['presupuesto_cabecera_id' => $presupuesto_cabecera_id]);
        if ($presupuesto_cabecera == null){
            return [];
        }else{
            $periodos_disponibles = $presupuesto_cabecera->getPeriodos()->where('periodo.estatus_abierto = 1 AND periodo.periodo_id != 1 ')->all();
            $items = [];
            foreach ($periodos_disponibles as $iterador_presupuesto){
                if ($iterador_presupuesto->periodo_id != 1)
                    $items[$iterador_presupuesto->periodo_id] = $iterador_presupuesto->anho.' '.$iterador_presupuesto->mes;
            }
            return $items;
        }
    }

    /**
     * @return string
     */
    public function getNombre(){
        return $this->nombre_linea;
    }

    /**
     * @param $presupuesto_cabecera_id :  el presupuesto cabecera obtenido de la relación entre areas y presupuestos
     * @return PresupuestoCabecera|null : retorna el presupuestoCabecera REAL,(dependiente de la versión activa actual)
     */
    static function getPresupuestoCabeceraLink($presupuesto_cabecera_id){
        $ultima_version = PresupuestoVersion::getUltimaVersion();
        if ($ultima_version == null) return null;
        return PresupuestoCabecera::findOne([
            'presupuesto_cabecera_id_original' => $presupuesto_cabecera_id,
            'presupuesto_version_id' => $ultima_version->presupuesto_version_id
        ]);

    }

    /**
     * @param $periodo_id : identificador del periodo almacenado en el requerimiento
     * @param $monto : monto que ha de ser asignado
     * @param $campo : campo al cual se asigna el monto
     * @return bool  : true si se asigno el monto, false, si no se pudo asignar
     */
    public function crearRequerimiento($periodo_id,$monto,$campo){
        $periodo = Periodo::findOne(['periodo_id' => $periodo_id]);
        if ($periodo == null OR $periodo->estatus_abierto == 0){
            return false;
        }

        if ($campo == 'presupuesto_id' OR $campo == 'periodo_id' OR $campo == 'estado' OR $campo == 'presupuesto_cabecera_id' OR
            $campo == 'presupuesto_saldo_ro' OR $campo == 'presupuesto_saldo_rooc' OR $campo == 'presupuesto_saldo_anual_ro' OR
            $campo == 'presupuesto_saldo_anual_rooc' OR $campo == 'presupuesto_ejecucion_posterior_ro' OR $campo == 'presupuesto_ejecucion_posterior_rooc' OR
            $campo == 'actualizado_en' OR $campo == 'actualizado_por' OR $campo == 'creado_en' OR $campo == 'creado_por'
        ){
            return false;
        }

        $presupuesto_actual = $this->getPresupuestos()->where(['periodo_id' => $periodo_id])->one();
        $monto_actual = $presupuesto_actual->getAttribute($campo) + $monto;
        $presupuesto_actual->setAttribute($campo,$monto_actual);
        if ($presupuesto_actual->validarPresupuesto()){
            $presupuesto_actual->save();
            return true;
        } else{
            return false;
        }
    }

    /**
     * @param $periodo_id : identificador del periodo almacenado en el requerimiento
     * @param $de_campo  : campo del cual se ha de restar el monto a asignar
     * @param $a_campo   : campo al  cual se ha de sumarl el monto a asignar
     * @param $monto     : monto asignado
     * @return bool      : true si el monto se asigno correctametne, false si no se pudo asignar
     */
    public function moverMontos($periodo_id,$de_campo,$a_campo,$monto){
        $periodo = Periodo::findOne(['periodo_id' => $periodo_id]);
        if ($periodo == null OR $periodo->estatus_abierto == 0){
            return false;
        }
        $presupuesto_actual = $this->getPresupuestos()->where(['periodo_id' => $periodo_id])->one();
        $monto_campo_1 = $presupuesto_actual->getAttribute($de_campo) - $monto;
        $monto_campo_2 = $presupuesto_actual->getAttribute($a_campo)  + $monto;
        $presupuesto_actual->setAttribute($de_campo,$monto_campo_1);
        $presupuesto_actual->setAttribute($a_campo,$monto_campo_2);
        if ($presupuesto_actual->validarPresupuesto()){
            $presupuesto_actual->save();
            return true;
        } else{
            return false;
        }
    }

    /**
     * @param $periodo_id : Periodo en consulta
     * @param $directo_o_padre : true -> retorna el resupuesto del nivel actual, false, del padre
     * @return array : ['ro' => float::presupuesto_disponible en Ro, 'Rooc' => float::presupuesto disponible en Rooc]
     */
    public function obtenerPresupuestoDisponible($periodo_id,$directo_o_padre = true){
        $periodo = Periodo::findOne(['periodo_id' => $periodo_id]);

        if ($periodo == null OR $periodo->estatus_abierto == 0){
            return ['ro'    => 0,
                'rooc'  => 0];
        }

        $cabecera_actual = $this;
        if (!$directo_o_padre){ // si se requiere del presupuesto del padre
            $cabecera_actual = $this->presupuestoCabeceraPadre;
        }

        $presupuesto_actual       = $cabecera_actual->getPresupuestoEn($periodo_id);

        if ($presupuesto_actual == null){
            return ['ro'    => 0,
                'rooc'  => 0];
        }

        $presupuestos_disponibles = $cabecera_actual->getPresupuestoDisponibleHasta($periodo_id);
        $presupuestos_disponibles['ro']   += $presupuesto_actual->presupuesto_saldo_ro;
        $presupuestos_disponibles['rooc'] += $presupuesto_actual->presupuesto_saldo_rooc;

        return $presupuestos_disponibles;
    }

    /**
     * @return string : retorna la descripción del contrato, BM/BID
     */
    public function getDescripcionContrato(){
        return $this->presupuestoContrato->contrato_descripcion;
    }


    //// FUNCIONES - INTERFAZ DE CONEXIÓN - FIN

    /// Manejo de versiones

    /**
     * @return PresupuestoCabecera|null
     */
    public function getACopy()
    {
        if (Yii::$app->user->isGuest) {
            return null;
        }

        $clon = new PresupuestoCabecera($this->getAttributes([
            'presupuesto_cabecera_id_original',
            'presupuesto_version_id',
            'indice_linea',
            'nombre_linea',
            'numeracion_linea',
            'nivel',
            'partida_id',
            'jerarquia',
            'presupuesto_contrato_id',
            'objetivo_estrategico_id',
            'accion_estrategica_id',
            'meta_fisica_id',
            'meta_financiera_id',
            'categoria_producto_id'
        ]));
        $clon->isNewRecord    = true;
        $clon->actualizado_por= Yii::$app->user->identity->usuario_id;
        $clon->actualizado_en = date('Y-m-d H:i:s');
        $clon->creado_por     = Yii::$app->user->identity->usuario_id;
        $clon->creado_en      = date('Y-m-d H:i:s');
        $clon->periodo_inicio = 0;
        //$clon->periodo_fin    = 0;
        $clon->esta_actualizado = true;

        return $clon;
    }

    /**
     * @param $last_version_id
     * @param $presupuesto_cabecera_padre_id
     */
    public function guardarCopiaCompleta($last_version_id, $presupuesto_cabecera_padre_id, $remplazar_cabecera_padre = true){//, $guardar_directamente = true){
        $mi_copia = $this->getACopy();
        $mi_copia->presupuesto_version_id  = $last_version_id;
        if ($remplazar_cabecera_padre){
            $mi_copia->presupuesto_cabecera_padre_id = $presupuesto_cabecera_padre_id;
        }
        $mi_copia->save();
        //$presupuestos = [];
        foreach ($this->presupuestos as $presupuesto_iterador){
            $copia_presupuesto = $presupuesto_iterador->getACopy();
            $copia_presupuesto->presupuesto_cabecera_id = $mi_copia->presupuesto_cabecera_id;
            $copia_presupuesto->save();
            //$presupuestos[] = $copia_presupuesto;
        }
        return $mi_copia;
        //return [ 'presupuesto_cabecera' => $mi_copia, 'presupuestos' => $presupuestos];
    }

    /***
     * @param $presupuesto_cabecera_id
     * @param $last_version_id
     * @return bool
     */
    static function guardarNuevaVersionTotal($presupuesto_cabecera_id, $last_version_id)
    {
        $presupuesto_cabecera_actual = PresupuestoCabecera::findOne(['presupuesto_cabecera_id' => $presupuesto_cabecera_id]);
        if ($presupuesto_cabecera_actual == null) return false;


        /*
        $nro_version_siguiente = $presupuesto_cabecera_actual->presupuestoVersion->nro_version + 1;
        $siguiente_version = PresupuestoVersion::findOne(['nro_version' => $nro_version_siguiente ]);

        //$last_version = PresupuestoVersion::findOne(['nro_version' => PresupuestoVersion::find()->max('nro_version')]);
        if ($siguiente_version == null) {
            $siguiente_version = new PresupuestoVersion();
            $siguiente_version->fecha = date('Y-m-d');
            $siguiente_version->nro_version = $nro_version_siguiente + 1;
            $siguiente_version->save();
        }
        $last_version_id = $siguiente_version->presupuesto_version_id;
        // */

        $array_id_padre_cabeceras =[null => [$presupuesto_cabecera_actual]];
        //[null => PresupuestoCabecera::find()->where('presupuesto_cabecera_id isNull And presupuesto_version_id = '.$last_version->presupuesto_version_id)->all()];

        while (count($array_id_padre_cabeceras) > 0){
            $array_id_padre_cabeceras_siguiente = [];
            foreach ($array_id_padre_cabeceras as $id_padre => $cabeceras) {
                foreach ($cabeceras as $iterador_cabecera) {
                    $nueva_cabecera = $iterador_cabecera->guardarCopiaCompleta($last_version_id, $id_padre);

                    $array_cabeceras_siguiente_nivel = PresupuestoCabecera::findAll(['presupuesto_cabecera_padre_id' => $iterador_cabecera->presupuesto_cabecera_id]);

                    if (count($array_cabeceras_siguiente_nivel) > 0) {
                        $array_id_padre_cabeceras_siguiente[$nueva_cabecera->presupuesto_cabecera_id] = $array_cabeceras_siguiente_nivel;
                    }
                }
            }
            $array_id_padre_cabeceras = $array_id_padre_cabeceras_siguiente;
        }

    }

    public function loadMetas(){
        $meta_financiera = MetaFinanciera::find()->where(['presupuesto_cabecera_id'=>$this->presupuesto_cabecera_id])->one();
        $meta_fisica     = MetaFisica::find()->where(['presupuesto_cabecera_id'    =>$this->presupuesto_cabecera_id])->one();

        if ($meta_fisica != null){
            $this->meta_fisica_id = $meta_fisica->meta_fisica_id;
            $this->meta_fisica_descripcion = $meta_fisica->descripcion;
            $this->meta_fisica_unidad_medida_id = $meta_fisica->unidad_medida_id;
            $this->meta_fisica_avance_actual    = $meta_fisica->avance_actual;
            $this->meta_fisica_avance_total     =  $meta_fisica->avance_total;
        }

        if ($meta_financiera != null){
            $this->meta_financiera_id = $meta_financiera->meta_financiera_id;
            $this->meta_financiera_descripcion = $meta_financiera->descripcion;
            $this->meta_financiera_unidad_medida_id = $meta_financiera->unidad_medida_id;
            $this->meta_financiera_avance_actual = $meta_financiera->avance_actual;
            $this->meta_financiera_avance_total  = $meta_financiera->avance_total;
            $this->meta_financiera_precio_unitario_ro   = $meta_financiera->precio_unitario_ro    ;
            $this->meta_financiera_precio_unitario_rooc = $meta_financiera->precio_unitario_rooc;
            $this->meta_financiera_monto_total_ro   = $meta_financiera->monto_total_ro;
            $this->meta_financiera_monto_total_rooc = $meta_financiera->monto_total_rooc;
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->esta_actualizado){/// ANTES ERA: ->Es_copia
            return true;
        }

        if ($insert AND !$this->esta_actualizado){

            $primer_estado_metacodigo = Metacodigo::findOne([
                'descripcion'  => Yii::$app->params['presupuesto_estado']['primer_estado'],
                'nombre_lista' => Yii::$app->params['metacodigoFlags']['Estado_Presupuesto']
            ]);

            if ($this->es_factibilidad) {
                $periodo_cero = Periodo::findOne(['periodo_id' => 1]);
                $this->crearNuevoPresupuesto($periodo_cero, $primer_estado_metacodigo);
            }

            $this->actualizarJerarquiaPadre();

            $this->esta_actualizado = true;
            $this->presupuesto_cabecera_id_original = $this->presupuesto_cabecera_id;
            $this->save();

            /// Creación de meta financiera y fisica

            if (isset($this->meta_fisica_unidad_medida_id ) AND $this->meta_fisica_unidad_medida_id != null){
                $meta_fisica = new MetaFisica();
                $meta_fisica->isNewRecord = true;
                $meta_fisica->descripcion = $this->meta_fisica_descripcion;
                $meta_fisica->estado_regitro = 1;
                $meta_fisica->presupuesto_cabecera_id = $this->presupuesto_cabecera_id;
                $meta_fisica->unidad_medida_id = $this->meta_fisica_unidad_medida_id;
                $meta_fisica->avance_actual = $this->meta_fisica_avance_actual;
                $meta_fisica->avance_total  = $this->meta_fisica_avance_total;
                $meta_fisica->save();
            }

            if (isset($this->meta_financiera_unidad_medida_id ) AND $this->meta_financiera_unidad_medida_id != null){
                $meta_financiera = new MetaFinanciera();
                $meta_financiera->isNewRecord = true;
                $meta_financiera->descripcion = $this->meta_financiera_descripcion;
                $meta_financiera->estado_regitro = 1;
                $meta_financiera->presupuesto_cabecera_id = $this->presupuesto_cabecera_id;
                $meta_financiera->unidad_medida_id = $this->meta_fisica_unidad_medida_id;
                $meta_financiera->avance_actual = $this->meta_fisica_avance_actual;
                $meta_financiera->avance_total  = $this->meta_fisica_avance_total;
                $meta_financiera->precio_unitario_ro    = $this->meta_financiera_precio_unitario_ro;
                $meta_financiera->precio_unitario_rooc  = $this->meta_financiera_precio_unitario_rooc;
                $meta_financiera->monto_total_ro    = $this->meta_financiera_monto_total_ro;
                $meta_financiera->monto_total_rooc  = $this->meta_financiera_monto_total_rooc;
                $meta_financiera->save();
            }
            /// Creación de meta financiera y fisica

            parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        }else{
            if (isset($this->meta_fisica_id) AND $this->meta_fisica_id != null){
                $meta_fisica =  MetaFisica::findOne($this->meta_fisica_id);
                //$meta_fisica->estado_regitro = 1;
                $meta_fisica->descripcion = $this->meta_fisica_descripcion;
                $meta_fisica->presupuesto_cabecera_id = $this->presupuesto_cabecera_id;
                $meta_fisica->unidad_medida_id  = $this->meta_fisica_unidad_medida_id;
                $meta_fisica->avance_actual     = $this->meta_fisica_avance_actual;
                $meta_fisica->avance_total      = $this->meta_fisica_avance_total;
                $meta_fisica->save();
            }else{
                $meta_fisica = new MetaFisica();
                $meta_fisica->isNewRecord = true;
                $meta_fisica->descripcion = $this->meta_fisica_descripcion;
                $meta_fisica->estado_regitro = 1;
                $meta_fisica->presupuesto_cabecera_id = $this->presupuesto_cabecera_id;
                $meta_fisica->unidad_medida_id = $this->meta_fisica_unidad_medida_id;
                $meta_fisica->avance_actual = $this->meta_fisica_avance_actual;
                $meta_fisica->avance_total  = $this->meta_fisica_avance_total;
                $meta_fisica->save();
            }

            if (isset($this->meta_financiera_id) AND $this->meta_financiera_id != null){
                $meta_financiera = MetaFinanciera::findOne($this->meta_financiera_id);
                //$meta_financiera->estado_regitro = 1;
                $meta_financiera->descripcion = $this->meta_financiera_descripcion;
                $meta_financiera->unidad_medida_id  = $this->meta_fisica_unidad_medida_id;
                $meta_financiera->avance_actual     = $this->meta_fisica_avance_actual;
                $meta_financiera->avance_total      = $this->meta_fisica_avance_total;
                $meta_financiera->precio_unitario_ro    = $this->meta_financiera_precio_unitario_ro;
                $meta_financiera->precio_unitario_rooc  = $this->meta_financiera_precio_unitario_rooc;
                $meta_financiera->monto_total_ro    = $this->meta_financiera_monto_total_ro;
                $meta_financiera->monto_total_rooc  = $this->meta_financiera_monto_total_rooc;
                $meta_financiera->save();
            }else{
                $meta_financiera = new MetaFinanciera();
                $meta_financiera->isNewRecord = true;
                $meta_financiera->descripcion = $this->meta_financiera_descripcion;
                $meta_financiera->estado_regitro = 1;
                $meta_financiera->presupuesto_cabecera_id = $this->presupuesto_cabecera_id;
                $meta_financiera->unidad_medida_id = $this->meta_fisica_unidad_medida_id;
                $meta_financiera->avance_actual = $this->meta_fisica_avance_actual;
                $meta_financiera->avance_total  = $this->meta_fisica_avance_total;
                $meta_financiera->precio_unitario_ro    = $this->meta_financiera_precio_unitario_ro;
                $meta_financiera->precio_unitario_rooc  = $this->meta_financiera_precio_unitario_rooc;
                $meta_financiera->monto_total_ro    = $this->meta_financiera_monto_total_ro;
                $meta_financiera->monto_total_rooc  = $this->meta_financiera_monto_total_rooc;
                $meta_financiera->save();
            }

        }

    }

    static function getColumnFieldsOld(){

        return $cabeza_columnas = [
            [
                'class' => 'kartik\grid\CheckboxColumn',
                'width' => '20px',
            ],
            [
                'class' => 'kartik\grid\SerialColumn',
                'width' => '30px',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'presupuestoVersion.nro_version',
            ],/*
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'nombre_presupuesto',
                ],// */
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'vAlign'=>'middle',
                'urlCreator' => function($action, $model, $key, $index) {
                    return Url::to([$action,'id'=>$key]);
                },
                'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
                'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
                'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'Are you sure?',
                    'data-confirm-message'=>'Are you sure want to delete this item'],
            ],
        ];
    }

    //////  Para la vista Final
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactibilidad()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->where([ 'presupuesto.periodo_id' => 1]);
        //'presupuesto_cabecera.presupuesto_version_id' => PresupuestoVersion::getUltimaVersion()->presupuesto_version_id ]);
    }

    public function getFactibilidadPlanRo()
    {
        $factibilidad = $this->getFactibilidad()->one();
        if($factibilidad != null){
            return $factibilidad->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getFactibilidadPlanRooc()
    {
        $factibilidad = $this->getFactibilidad()->one();
        if($factibilidad != null){
            return $factibilidad->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getFactibilidadId()
    {
        $factibilidad = $this->getFactibilidad()->one();
        if($factibilidad != null){
            return $factibilidad->presupuesto_id;
        }else{
            return null;
        }
    }

    public function getSumaFactibilidad(){
        $ro   = $this->getFactibilidadPlanRo();
        $rooc = $this->getFactibilidadPlanRooc();
        if ($ro   == null ){ $ro   = 0;}
        if ($rooc == null ){ $rooc = 0;}
        return $ro + $rooc;
    }

    /**
     *
     */
    public function getPorcentajeAvance(){
        $factibilidad = $this->getFactibilidad()->one();
        if ($factibilidad == null){
            return 0;
        }
        $ro_plan     = $factibilidad->presupuesto_plan_ro;
        $rooc_plan   = $factibilidad->presupuesto_plan_rooc;
        $ro_saldo   = $factibilidad->presupuesto_saldo_ro;
        $rooc_saldo = $factibilidad->presupuesto_saldo_rooc;
        if ($ro_plan>0){
            $avance_ro   = round( ($ro_plan - $ro_saldo)/ $ro_plan, 2);
        }else{
            $avance_ro = 0;
        }

        if ($rooc_plan>0){
            $avance_rooc   = round( ($rooc_plan - $rooc_saldo)/ $rooc_plan,2);
        }else{
            $avance_rooc = 0;
        }
        return ($avance_ro + $avance_rooc)/2;
    }

    public function crearPoa($anho){

        for ($mes = 1; $mes < 13 ; $mes++){

            $miPeriodo = Periodo::findOne(['anho' => $anho, 'mes' => $mes]);

            if (!(isset($miPeriodo) && $miPeriodo != null)){
                $nuevo_periodo = new Periodo();
                $nuevo_periodo->anho = $anho;
                $nuevo_periodo->mes = $mes;

                if ($mes < 4){
                    $trimestre = 1;
                }elseif ($mes < 7){
                    $trimestre = 2;
                }elseif ($mes < 10){
                    $trimestre = 3;
                }else{
                    $trimestre = 4;
                }
                $nuevo_periodo->trimestre = $trimestre;
                $nuevo_periodo->save();
            }
        }

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoEnero()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 1,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoEneroId()
    {
        $presupuesto = $this->getPresupuestoEnero()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoEneroRo()
    {
        $presupuesto = $this->getPresupuestoEnero()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoEneroRooc()
    {
        $presupuesto = $this->getPresupuestoEnero()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoEneroSuma()
    {
        $presupuesto = $this->getPresupuestoEnero()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoFebrero()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 2,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoFebreroId()
    {
        $presupuesto = $this->getPresupuestoFebrero()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoFebreroRo()
    {
        $presupuesto = $this->getPresupuestoFebrero()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoFebreroRooc()
    {
        $presupuesto = $this->getPresupuestoFebrero()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoFebreroSuma()
    {
        $presupuesto = $this->getPresupuestoFebrero()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoMarzo()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 3,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoMarzoId()
    {
        $presupuesto = $this->getPresupuestoMarzo()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoMarzoRo()
    {
        $presupuesto = $this->getPresupuestoMarzo()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoMarzoRooc()
    {
        $presupuesto = $this->getPresupuestoMarzo()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoMarzoSuma()
    {
        $presupuesto = $this->getPresupuestoMarzo()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoAbril()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 4,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoAbrilId()
    {
        $presupuesto = $this->getPresupuestoAbril()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoAbrilRo()
    {
        $presupuesto = $this->getPresupuestoAbril()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoAbrilRooc()
    {
        $presupuesto = $this->getPresupuestoAbril()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoAbrilSuma()
    {
        $presupuesto = $this->getPresupuestoAbril()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoMayo()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 5,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoMayoId()
    {
        $presupuesto = $this->getPresupuestoMayo()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoMayoRo()
    {
        $presupuesto = $this->getPresupuestoMayo()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoMayoRooc()
    {
        $presupuesto = $this->getPresupuestoMayo()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoMayoSuma()
    {
        $presupuesto = $this->getPresupuestoMayo()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoJunio()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 6,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoJunioId()
    {
        $presupuesto = $this->getPresupuestoJunio()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    /// optimizaddo
    /// public function getPresupuestoJunioId()
    //    {
    //        if (isset($this->presupuesto_junio) AND $this->presupuesto_junio != null){
    //            return $this->presupuesto_junio->presupuesto_id;
    //        }else{
    //            $presupuesto = $this->getPresupuestoJunio()->one();
    //            if ($presupuesto != null){
    //                $this->presupuesto_junio = $presupuesto;
    //                return $presupuesto->presupuesto_id;
    //            }else{
    //                return null;
    //            }
    //        }
    //
    //    }

    function getPresupuestoJunioRo()
    {
        $presupuesto = $this->getPresupuestoJunio()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoJunioRooc()
    {
        $presupuesto = $this->getPresupuestoJunio()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoJunioSuma()
    {
        $presupuesto = $this->getPresupuestoJunio()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoJulio()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 7,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoJulioId()
    {
        $presupuesto = $this->getPresupuestoJulio()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoJulioRo()
    {
        $presupuesto = $this->getPresupuestoJulio()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoJulioRooc()
    {
        $presupuesto = $this->getPresupuestoJulio()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoJulioSuma()
    {
        $presupuesto = $this->getPresupuestoJulio()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoAgosto()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 8,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoAgostoId()
    {
        $presupuesto = $this->getPresupuestoAgosto()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoAgostoRo()
    {
        $presupuesto = $this->getPresupuestoAgosto()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoAgostoRooc()
    {
        $presupuesto = $this->getPresupuestoAgosto()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoAgostoSuma()
    {
        $presupuesto = $this->getPresupuestoAgosto()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoSeptiembre()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 9,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoSeptiembreId()
    {
        $presupuesto = $this->getPresupuestoSeptiembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoSeptiembreRo()
    {
        $presupuesto = $this->getPresupuestoSeptiembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoSeptiembreRooc()
    {
        $presupuesto = $this->getPresupuestoSeptiembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoSeptiembreSuma()
    {
        $presupuesto = $this->getPresupuestoSeptiembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoOctubre()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 10,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoOctubreId()
    {
        $presupuesto = $this->getPresupuestoOctubre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoOctubreRo()
    {
        $presupuesto = $this->getPresupuestoOctubre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoOctubreRooc()
    {
        $presupuesto = $this->getPresupuestoOctubre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoOctubreSuma()
    {
        $presupuesto = $this->getPresupuestoOctubre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoNoviembre()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 11,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoNoviembreId()
    {
        $presupuesto = $this->getPresupuestoNoviembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoNoviembreRo()
    {
        $presupuesto = $this->getPresupuestoNoviembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoNoviembreRooc()
    {
        $presupuesto = $this->getPresupuestoNoviembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoNoviembreSuma()
    {
        $presupuesto = $this->getPresupuestoNoviembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoDiciembre()
    {
        return $this->hasOne(Presupuesto::className(), [
            'presupuesto_cabecera_id' => 'presupuesto_cabecera_id'
        ])->leftJoin(Periodo::tableName(),'presupuesto.periodo_id = periodo.periodo_id')
            ->where([ 'periodo.mes' => 12,'periodo.anho' => PresupuestoCabecera::anhoBusqueda()]);
    }

    public function getPresupuestoDiciembreId()
    {
        $presupuesto = $this->getPresupuestoDiciembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_id;
        }else{
            return null;
        }
    }

    function getPresupuestoDiciembreRo()
    {
        $presupuesto = $this->getPresupuestoDiciembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro;
        }else{
            return null;
        }
    }

    public function getPresupuestoDiciembreRooc()
    {
        $presupuesto = $this->getPresupuestoDiciembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    public function getPresupuestoDiciembreSuma()
    {
        $presupuesto = $this->getPresupuestoDiciembre()->one();
        if ($presupuesto != null){
            return $presupuesto->presupuesto_plan_ro + $presupuesto->presupuesto_plan_rooc;
        }else{
            return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumeracionPresupuesto()
    {
        return $this->numeracion_linea;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNombrePresupuesto()
    {
        return $this->nombre_linea;
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMetaFinanciera(){
        return MetaFinanciera::find()->where(['presupuesto_cabecera_id' => $this->presupuesto_cabecera_id])->one();
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMetaFisica(){
        return MetaFisica::find()->where(['presupuesto_cabecera_id' => $this->presupuesto_cabecera_id])->one();
    }


    //////  Para la vista Final


    /**
     * @param $traspasar_saldos : Bool
     * @param $periodo_de_cierre_id : Int
     * @param $version_id : Int
     */
    static function cierrePresupuestalTotal($traspasar_saldos, $periodo_de_cierre_id, $version_id){

        $presupuesto_traspaso = Presupuesto::find()->where(['periodo_id' => $periodo_de_cierre_id])->one();

        $cabeceras = PresupuestoCabecera::find()
            ->leftJoin(
                PresupuestoVersion::tableName(),
                'presupuesto_version.presupuesto_version_id = presupuesto_cabecera.presupuesto_version_id'
            )
            ->where('presupuesto_version.presupuesto_version_id = '.$version_id." ")->all();

        foreach ( $cabeceras as $cabecera){
            $presupuesto = Presupuesto::find()
                ->leftJoin(
                    Periodo::tableName(),
                    'periodo.periodo_id = presupuesto.periodo_id'
                )->where("presupuesto.presupuesto_cabecera_id = ".$cabecera->presupuesto_cabecera_id.
                    "periodo.estatus_abierto > 0 AND
                 (periodo.anho * 12 + periodo.mes) < 
             (".($presupuesto_traspaso->anho * 12 + $presupuesto_traspaso->mes ).") ")->all();

            $saldos = $presupuesto->cierrePresupuestal($traspasar_saldos);

            $presupuesto_traspaso->presupuesto_plan_ro   += $saldos['ro'];
            $presupuesto_traspaso->presupuesto_plan_rooc += $saldos['rooc'];

            $presupuesto_traspaso->presupuesto_saldo_ro   += $saldos['ro'];
            $presupuesto_traspaso->presupuesto_saldo_rooc += $saldos['rooc'];
        }

        $presupuesto_traspaso->save();

    }
}
