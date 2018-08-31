<?php

namespace app\controllers\Viatico;

use Yii;
use app\models\Viatico\FondoRendicionViatico;
use app\models\Viatico\FondoRendicionViaticoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Viatico\FlujoRequerimiento;
use app\models\Patrimonio\DocumentoPnia;
use app\models\Patrimonio\Metacodigo;
use app\models\Viatico\FondoFondo;
use yii\web\UploadedFile;
use app\controllers\BehaviorController;
use app\models\Viatico\FondoRendicionGenerico;
use app\models\Viatico\FondoRendicionGenericoSearch;
use app\models\Viatico\ArbolArea;
use app\models\rrhh\StaffArea;
use app\models\Presupuesto\Periodo;
use app\models\Viatico\FlujoFlujo;
use yii\base\UserException;

/**
 * FondoRendicionViaticoController implements the CRUD actions for FondoRendicionViatico model.
 */
class FondoRendicionViaticoController extends BehaviorController
{

    
    public function actionLlenarMontoPredeterminado($id_fondo){
        
        $model_fondo = FondoFondo::find()->where(['fondo_fondo_id' => $id_fondo])->one();
        
        return \yii\helpers\Json::encode([
            // 'descripcion'=>$model->descripcion,
            // 'marca'=>$model->marca,
            // 'modelo'=>$model->modelo,
            // 'serie'=>$model->serie,
            'monto_de_fondo' => $model_fondo->total_entregado,
        ]);
    }
    
    
    /**
     * Lists all FondoRendicionViatico models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new FondoRendicionViaticoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchModelGestionRendicionViatico = new FondoRendicionGenericoSearch();
        $dataProviderGestionRendicionViatico = $searchModelGestionRendicionViatico->searchRendicionViatico(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelGestionRendicionViatico' => $searchModelGestionRendicionViatico,
            'dataProviderGestionRendicionViatico' => $dataProviderGestionRendicionViatico,
        ]);
    }


    /**
     * Displays a single FondoRendicionViatico model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Rendición de Viático #".$id,
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
     * Creates a new FondoRendicionViatico model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new FondoRendicionViatico();  
        
        $metacodigo_tipo_flujo_id = Metacodigo::getMetacodigoId('Tipo_flujo', 'Viático');
        $array_fondos_disponibles = FondoFondo::getComboBoxItemsPorMetacodigo($metacodigo_tipo_flujo_id);
        $lista_flujo_requerimiento = FlujoRequerimiento::getComboBoxItemsFiltrados('Viático');
        $model_documento_pnia = new DocumentoPnia();
        
        $id_persona = Yii::$app->user->identity->persona_id;
        $model_requerimiento = new FlujoRequerimiento();  
        $model_staff_area = StaffArea::find()->where(['responsable' => $id_persona])->one();
        $lista_presupuestos_ramas = ArbolArea::getComboBoxItemsArea($model_staff_area->staff_area_id);
        $array_periodo = Periodo::getComboBoxItems();
        $array_documentos_id = [];
        
//        $codigo_flujo = FlujoFlujo::find()->where(['nombre_flujo' => 'Rendición Viático'])->one();
//        $codigo_flujo = $codigo_flujo->flujo_flujo_id;

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Crear Nueva Rendición de Viático",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_fondos_disponibles' => $array_fondos_disponibles,
                        'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'model_requerimiento' => $model_requerimiento,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if ($model_documento_pnia->load(Yii::$app->request->post())) {
                
                $documento = UploadedFile::getInstance($model_documento_pnia, 'ruta_documento');
                if (isset($documento->extension))
                {
                    //echo Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;  
                    $documento->saveAs(Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension); 
                    $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->nombre_documento = $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->documento_mimetype = $documento->extension;
                    $model_documento_pnia->save();

                    $model->documento_pnia = $model_documento_pnia->documento_pnia_id;
                    array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                }
                

                if($model->load($request->post()) && $model->validate() ){
//                if($model->load($request->post()) && $model_requerimiento->load($request->post())){
//                    $model_requerimiento->monto = $model->anticipo_recibido;
//                    $model_requerimiento->descripcion = 'Requerimiento de Viático';
//                    $model_requerimiento->codigo_flujo = $codigo_flujo;
//                    $model_requerimiento->save();
//                    $model_requerimiento->asignarDocumentos($array_documentos_id);
//                    $model->flujo_requerimiento_id = $model_requerimiento->flujo_requerimiento_id;
                    $model->save();
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Crear Nueva Rendición de Viático",
                        'content'=>'<span class="text-success">Rendición de Viático Creada</span>',
                        'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                    ];    
                }
                else
                    echo ("Verifique que los campos obligatorios hayan sido rellenados.");
                    //return $model->save();
                
            } else{           
                return [
                    'title'=> "Crear Nueva Rendición de Viático",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_fondos_disponibles' => $array_fondos_disponibles,
                        'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'model_requerimiento' => $model_requerimiento,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model_documento_pnia->load(Yii::$app->request->post())) {
                
                $documento = UploadedFile::getInstance($model_documento_pnia, 'ruta_documento');
                if (isset($documento->extension))
                {
                    //echo Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;  
                    $documento->saveAs(Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension); 
                    $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->nombre_documento = $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->documento_mimetype = $documento->extension;
                    $model_documento_pnia->save();

                    $model->documento_pnia = $model_documento_pnia->documento_pnia_id;
                    array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                }
                
                if($model->load($request->post()) && $model->validate() ){
//                if($model->load($request->post()) && $model_requerimiento->load($request->post())){
//                    $model_requerimiento->monto = $model->anticipo_recibido;
//                    $model_requerimiento->descripcion = 'Requerimiento de Viático';
//                    $model_requerimiento->codigo_flujo = $codigo_flujo;
//                    $model_requerimiento->save();
//                    $model_requerimiento->asignarDocumentos($array_documentos_id);
//                    $model->flujo_requerimiento_id = $model_requerimiento->flujo_requerimiento_id;
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->fondo_rendicion_viatico_id]);
                }
                else
                    echo ("Verifique que los campos obligatorios hayan sido rellenados.");
                
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_fondos_disponibles' => $array_fondos_disponibles,
                    'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                    'model_documento_pnia' => $model_documento_pnia,
                    'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                    'array_periodo' => $array_periodo,
                    'model_requerimiento' => $model_requerimiento,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing FondoRendicionViatico model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);      
        
        $metacodigo_tipo_flujo_id = Metacodigo::getMetacodigoId('Tipo_flujo', 'Viático');
        $array_fondos_disponibles = FondoFondo::getComboBoxItemsPorMetacodigo($metacodigo_tipo_flujo_id);
        $lista_flujo_requerimiento = FlujoRequerimiento::getComboBoxItemsFiltrados('Viático');
        $model_documento_pnia = new DocumentoPnia();
        
        $id_persona = Yii::$app->user->identity->persona_id;
        $model_requerimiento = new FlujoRequerimiento();  
        $model_staff_area = StaffArea::find()->where(['responsable' => $id_persona])->one();
        $lista_presupuestos_ramas = ArbolArea::getComboBoxItemsArea($model_staff_area->staff_area_id);
        $array_periodo = Periodo::getComboBoxItems();
        $array_documentos_id = [];
        
//        $codigo_flujo = FlujoFlujo::find()->where(['nombre_flujo' => 'Rendición Viático'])->one();
//        $codigo_flujo = $codigo_flujo->flujo_flujo_id;

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Actualizar Rendición de Viático #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_fondos_disponibles' => $array_fondos_disponibles,
                        'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'model_requerimiento' => $model_requerimiento,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if ($model_documento_pnia->load(Yii::$app->request->post())) {
                
                $documento = UploadedFile::getInstance($model_documento_pnia, 'ruta_documento');
                if (isset($documento->extension))
                {
                    //echo Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;  
                    $documento->saveAs(Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension); 
                    $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->nombre_documento = $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->documento_mimetype = $documento->extension;
                    $model_documento_pnia->save();

                    $model->documento_pnia = $model_documento_pnia->documento_pnia_id;
                    array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                }
                
                if($model->load($request->post()) && $model->validate() ){
//                if($model->load($request->post()) && $model_requerimiento->load($request->post())){
//                    $model_requerimiento->monto = $model->anticipo_recibido;
//                    $model_requerimiento->descripcion = 'Requerimiento de Viático';
//                    $model_requerimiento->codigo_flujo = $codigo_flujo;
//                    $model_requerimiento->save();
//                    $model_requerimiento->asignarDocumentos($array_documentos_id);
//                    $model->flujo_requerimiento_id = $model_requerimiento->flujo_requerimiento_id;
                    $model->save();
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Rendición de Viático #".$id,
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                            'array_fondos_disponibles' => $array_fondos_disponibles,
                            'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                            'model_documento_pnia' => $model_documento_pnia,
                            'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                            'array_periodo' => $array_periodo,
                            'model_requerimiento' => $model_requerimiento,
                        ]),
                        'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];   
                }
                else
                    echo ("Verifique que los campos obligatorios hayan sido rellenados.");
                
            } else{
                 return [
                    'title'=> "Actualizar Rendición de Viático #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_fondos_disponibles' => $array_fondos_disponibles,
                        'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'model_requerimiento' => $model_requerimiento,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model_documento_pnia->load(Yii::$app->request->post())) {
                
                $documento = UploadedFile::getInstance($model_documento_pnia, 'ruta_documento');
                if (isset($documento->extension))
                {
                    //echo Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;  
                    $documento->saveAs(Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension); 
                    $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->nombre_documento = $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->documento_mimetype = $documento->extension;
                    $model_documento_pnia->save();

                    $model->documento_pnia = $model_documento_pnia->documento_pnia_id;
                    array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                }
                
                if($model->load($request->post()) && $model->validate() ){
//                if($model->load($request->post()) && $model_requerimiento->load($request->post())){
//                    $model_requerimiento->monto = $model->anticipo_recibido;
//                    $model_requerimiento->descripcion = 'Requerimiento de Viático';
//                    $model_requerimiento->codigo_flujo = $codigo_flujo;
//                    $model_requerimiento->save();
//                    $model_requerimiento->asignarDocumentos($array_documentos_id);
//                    $model->flujo_requerimiento_id = $model_requerimiento->flujo_requerimiento_id;
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->fondo_rendicion_viatico_id]);
                }
                else
                    echo ("Verifique que los campos obligatorios hayan sido rellenados.");
                
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_fondos_disponibles' => $array_fondos_disponibles,
                    'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                    'model_documento_pnia' => $model_documento_pnia,
                    'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                    'array_periodo' => $array_periodo,
                    'model_requerimiento' => $model_requerimiento,
                ]);
            }
        }
    }

    /**
     * Delete an existing FondoRendicionViatico model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
 
        try {
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

        }catch (IntegrityException $e) {
           throw new \yii\web\HttpException(500,"No puede borrar esta rendición de fondo de viático. Primero debe eliminar sus detalles asociados.", 405);
        }catch (\Exception $e) {
          throw new \yii\web\HttpException(500,"No puede borrar esta rendición de fondo de viático. Primero debe eliminar sus detalles asociados.", 405);
        }


    }

     /**
     * Delete multiple existing FondoRendicionViatico model.
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
     * Finds the FondoRendicionViatico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FondoRendicionViatico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FondoRendicionViatico::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCreateRendicionGenericaViatico(){
        return Yii::$app->runAction('Viatico/gestion-rendicion-viatico/create');
    }
}
