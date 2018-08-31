<?php

namespace app\controllers\Presupuesto;

use app\models\Presupuesto\Partida;
use app\models\Presupuesto\Periodo;
use app\models\Presupuesto\PresupuestoVersion;
use Yii;
use app\models\Presupuesto\Presupuesto;
use app\models\Presupuesto\PresupuestoCabecera;
use app\models\Presupuesto\PresupuestoCabeceraSearch;
use app\models\Presupuesto\PresupuestoSearch;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * PresupuestoCabeceraController implements the CRUD actions for PresupuestoCabecera model.
 */
class PresupuestoCabeceraFullController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'actualizar-datos' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionTest(){
        $cabecera_actual  = PresupuestoCabecera::findOne(2);
        $presupuesto = $cabecera_actual->getPresupuestoEn(2);
        $presupuesto->presupuesto_plan_ro = 20;
        $presupuesto->save();

    }

    /**
     * actualiza los datos de una celda
     * @return bool
     */
    public function actionActualizarDatos(){
        $presupuesto_id = $_POST['presupuesto_id'];
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];

        $presupuesto  = Presupuesto::findOne(['presupuesto_id' => $presupuesto_id]);
        $presupuesto->setAttribute($campo,$valor);
        return $presupuesto->save();
    }

    /**
     * Lists all PresupuestoCabecera models.
     * @return mixed
     */
    public function actionIndex($version_id = null)
    {
        $model = PresupuestoCabecera::findone(['presupuesto_cabecera_padre_id' => null]);
        //$model = PresupuestoCabecera::findone(['presupuesto_cabecera_id' => 1, 'presupuesto_cabecera_padre_id' => null]);
        if ($model) {
            $array_presupuestos_periodo_id = ArrayHelper::map($model->getPresupuestos()->orderBy('periodo_id')->all(), 'periodo_id', 'presupuesto_id');
        }else{
            $array_presupuestos_periodo_id = [];
        }

        //var_dump($array_presupuestos_periodo_id);

        $cabecera_query = 'SELECT actl_pc.*, 
                              partida.descripcion as nombre_partida ,
                              partida.partida_id as partida_partida_id,
                              linea_nivel.linea_nivel_id as linea_nivel_linea_nivel_id,
                              linea_nivel.nombre_linea as nombre_presupuesto,
                              linea_nivel.numeracion as numeracion_presupuesto,
                              linea_nivel.nivel as nivel,
                              (actl_pc.jerarquia = 2) as es_hoja 
                              ';
        $campos_presupuestos = '';

        foreach ($array_presupuestos_periodo_id as $periodo_actual_id => $presupuesto_actual_id){
            $campos_presupuestos .= ',
                              p'.$presupuesto_actual_id.'.mes                   as p'.$presupuesto_actual_id.'mes,
                              p'.$presupuesto_actual_id.'.anho                  as p'.$presupuesto_actual_id.'anho,
                              p'.$presupuesto_actual_id.'.presupuesto_id                as p'.$presupuesto_actual_id.'_presupuesto_id,
                              p'.$presupuesto_actual_id.'.presupuesto_plan_ro           as p'.$presupuesto_actual_id.'_presupuesto_plan_ro,
                              p'.$presupuesto_actual_id.'.presupuesto_compromiso_ro     as p'.$presupuesto_actual_id.'_presupuesto_compromiso_ro,
                              p'.$presupuesto_actual_id.'.presupuesto_devengado_ro      as p'.$presupuesto_actual_id.'_presupuesto_devengado_ro,
                              p'.$presupuesto_actual_id.'.presupuesto_girado_ro         as p'.$presupuesto_actual_id.'_presupuesto_girado_ro,
                              p'.$presupuesto_actual_id.'.presupuesto_pagado_ro         as p'.$presupuesto_actual_id.'_presupuesto_pagado_ro,
                              p'.$presupuesto_actual_id.'.presupuesto_ejecutado_ro      as p'.$presupuesto_actual_id.'_presupuesto_ejecutado_ro,
                              p'.$presupuesto_actual_id.'.presupuesto_saldo_ro          as p'.$presupuesto_actual_id.'_presupuesto_saldo_ro,
                              p'.$presupuesto_actual_id.'.presupuesto_saldo_anual_ro    as p'.$presupuesto_actual_id.'_presupuesto_saldo_anual_ro,
                              
                              p'.$presupuesto_actual_id.'.presupuesto_plan_rooc           as p'.$presupuesto_actual_id.'_presupuesto_plan_rooc,
                              p'.$presupuesto_actual_id.'.presupuesto_compromiso_rooc     as p'.$presupuesto_actual_id.'_presupuesto_compromiso_rooc,
                              p'.$presupuesto_actual_id.'.presupuesto_devengado_rooc      as p'.$presupuesto_actual_id.'_presupuesto_devengado_rooc,
                              p'.$presupuesto_actual_id.'.presupuesto_girado_rooc         as p'.$presupuesto_actual_id.'_presupuesto_girado_rooc,
                              p'.$presupuesto_actual_id.'.presupuesto_pagado_rooc         as p'.$presupuesto_actual_id.'_presupuesto_pagado_rooc,
                              p'.$presupuesto_actual_id.'.presupuesto_ejecutado_rooc      as p'.$presupuesto_actual_id.'_presupuesto_ejecutado_rooc,
                              p'.$presupuesto_actual_id.'.presupuesto_saldo_rooc          as p'.$presupuesto_actual_id.'_presupuesto_saldo_rooc,
                              p'.$presupuesto_actual_id.'.presupuesto_saldo_anual_rooc    as p'.$presupuesto_actual_id.'_presupuesto_saldo_anual_rooc';
        }

        $cola_query =     ' FROM presupuesto_cabecera AS actl_pc
                                    LEFT JOIN partida ON partida.partida_id = actl_pc.partida_id 
                                    LEFT JOIN linea_nivel ON linea_nivel.linea_nivel_id = actl_pc.linea_nivel_id  
                                    LEFT JOIN linea ON linea.linea_id = linea_nivel.linea_id';

        $join_presupuestos = '';

        foreach ($array_presupuestos_periodo_id as $periodo_actual_id => $presupuesto_actual_id){
            //$join_presupuestos .= ' LEFT JOIN (select * FROM presupuesto WHERE presupuesto.periodo_id = '.$periodo_actual_id.') p'.$presupuesto_actual_id.' ON p'.$presupuesto_actual_id.'.presupuesto_cabecera_id = actl_pc.presupuesto_cabecera_id';
            $join_presupuestos .= ' LEFT JOIN (select * FROM presupuesto LEFT JOIN periodo ON periodo.periodo_id = presupuesto.periodo_id WHERE presupuesto.periodo_id = '.$periodo_actual_id.') p'.$presupuesto_actual_id.' ON p'.$presupuesto_actual_id.'.presupuesto_cabecera_id = actl_pc.presupuesto_cabecera_id';
        }

        $sort_condition = ' ORDER BY numeracion_presupuesto';//' ORDER BY actl_pc.presupuesto_cabecera_padre_id, linea_nivel.nivel';

        $full_query = $cabecera_query.$campos_presupuestos.$cola_query.$join_presupuestos.$sort_condition;


        if ($version_id != null){
            $full_query .= ' where presupuesto_version_id = '.$version_id;
        }

        $searchModel  = new PresupuestoCabeceraSearch();
        $dataProvider = new SqlDataProvider([
            'sql' => $full_query,
            //'totalCount' => $totalCount,
            //'sort' => false,
            //'pagination' => 10,
        ]);

        /*
        $searchPresupuesto = new PresupuestoSearch();
        $dataPresupuesto = $searchPresupuesto->search(Yii::$app->request->queryParams);
        // */
        $columns = PresupuestoCabecera::getColumnFields($array_presupuestos_periodo_id);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,/*
            'searchPresupuesto' => $searchPresupuesto,
            'dataPresupuesto' => $dataPresupuesto, // */
            'columns' => $columns,
            'array_presupuestos_periodo_id' => $array_presupuestos_periodo_id,
            'title' => 'Gestión de Presupuestos por Líneas ',
        ]);
    }

    /**
     * Lists all PresupuestoCabecera models.
     * @return mixed
     */
    public function actionIndexResumido($version_id = null)
    {
        $model = PresupuestoCabecera::findone(['presupuesto_cabecera_padre_id' => null]);
        //$model = PresupuestoCabecera::findone(['presupuesto_cabecera_id' => 1, 'presupuesto_cabecera_padre_id' => null]);
        if ($model) {
            $array_presupuestos_periodo_id = ArrayHelper::map($model->getPresupuestos()->orderBy('periodo_id')->all(), 'periodo_id', 'presupuesto_id');
        }else{
            $array_presupuestos_periodo_id = [];
        }

        //var_dump($array_presupuestos_periodo_id);

        $cabecera_query = 'SELECT actl_pc.*, 
                              partida.descripcion as nombre_partida , partida.partida_id as partida_partida_id,
                              linea_nivel.linea_nivel_id as linea_nivel_linea_nivel_id, linea_nivel.nombre_linea as nombre_presupuesto';
        $campos_presupuestos = '';

        foreach ($array_presupuestos_periodo_id as $periodo_actual_id => $presupuesto_actual_id){
            $campos_presupuestos .= ',
                              actl_pc.jerarquia as p'.$presupuesto_actual_id.'_es_hoja,
                              p'.$presupuesto_actual_id.'.mes                   as p'.$presupuesto_actual_id.'mes,
                              p'.$presupuesto_actual_id.'.anho                  as p'.$presupuesto_actual_id.'anho,
                              p'.$presupuesto_actual_id.'.presupuesto_id                as p'.$presupuesto_actual_id.'_presupuesto_id,
                              
                              p'.$presupuesto_actual_id.'.presupuesto_plan_ro           as p'.$presupuesto_actual_id.'_presupuesto_plan_ro,
                              p'.$presupuesto_actual_id.'.presupuesto_saldo_ro          as p'.$presupuesto_actual_id.'_presupuesto_saldo_ro,
                              p'.$presupuesto_actual_id.'.presupuesto_saldo_anual_ro    as p'.$presupuesto_actual_id.'_presupuesto_saldo_anual_ro,
                              (p'.$presupuesto_actual_id.'.presupuesto_plan_ro - p'.$presupuesto_actual_id.'.presupuesto_saldo_ro) as p'.$presupuesto_actual_id.'_presupuesto_gasto_ro,
                              
                              p'.$presupuesto_actual_id.'.presupuesto_plan_rooc           as p'.$presupuesto_actual_id.'_presupuesto_plan_rooc,
                              p'.$presupuesto_actual_id.'.presupuesto_saldo_rooc          as p'.$presupuesto_actual_id.'_presupuesto_saldo_rooc,
                              p'.$presupuesto_actual_id.'.presupuesto_saldo_anual_rooc    as p'.$presupuesto_actual_id.'_presupuesto_saldo_anual_rooc,
                              (p'.$presupuesto_actual_id.'.presupuesto_plan_rooc - p'.$presupuesto_actual_id.'.presupuesto_saldo_rooc) as p'.$presupuesto_actual_id.'_presupuesto_gasto_rooc
                              
                              ';


        }

        $cola_query =     ' FROM presupuesto_cabecera AS actl_pc
                                    LEFT JOIN partida ON partida.partida_id = actl_pc.partida_id 
                                    LEFT JOIN linea_nivel ON linea_nivel.linea_nivel_id = actl_pc.linea_nivel_id  
                                    LEFT JOIN linea ON linea.linea_id = linea_nivel.linea_id';

        $join_presupuestos = 'actl_pc.presupuesto_cabecera';

        foreach ($array_presupuestos_periodo_id as $periodo_actual_id => $presupuesto_actual_id){
            //$join_presupuestos .= ' LEFT JOIN (select * FROM presupuesto WHERE presupuesto.periodo_id = '.$periodo_actual_id.') p'.$presupuesto_actual_id.' ON p'.$presupuesto_actual_id.'.presupuesto_cabecera_id = actl_pc.presupuesto_cabecera_id';
            $join_presupuestos .= ' LEFT JOIN (select * FROM presupuesto LEFT JOIN periodo ON periodo.periodo_id = presupuesto.periodo_id WHERE presupuesto.periodo_id = '.$periodo_actual_id.') p'.$presupuesto_actual_id.' ON p'.$presupuesto_actual_id.'.presupuesto_cabecera_id = actl_pc.presupuesto_cabecera_id';
        }


        $sort_condition = ' ORDER BY actl_pc.presupuesto_cabecera_padre_id, linea_nivel.nivel';

        $full_query = $cabecera_query.$campos_presupuestos.$cola_query.$join_presupuestos.$sort_condition;

        if ($version_id != null){
            $full_query .= ' where presupuesto_version_id = '.$version_id;
        }

        $searchModel  = new PresupuestoCabeceraSearch();
        $dataProvider = new SqlDataProvider([
            'sql' => $full_query,
            //'totalCount' => $totalCount,
            //'sort' => false,
            //'pagination' => 10,
        ]);

        $searchPresupuesto = new PresupuestoSearch();
        $dataPresupuesto = $searchPresupuesto->search(Yii::$app->request->queryParams);

        $columns = PresupuestoCabecera::getColumnFieldsResumido($array_presupuestos_periodo_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchPresupuesto' => $searchPresupuesto,
            'dataPresupuesto' => $dataPresupuesto,
            'columns' => $columns,
            'array_presupuestos_periodo_id' => $array_presupuestos_periodo_id,
            'title' => 'Planificación de Presupuestos Resumida',
        ]);
    }

    /**
     * Lists all PresupuestoCabecera models.
     * @return mixed
     */
    public function actionIndexTrimestre($version_id = null)
    {

        $query = 'Select presupuesto_cabecera.presupuesto_cabecera_id as cabecera ,
                    sumas.trimestre,
                    sumas.anho as año,
                    sumas.suma_plan_ro   as total_plan_ro,
                    sumas.suma_plan_rooc as total_plan_rooc,
                    sumas.suma_compromiso_ro   as total_comprometido_Ro,
                    sumas.suma_compromiso_rooc as total_comprometido_Rooc,
                    sumas.suma_devengado_ro    as total_devengado_ro,
                    sumas.suma_devengado_rooc  as total_devengado_rooc,
                    sumas.suma_girado_ro   as total_girado_ro,
                    sumas.suma_girado_rooc as total_girado_rooc,
                    sumas.suma_pagado_ro   as total_pagado_ro,
                    sumas.suma_pagado_rooc as total_pagado_ro,
                    sumas.suma_ejecutado_ro   as total_ejecutado_ro,
                    sumas.suma_ejecutado_rooc as total_ejecutado_ro,
                    sumas.suma_saldo_ro   as total_saldo_ro,
                    sumas.suma_saldo_rooc as total_saldo_rooc
                    from presupuesto_cabecera LEFT JOIN(
                    select 
                        trimestre, anho,
                        presupuesto.presupuesto_cabecera_id as presupuesto_cabecera_id,
                        sum(presupuesto_plan_ro)        as suma_plan_ro,
                        sum(presupuesto_compromiso_ro)  as suma_compromiso_ro,
                        sum(presupuesto_devengado_ro)   as suma_devengado_ro,
                        sum(presupuesto_girado_ro)      as suma_girado_ro,
                        sum(presupuesto_pagado_ro)      as suma_pagado_ro,
                        sum(presupuesto_ejecutado_ro)   as suma_ejecutado_ro,
                        sum(presupuesto_saldo_ro)       as suma_saldo_ro,
                        
                        sum(presupuesto_plan_rooc)        as suma_plan_rooc,
                        sum(presupuesto_compromiso_rooc)  as suma_compromiso_rooc,
                        sum(presupuesto_devengado_rooc)   as suma_devengado_rooc,
                        sum(presupuesto_girado_rooc)      as suma_girado_rooc,
                        sum(presupuesto_pagado_rooc)      as suma_pagado_rooc,
                        sum(presupuesto_ejecutado_rooc)   as suma_ejecutado_rooc,
                        sum(presupuesto_saldo_rooc)       as suma_saldo_rooc
                    FROM presupuesto 
                    LEFT JOIN periodo ON periodo.periodo_id = presupuesto.periodo_id';

        if ($version_id != null){
            $query .= 'WHERE presupuesto_cabecera.presupuesto_version_id = '.$version_id;
        }

        $query .= '
                    GROUP BY periodo.anho, periodo.trimestre, presupuesto.presupuesto_cabecera_id ) sumas ON sumas.presupuesto_cabecera_id = presupuesto_cabecera.presupuesto_cabecera_id
                    ORDER BY presupuesto_cabecera.presupuesto_cabecera_id, sumas.anho, sumas.trimestre';


        $searchModel  = new PresupuestoCabeceraSearch();
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            //'totalCount' => $totalCount,
            //'sort' => false,
            //'pagination' => 10,
        ]);

        $columns = [];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'title' => 'Resumen Presupuestal por Trimestres',
        ]);
    }

    /**
     * Lists all PresupuestoCabecera models.
     * @return mixed
     */
    public function actionIndexAnual($version_id = null)
    {

        $query = 'Select presupuesto_cabecera.presupuesto_cabecera_id as cabecera ,
                    sumas.anho as año,
                    sumas.suma_plan_ro   as total_plan_ro,
                    sumas.suma_plan_rooc as total_plan_rooc,
                    sumas.suma_compromiso_ro   as total_comprometido_Ro,
                    sumas.suma_compromiso_rooc as total_comprometido_Rooc,
                    sumas.suma_devengado_ro    as total_devengado_ro,
                    sumas.suma_devengado_rooc  as total_devengado_rooc,
                    sumas.suma_girado_ro   as total_girado_ro,
                    sumas.suma_girado_rooc as total_girado_rooc,
                    sumas.suma_pagado_ro   as total_pagado_ro,
                    sumas.suma_pagado_rooc as total_pagado_ro,
                    sumas.suma_ejecutado_ro   as total_ejecutado_ro,
                    sumas.suma_ejecutado_rooc as total_ejecutado_ro,
                    sumas.suma_saldo_ro   as total_saldo_ro,
                    sumas.suma_saldo_rooc as total_saldo_rooc
                    from presupuesto_cabecera LEFT JOIN(
                    select 
                        anho,
                        presupuesto.presupuesto_cabecera_id as presupuesto_cabecera_id,
                        sum(presupuesto_plan_ro)        as suma_plan_ro,
                        sum(presupuesto_compromiso_ro)  as suma_compromiso_ro,
                        sum(presupuesto_devengado_ro)   as suma_devengado_ro,
                        sum(presupuesto_girado_ro)      as suma_girado_ro,
                        sum(presupuesto_pagado_ro)      as suma_pagado_ro,
                        sum(presupuesto_ejecutado_ro)   as suma_ejecutado_ro,
                        sum(presupuesto_saldo_ro)       as suma_saldo_ro,
                        
                        sum(presupuesto_plan_rooc)        as suma_plan_rooc,
                        sum(presupuesto_compromiso_rooc)  as suma_compromiso_rooc,
                        sum(presupuesto_devengado_rooc)   as suma_devengado_rooc,
                        sum(presupuesto_girado_rooc)      as suma_girado_rooc,
                        sum(presupuesto_pagado_rooc)      as suma_pagado_rooc,
                        sum(presupuesto_ejecutado_rooc)   as suma_ejecutado_rooc,
                        sum(presupuesto_saldo_rooc)       as suma_saldo_rooc
                    FROM presupuesto 
                    LEFT JOIN periodo ON periodo.periodo_id = presupuesto.periodo_id';

        $query .= '
                    GROUP BY periodo.anho, presupuesto.presupuesto_cabecera_id ) sumas ON sumas.presupuesto_cabecera_id = presupuesto_cabecera.presupuesto_cabecera_id';


        if ($version_id != null){
            $query .= ' WHERE presupuesto_cabecera.presupuesto_version_id = '.$version_id;
        }else{
            $actl_version = PresupuestoVersion::getUltimaVersion()->presupuesto_version_id;
            $query .= ' WHERE presupuesto_cabecera.presupuesto_version_id = '.$actl_version;
        }// */

        $query .=  ' ORDER BY presupuesto_cabecera.presupuesto_cabecera_id, sumas.anho';

        $searchModel  = new PresupuestoCabeceraSearch();
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            //'totalCount' => $totalCount,
            //'sort' => false,
            //'pagination' => 10,
        ]);

        $columns = [];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'title' => 'Resumen Presupuestal Anualizado',
        ]);
    }

    /**
     * Displays a single PresupuestoCabecera model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $title = "Rama Presupuestal : ".$model->lineaNivel->nombre_linea;
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> $title,
                'content'=>$this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
            ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new PresupuestoCabecera model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PresupuestoCabecera();
        $title = "Crear Nueva Rama Presupuestal";
        $array_partidas = Partida::getComboBoxItems();
        $array_padres   = PresupuestoCabecera::getComboBoxItems(false);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new PresupuestoCabecera",
                    'content'=>'<span class="text-success">Registro exitoso</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Create new PresupuestoCabecera",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->presupuesto_cabecera_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_partidas' => $array_partidas,
                    'array_padres'   => $array_padres,
                ]);
            }
        }

    }

    /**
     * Updates an existing PresupuestoCabecera model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = "Actualizar Rama Presupuestal : ".$model->lineaNivel->nombre_linea;
        $array_partidas = Partida::getComboBoxItems();
        $array_padres   = PresupuestoCabecera::getComboBoxItems(false);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->presupuesto_cabecera_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_partidas' => $array_partidas,
                    'array_padres'   => $array_padres,
                ]);
            }
        }
    }

    /**
     * Delete an existing PresupuestoCabecera model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

    /**
     * Delete multiple existing PresupuestoCabecera model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the PresupuestoCabecera model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PresupuestoCabecera the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PresupuestoCabecera::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreatePresupuesto(){
        return Yii::$app->runAction('Presupuesto/presupuesto/create');
    }


}
