<?php

namespace app\controllers\Presupuesto;

use app\models\Presupuesto\Meta;
use app\models\Presupuesto\MetaFinanciera;
use app\models\Presupuesto\MetaFisica;
use app\models\Presupuesto\Partida;
use app\models\Presupuesto\Presupuesto;
use Yii;
use app\models\Presupuesto\PresupuestoCabecera;
use app\models\Presupuesto\PresupuestoCabeceraFinalSearch;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * PresupuestoCabeceraFinalController implements the CRUD actions for PresupuestoCabecera model.
 */
class PresupuestoCabeceraFinalController extends Controller
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
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
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
        if($presupuesto->periodo->estatus_abierto == 1){
            $presupuesto->setAttribute($campo,$valor);
            return $presupuesto->save();
        }else{
            return false;
        }
    }


    /**
     * guarda en session[nombre] = valor, nombre y valor se envian por metodo POST
     * @return bool
     */
    public function actionGuardarSession(){
        $nombre = $_POST['nombre_session'];
        $valor  = $_POST['valor'];
        $_SESSION[$nombre] = $valor;
        return true;
    }

    /**
     * Lists all PresupuestoCabecera models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new PresupuestoCabeceraFinalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,true);
        $columns = PresupuestoCabecera::getColumnFieldsFinalFactibilidad();
        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'columns'       => $columns,
            'es_factibilidad' => true,
        ]);
    }

    /**
     * Lists all PresupuestoCabecera models.
     * @return mixed
     */
    public function actionIndexPeriodos()
    {
        $searchModel = new PresupuestoCabeceraFinalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $columns = PresupuestoCabecera::getColumnFieldsFinalPeriodos();
        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'columns'       => $columns,
            'es_factibilidad' => false,
        ]);
    }

    /**
     * Displays a single PresupuestoCabecera model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "PresupuestoCabecera #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }


    public function actionCreatePoa()
    {
        $request = Yii::$app->request;
        $model = new PresupuestoCabecera();
        $title = 'Crear POA';

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create_poa', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->crearPoa($model->periodo_inicio)){
                return [
                    'title'=> $title,
                    'content'=>'<span class="text-success">Nuevo Periodo Poa <?=$model->periodo_inicio?> </span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Crear Más',['create-poa'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create_poa', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
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
                return $this->render('create_poa', [
                    'model' => $model,
                ]);
            }
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

        $title = "Crear Nueva Linea Presupuesto";
        $model->desde_interfaz_final = true;
        $array_partidas = Partida ::getComboBoxItems();
        $array_padres   = PresupuestoCabecera::getComboBoxItemsVerdaderoId(false, true);

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
                    'title'=> $title,
                    'content'=>'<span class="text-success">Create PresupuestoCabecera success</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
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
     * Creates a new PresupuestoCabecera model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateNuevosPeriodos()
    {
        $request = Yii::$app->request;
        $model = new PresupuestoCabecera();
        $title = "Crear Nuevo Periodo";

        $array_partidas = Partida::getComboBoxItems();
        $array_padres   = PresupuestoCabecera::getComboBoxItemsVerdaderoId(false);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create_nuevos_periodos', [
                        'model' => $model,
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->savePeriodos()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Create PresupuestoCabecera success</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Crear Más',['create_nuevos_periodos'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create_nuevos_periodos', [
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
                return $this->render('create_nuevos_periodos', [
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
        $model->loadMetas();

        $array_partidas = Partida ::getComboBoxItems();
        $array_padres   = PresupuestoCabecera::getComboBoxItemsVerdaderoId(false);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update PresupuestoCabecera #".$id,
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
                    'title'=> "PresupuestoCabecera #".$id,
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
                    'title'=> "Update PresupuestoCabecera #".$id,
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

    /**
     * @param null $q : cadena de la query a ser comparada con el nombre
     * @param null $id : id seleccionado, para el menú de actualización
     * @return string  : jSON
     * @throws \yii\db\Exception
     */
    public function actionPresupuestoCabeceraList($q = null, $id = null) {
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query();
            $query->select('presupuesto_cabecera_id AS id, nombre_linea AS text')
                ->from('presupuesto_cabecera')
                ->where(['like', 'numeracion_linea', $q.'%',false])
                ->orWhere(['like', 'nombre_linea', $q])
                ->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => PresupuestoCabecera::findOne($id)->nombre_linea];
        }
        return Json::encode($out);
    }

    public function actionVerificarNivel(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!isset($_POST['id'])){
            return ['show' => [ ],'hide' => [1,5,6]];
        }

        $item = PresupuestoCabecera::findOne($_POST['id']);

        if ($item == null){
            return ['show' => [], 'hide' => []];
        }else{
            $nivel  = $item->nivel + 1 ;
            switch ($nivel){
                case 1 :
                    return ['show' => [1],'hide' => [2,3,6,'categoria','producto']];
                case 2 :
                    return ['show' => [2],'hide' => [1,3,6,'categoria','producto']];
                case 3:
                    return ['show' => [3],'hide' => [1,2,6,'categoria','producto']];
                case 5:
                    if ($item->presupuestoContrato->esBancoMundial()){
                        return ['show' => ['categoria'],'hide' => [1,2,3,6,'producto']];
                    }else{
                        return ['show' => ['producto'] ,'hide' => [1,2,3,6,'categoria']];
                    }
                case 6 ://los proyectos normales
                    return ['show' => [6],'hide' => [1,2,3,'categoria','producto']];
                case 8 :// pip 1
                    if ($item->tipo_presupuesto == 1){
                        return ['show' => [6],'hide' => [1,2,3,'categoria','producto']];
                    }else{
                        return ['show' => [ ],'hide' => [1,2,3,6,'categoria','producto']];
                    }
                case 9 :// pip 2
                    if ($item->tipo_presupuesto == 2){
                        return ['show' => [6],'hide' => [1,2,3,'categoria','producto']];
                    }else{
                        return ['show' => [ ],'hide' => [1,2,3,6,'categoria','producto']];
                    }
                default:
                    return ['show' => [ ],'hide' => [1,2,3,6,'categoria','producto']];
            }
        }
    }

    /*
    public function actionVerificarNivel22(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!isset($_POST['id'])){
            return ['show' => [ ],'hide' => [1,5,6]];
        }

        $item = PresupuestoCabecera::findOne($_POST['id']);

        if ($item == null){
            return ['show' => [], 'hide' => []];
        }else{
            $nivel  = $item->nivel + 1 ;
            switch ($nivel){
                case 1 :
                    return ['show' => [1],'hide' => [2,5,6,'categoria','producto']];
                case 2 :
                    return ['show' => [2],'hide' => [1,5,6,'categoria','producto']];
                case 5 :
                    if ($item->presupuestoContrato->esBancoMundial()){
                        return ['show' => [5,'categoria'],'hide' => [1,2,6,'producto']];
                    }else{
                        return ['show' => [5,'producto'],'hide' => [1,2,6,'categoria']];
                    }
                case 6 :
                    return ['show' => [6],'hide' => [1,2,5,'categoria','producto']];
                default:
                    return ['show' => [ ],'hide' => [1,2,5,6,'categoria','producto']];
            }
        }
    }
    // */

}
