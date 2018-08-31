<?php

namespace app\controllers\rrhh;

use Yii;
use app\models\rrhh\ContratoEntregable;
use app\models\rrhh\ContratoEntregableSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\rrhh\ContratoContrato;
use app\controllers\BehaviorController;
use app\models\rrhh\StaffArea;
use app\models\Presupuesto\Periodo;
use app\models\Presupuesto\PresupuestoCabecera;


/**
 * ContratoEntregableController implements the CRUD actions for ContratoEntregable model.
 */
class ContratoEntregableController extends BehaviorController
{
    public function actionCargarPeriodos(){
        $objeto_contrato_contrato = ContratoContrato::find()->where(['contrato_contrato_id'=>$_POST['codigo_contrato']])->one();
        return json_encode(PresupuestoCabecera::getComboBoxPeriodosDisponibles($objeto_contrato_contrato->codigo_arbol));
    }

    public function actionAnalizaContratoAdquisicion(){
        $objeto_contrato_contrato = ContratoContrato::find()->where(['contrato_contrato_id'=>$_POST['codigo_contrato']])->one();
        if($objeto_contrato_contrato->adquisicion_id>0)
            return 0;//no mostrar campo de periodos, ya que hay una adquisición con periodo asignado
        else 
            return 1;//mostrar campo de periodos
    }

    /**
     * Lists all ContratoEntregable models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new ContratoEntregableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single ContratoEntregable model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model   = $this->findModel($id);
        $codigo_interno_contrato = $model->getCodigoContrato()->one()->codigo_interno;
        $title   = "Entregable de Contrato : ".$codigo_interno_contrato."-".$model->descripcion;

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
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new ContratoEntregable model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new ContratoEntregable();  
        $model_contrato_contrato = new ContratoContrato();
        $title = "Registrar Nuevo Entregable de Contrato";
        $array_estado_de_entregables = $model->getArrayEstadoDeEntregables();
        $array_lista_codigos_contrato = $model_contrato_contrato->getArrayListaDeCodigosInternos();

        $objeto_staff_area = new StaffArea();
        $array_staff_area = $objeto_staff_area->getComboBoxItems();

        $array_periodo = [];//getComboBoxPeriodosDisponibles
        
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
                        'array_estado_de_entregables' => $array_estado_de_entregables,
                        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                        'array_staff_area' => $array_staff_area,
                        'array_periodo' => $array_periodo
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-entregable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Entregable Creado</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_estado_de_entregables' => $array_estado_de_entregables,
                        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                        'array_staff_area' => $array_staff_area,
                        'array_periodo' => $array_periodo
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
                return $this->redirect(['view', 'id' => $model->contrato_entregable_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_estado_de_entregables' => $array_estado_de_entregables,
                    'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                    'array_staff_area' => $array_staff_area,
                    'array_periodo' => $array_periodo
                ]);
            }
        }
       
    }

    /**
     * Updates an existing ContratoEntregable model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        
        $model   = $this->findModel($id);
        $codigo_interno_contrato = $model->getCodigoContrato()->one()->codigo_interno;
        $title   = "Actualizar Entregable de Contrato : ".$codigo_interno_contrato."-".$model->descripcion;

        $model_contrato_contrato = new ContratoContrato();
        
        $array_estado_de_entregables = $model->getArrayEstadoDeEntregables();
        $array_lista_codigos_contrato = $model_contrato_contrato->getArrayListaDeCodigosInternos();

        $objeto_staff_area = new StaffArea();
        $array_staff_area = $objeto_staff_area->getComboBoxItems();

        $array_periodo = Periodo::getComboBoxItems();
        
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
                        'array_estado_de_entregables' => $array_estado_de_entregables,
                        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                        'array_staff_area' => $array_staff_area,
                        'array_periodo' => $array_periodo
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-entregable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_estado_de_entregables' => $array_estado_de_entregables,
                        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                        'array_staff_area' => $array_staff_area,
                        'array_periodo' => $array_periodo
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_estado_de_entregables' => $array_estado_de_entregables,
                        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                        'array_staff_area' => $array_staff_area,
                        'array_periodo' => $array_periodo
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
                return $this->redirect(['view', 'id' => $model->contrato_entregable_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_estado_de_entregables' => $array_estado_de_entregables,
                    'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                    'array_staff_area' => $array_staff_area,
                    'array_periodo' => $array_periodo
                ]);
            }
        }
    }

    /**
     * Delete an existing ContratoEntregable model.
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-entregable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing ContratoEntregable model.
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-entregable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the ContratoEntregable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContratoEntregable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContratoEntregable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::$app->params['testoEspañol']['paginaNoEncontrada']);
        }
    }
}
