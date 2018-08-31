<?php

namespace app\controllers\rrhh;

use Yii;
use app\models\rrhh\ContratoPenalidad;
use app\models\rrhh\ContratoPenalidadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\rrhh\ContratoContrato;
use app\controllers\BehaviorController;
use app\models\rrhh\StaffArea;


/**
 * ContratoPenalidadController implements the CRUD actions for ContratoPenalidad model.
 */
class ContratoPenalidadController extends BehaviorController
{

    /**
     * Lists all ContratoPenalidad models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new ContratoPenalidadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single ContratoPenalidad model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $codigo_interno_contrato = $model->getCodigoContrato()->one()->codigo_interno;
        $title   = "Penalidad de Contrato : ".$codigo_interno_contrato."-".$model->descripcion;

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
     * Creates a new ContratoPenalidad model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new ContratoPenalidad();  
        $title = "Registrar Nueva Penalidad de Contrato";
        $model_contrato_contrato = new ContratoContrato();
        $array_lista_codigos_contrato = $model_contrato_contrato->getArrayListaDeCodigosInternos();

        $objeto_staff_area = new StaffArea();
        $array_staff_area = $objeto_staff_area->getComboBoxItems();

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
                        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                        'array_staff_area' => $array_staff_area
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-penalidad-pjax',
                    'title'=> "Create new ContratoPenalidad",
                    'content'=>'<span class="text-success">Contrato de Penalidad Creado</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new ContratoPenalidad",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                        'array_staff_area' => $array_staff_area
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
                return $this->redirect(['view', 'id' => $model->contrato_penalidad_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                    'array_staff_area' => $array_staff_area
                ]);
            }
        }
       
    }

    /**
     * Updates an existing ContratoPenalidad model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        
        $model = $this->findModel($id);
        $codigo_interno_contrato = $model->getCodigoContrato()->one()->codigo_interno;
        $title   = "Actualizar Penalidad de Contrato : ".$codigo_interno_contrato."-".$model->descripcion;   
        
        $model_contrato_contrato = new ContratoContrato();
        $array_lista_codigos_contrato = $model_contrato_contrato->getArrayListaDeCodigosInternos();

        $objeto_staff_area = new StaffArea();
        $array_staff_area = $objeto_staff_area->getComboBoxItems();

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
                        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                        'array_staff_area' => $array_staff_area
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-penalidad-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                        'array_staff_area' => $array_staff_area
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                        'array_staff_area' => $array_staff_area
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
                return $this->redirect(['view', 'id' => $model->contrato_penalidad_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
                    'array_staff_area' => $array_staff_area
                ]);
            }
        }
    }

    /**
     * Delete an existing ContratoPenalidad model.
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-penalidad-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing ContratoPenalidad model.
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-penalidad-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the ContratoPenalidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContratoPenalidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContratoPenalidad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::$app->params['testoEspañol']['paginaNoEncontrada']);
        }
    }
}
