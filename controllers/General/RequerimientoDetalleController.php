<?php

namespace app\controllers\General;

use Yii;
use app\models\General\RequerimientoDetalle;
use app\models\General\RequerimientoDetalleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Patrimonio\DocumentoPniaSearch;
use app\controllers\BehaviorController;
use app\models\Patrimonio\DocumentoPnia;
use app\models\rrhh\StaffPersona;
use app\models\rrhh\StaffArea;
use app\models\Viatico\ArbolArea;
use app\models\Presupuesto\Periodo;

/**
 * RequerimientoDetalleController implements the CRUD actions for RequerimientoDetalle model.
 */
class RequerimientoDetalleController extends BehaviorController
{
    public function actionIndex()
    {    
        $searchModel = new RequerimientoDetalleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModelDocumentoPnia = new DocumentoPniaSearch();
        $dataProviderDocumentoPnia = $searchModelDocumentoPnia->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelDocumentoPnia' => $searchModelDocumentoPnia,
            'dataProviderDocumentoPnia' => $dataProviderDocumentoPnia,
        ]);
    }


    /**
     * Displays a single RequerimientoDetalle model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Ver Pedido",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
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
     * Creates a new RequerimientoDetalle model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new RequerimientoDetalle();  
        
        
        $model_flujo_requerimiento = new \app\models\Viatico\FlujoRequerimiento();
        $objeto_staff_area = new StaffArea();
        $array_staff_area = $objeto_staff_area->getComboBoxItems();
        
        $id_persona = Yii::$app->user->identity->persona_id;
        $model_staff_area = StaffArea::find()->where(['responsable' => $id_persona])->one();
        $lista_presupuestos_ramas = ArbolArea::getComboBoxItemsArea($model_staff_area->staff_area_id);

        $model_documento_pnia = new DocumentoPnia();;  
        $array_documentos_id = [];

        $array_periodo = Periodo::getComboBoxItems();

        $array_ro_rooc = $model_flujo_requerimiento->getComboBoxRoRooc();
        
        $array_tipo_bien_servicio = [1 => 'Bien', 2 => 'Servicio'];
        
        $array_flujo_requerimiento = \app\models\Viatico\FlujoRequerimiento::getComboBoxItems();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Crear nuevo Pedido",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_staff_area' => $array_staff_area,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'array_ro_rooc' => $array_ro_rooc,
                        'array_tipo_bien_servicio' => $array_tipo_bien_servicio,
                        'array_flujo_requerimiento' => $array_flujo_requerimiento
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Crear nuevo Pedido",
                    'content'=>'<span class="text-success">Pedido Creado</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Crear nuevo Pedido",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_staff_area' => $array_staff_area,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'array_ro_rooc' => $array_ro_rooc,
                        'array_tipo_bien_servicio' => $array_tipo_bien_servicio,
                        'array_flujo_requerimiento' => $array_flujo_requerimiento
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
                return $this->redirect(['view', 'id' => $model->requerimiento_detalle_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_staff_area' => $array_staff_area,
                    'model_documento_pnia' => $model_documento_pnia,
                    'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                    'array_periodo' => $array_periodo,
                    'array_ro_rooc' => $array_ro_rooc,
                    'array_tipo_bien_servicio' => $array_tipo_bien_servicio,
                    'array_flujo_requerimiento' => $array_flujo_requerimiento
                ]);
            }
        }
       
    }

    /**
     * Updates an existing RequerimientoDetalle model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);   
        
        $model_flujo_requerimiento = new \app\models\Viatico\FlujoRequerimiento();
        $model_documento_pnia = new DocumentoPnia();
        $model_puente_requerimiento_documento = new RequerimientoDocumento();
        $lista_requerimiento_documentos = RequerimientoDocumento::find()->where(['flujo_requerimiento_id'=>$id])->all();
        $array_documentos_id = [];

        $objeto_staff_area = new StaffArea();
        $array_staff_area = $objeto_staff_area->getComboBoxItems();
        
        $id_persona = Yii::$app->user->identity->persona_id;
        $model_staff_area = StaffArea::find()->where(['responsable' => $id_persona])->one();
        $lista_presupuestos_ramas = ArbolArea::getComboBoxItemsArea($model_staff_area->staff_area_id);

        $array_periodo = Periodo::getComboBoxItems();
        
        $array_ro_rooc = $model_flujo_requerimiento->getComboBoxRoRooc();
        
        $array_tipo_bien_servicio = [1 => 'Bien', 2 => 'Servicio'];
        
        $array_flujo_requerimiento = \app\models\Viatico\FlujoRequerimiento::getComboBoxItems();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Actualizar Pedido",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_staff_area' => $array_staff_area,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'array_ro_rooc' => $array_ro_rooc,
                        'array_tipo_bien_servicio' => $array_tipo_bien_servicio,
                        'array_flujo_requerimiento' => $array_flujo_requerimiento
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Actualizar Pedido",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_staff_area' => $array_staff_area,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'array_ro_rooc' => $array_ro_rooc,
                        'array_tipo_bien_servicio' => $array_tipo_bien_servicio,
                        'array_flujo_requerimiento' => $array_flujo_requerimiento
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Actualizar Pedido",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_staff_area' => $array_staff_area,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'array_ro_rooc' => $array_ro_rooc,
                        'array_tipo_bien_servicio' => $array_tipo_bien_servicio,
                        'array_flujo_requerimiento' => $array_flujo_requerimiento
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
                return $this->redirect(['view', 'id' => $model->requerimiento_detalle_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_staff_area' => $array_staff_area,
                    'model_documento_pnia' => $model_documento_pnia,
                    'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                    'array_periodo' => $array_periodo,
                    'array_ro_rooc' => $array_ro_rooc,
                    'array_tipo_bien_servicio' => $array_tipo_bien_servicio,
                    'array_flujo_requerimiento' => $array_flujo_requerimiento
                ]);
            }
        }
    }

    /**
     * Delete an existing RequerimientoDetalle model.
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
     * Delete multiple existing RequerimientoDetalle model.
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
     * Finds the RequerimientoDetalle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RequerimientoDetalle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RequerimientoDetalle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
