<?php

namespace app\controllers\rrhh;

use Yii;
use app\models\rrhh\ContratoContrato;
use app\models\rrhh\ContratoContratoSearch;

use app\models\rrhh\ContratoEntregable;
use app\models\rrhh\ContratoEntregableSearch;

use app\models\rrhh\ContratoPenalidad;
use app\models\rrhh\ContratoPenalidadSearch;

use app\controllers\ContratoEntregableController;
use app\controllers\ContratoPenalidadController;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\controllers\BehaviorController;
use yii\web\UploadedFile;
use app\models\Patrimonio\DocumentoPnia;
use app\models\Patrimonio\DocumentoPniaSearch;


use app\models\Presupuesto\PresupuestoCabecera;
use app\models\rrhh\StaffArea;
use app\models\Adquisicion\Adquisicion;
use app\models\Patrimonio\Metacodigo;
use app\models\Viatico\FlujoRequerimiento;
use \yii\helpers\ArrayHelper;
use app\models\Viatico\ArbolArea;
use app\models\Presupuesto\Periodo;
/**
 * ContratoContratoController implements the CRUD actions for ContratoContrato model.
 */
class ContratoContratoController extends BehaviorController
{
    public function actionCargarPeriodos(){
        $objeto_contrato_contrato = ContratoContrato::find()->where(['contrato_contrato_id'=>$_POST['codigo_contrato']])->one();
        return json_encode(PresupuestoCabecera::getComboBoxPeriodosDisponibles($objeto_contrato_contrato->codigo_arbol));
    }

    /**
     * Lists all ContratoContrato models.
     * @return mixed
     */
    public function actionIndexOrininal()
    {    
        $searchModel = new ContratoContratoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEnviarCodigoInterno(){
        $_SESSION['codigo_interno_contrato'] = $_POST['codigo_interno_contrato'];
        $_SESSION['codigo_visible_contrato'] = $_POST['codigo_visible_contrato'];
        return true;
    }

    public function actionIndex()
    {   
        $searchModel = new ContratoContratoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModelEntregable  = new ContratoEntregableSearch();
        $dataProviderEntregable = $searchModelEntregable->search(Yii::$app->request->queryParams);

        $searchModelPenalidad   = new ContratoPenalidadSearch();
        $dataProviderPenalidad  = $searchModelPenalidad->search(Yii::$app->request->queryParams);
        
        $searchModelDocumentoPnia = new DocumentoPniaSearch();
        $dataProviderDocumentoPnia = $searchModelDocumentoPnia->searchContratoDocumento(Yii::$app->request->queryParams);

        return $this->render('index_compuesto', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelEntregable'  => $searchModelEntregable,
            'dataProviderEntregable' => $dataProviderEntregable,
            'searchModelPenalidad'  => $searchModelPenalidad,
            'dataProviderPenalidad' => $dataProviderPenalidad,
            'searchModelDocumentoPnia' => $searchModelDocumentoPnia,
            'dataProviderDocumentoPnia' => $dataProviderDocumentoPnia,
        ]);
    }

    /**
     * Displays a single ContratoContrato model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = $this->findModel($id);
        $title = "Contrato ".$model->codigo_interno;
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
     * Creates a new ContratoContrato model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new ContratoContrato();  
        $array_entidades = $model->getEntidades();
        $array_areas = $model->getAreas();
        $array_contratos = $model->getContratos();
        $array_flags_es_staff = $model->getFlgsEsStaff();
        $title = "Registrar Nuevo Contrato";
        
        $id_persona = Yii::$app->user->identity->persona_id;
        if($id_persona){
            $array_areas = $model->getAreasDeUsuarioLogeado($id_persona);
        }  
        
        $model_documento_pnia = new DocumentoPnia();
        
        $objeto_metacodigo = new Metacodigo();
        $objeto_metacodigo = $objeto_metacodigo->find()->where(['nombre_lista'=>'Estado_paso','descripcion'=>'Contrato'])->one();

        $objeto_flujo_requerimiento = new FlujoRequerimiento();

        $objeto_adquisicion = new Adquisicion();
        $array_adquisicion = $objeto_adquisicion->getComboBoxItemsParaContrato();

        $id_persona = Yii::$app->user->identity->persona_id;
        $model_staff_area = StaffArea::find()->where(['responsable' => $id_persona])->one();
        $lista_presupuestos_ramas = ArbolArea::getComboBoxItemsArea($model_staff_area->staff_area_id);
        // $array_adquisicion = $objeto_adquisicion->find()->where(['estado_paso_metacodigo'=>$objeto_metacodigo->metacodigo_id])->all();
        
        $array_documentos_id = [];
        
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
                        'array_entidades' => $array_entidades,
                        'array_areas' => $array_areas,
                        'array_contratos' => $array_contratos,
                        'array_flags_es_staff' => $array_flags_es_staff,
                        'model_documento_pnia' => $model_documento_pnia,
                        'array_adquisicion' => $array_adquisicion,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if ($model->load($request->post()) && $model_documento_pnia->load($request->post()) && $model->validate()){
                
                $documento = UploadedFile::getInstances($model_documento_pnia, 'ruta_documento');
                if (isset($documento[0]->extension))
                {
                    foreach ($documento as $file) {
                        $model_documento_pnia = new DocumentoPnia();
                        $file->saveAs(Yii::getAlias('@uploadedfilesdir') . $file->baseName . '.' . $file->extension); 
                        $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->nombre_documento = $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->documento_mimetype = $file->extension;
                        $model_documento_pnia->save();
                        //echo($model_documento_pnia->nombre_documento .' ');
                        array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                        //$model->documento_pnia_id = $model_documento_pnia->documento_pnia_id;  
                    }
                }

                $model->flg_es_staff = 'no';
                $model->save();
                $model->asignarDocumentos($array_documentos_id);
                
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Crear nuevo contrato",
                    'content'=>'<span class="text-success">Contrato Creado</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];     
                
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_entidades' => $array_entidades,
                        'array_areas' => $array_areas,
                        'array_contratos' => $array_contratos,
                        'array_flags_es_staff' => $array_flags_es_staff,
                        'model_documento_pnia' => $model_documento_pnia,
                        'array_adquisicion' => $array_adquisicion,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,

                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model_documento_pnia->load($request->post()) && $model->validate()){
                $documento = UploadedFile::getInstances($model_documento_pnia, 'ruta_documento');
                if (isset($documento[0]->extension))
                {
                    foreach ($documento as $file) {
                        $model_documento_pnia = new DocumentoPnia();
                        $file->saveAs(Yii::getAlias('@uploadedfilesdir') . $file->baseName . '.' . $file->extension); 
                        $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->nombre_documento = $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->documento_mimetype = $file->extension;
                        $model_documento_pnia->save();
                        //echo($model_documento_pnia->nombre_documento .' ');
                        array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                        //$model->documento_pnia_id = $model_documento_pnia->documento_pnia_id;  
                    }
                }

                $model->flg_es_staff = 'no';
                $model->save();
                $model->asignarDocumentos($array_documentos_id);
                return $this->redirect(['view', 'id' => $model->contrato_contrato_id]);
                
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_entidades' => $array_entidades,
                    'array_areas' => $array_areas,
                    'array_contratos' => $array_contratos,
                    'array_flags_es_staff' => $array_flags_es_staff,
                    'model_documento_pnia' => $model_documento_pnia,
                    'array_adquisicion' => $array_adquisicion,
                    'lista_presupuestos_ramas' => $lista_presupuestos_ramas,

                ]);
            }
        }
       
    }

    /**
     * Updates an existing ContratoContrato model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = "Actualizar Contrato ".$model->codigo_interno;     
        $array_entidades = $model->getEntidades();
        $array_areas = $model->getAreas();
        $array_contratos = $model->getContratos();
        $array_flags_es_staff = $model->getFlgsEsStaff();
        
        $model_documento_pnia = new DocumentoPnia();
        $model_documento_actual_a_borrar = $model_documento_pnia->getDocumentoPorNombre($model->documento_pnia_id);
        
        $objeto_adquisicion = new Adquisicion();
        $array_adquisicion = $objeto_adquisicion->getComboBoxItemsParaContrato();

        $id_persona = Yii::$app->user->identity->persona_id;
        $model_staff_area = StaffArea::find()->where(['responsable' => $id_persona])->one();
        $lista_presupuestos_ramas = ArbolArea::getComboBoxItemsArea($model_staff_area->staff_area_id);
        
        $lista_contratos_documentos = ContratoDocumento::find()->where(['contrato_id'=>$id])->all();

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
                        'array_entidades' => $array_entidades,
                        'array_areas' => $array_areas,
                        'array_contratos' => $array_contratos,
                        'array_flags_es_staff' => $array_flags_es_staff,
                        'model_documento_pnia' => $model_documento_pnia,
                        'array_adquisicion' => $array_adquisicion,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,


                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if ($model->load($request->post()) && $model_documento_pnia->load($request->post()) && $model->validate()){
                
                //todo se borra del puente y de documentos antes de actualizar un documento nuevo subido o varios
                foreach($lista_contratos_documentos as $documento_actual){
                    $documento = DocumentoPnia::find()->where(['documento_pnia_id' => $documento_actual->documento_pnia_id])->one();
                    unlink(Yii::getAlias('@uploadedfilesdir') . $documento->nombre_documento);
                    $documento_actual->delete();
                    $documento->delete();
                }
                
                $documento = UploadedFile::getInstances($model_documento_pnia, 'ruta_documento');
                if (isset($documento[0]->extension))
                {
                    foreach ($documento as $file) {
                        $model_documento_pnia = new DocumentoPnia();
                        $file->saveAs(Yii::getAlias('@uploadedfilesdir') . $file->baseName . '.' . $file->extension); 
                        $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->nombre_documento = $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->documento_mimetype = $file->extension;
                        $model_documento_pnia->save();
                        //echo($model_documento_pnia->nombre_documento .' ');
                        array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                        //$model->documento_pnia_id = $model_documento_pnia->documento_pnia_id;  
                    }
                }

                $model->flg_es_staff = 'no';
                $model->save();
                $model->asignarDocumentos($array_documentos_id);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_entidades' => $array_entidades,
                        'array_areas' => $array_areas,
                        'array_contratos' => $array_contratos,
                        'array_flags_es_staff' => $array_flags_es_staff,
                        'model_documento_pnia' => $model_documento_pnia,
                        'array_adquisicion' => $array_adquisicion,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,

                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];   
                
            } else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_entidades' => $array_entidades,
                        'array_areas' => $array_areas,
                        'array_contratos' => $array_contratos,
                        'array_flags_es_staff' => $array_flags_es_staff,
                        'model_documento_pnia' => $model_documento_pnia,
                        'array_adquisicion' => $array_adquisicion,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,

                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model_documento_pnia->load($request->post()) && $model->validate()){
                //todo se borra del puente y de documentos antes de actualizar un documento nuevo subido o varios
                foreach($lista_contratos_documentos as $documento_actual){
                    $documento = DocumentoPnia::find()->where(['documento_pnia_id' => $documento_actual->documento_pnia_id])->one();
                    unlink(Yii::getAlias('@uploadedfilesdir') . $documento->nombre_documento);
                    $documento_actual->delete();
                    $documento->delete();
                }
                
                $documento = UploadedFile::getInstances($model_documento_pnia, 'ruta_documento');
                if (isset($documento[0]->extension))
                {
                    foreach ($documento as $file) {
                        $model_documento_pnia = new DocumentoPnia();
                        $file->saveAs(Yii::getAlias('@uploadedfilesdir') . $file->baseName . '.' . $file->extension); 
                        $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->nombre_documento = $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->documento_mimetype = $file->extension;
                        $model_documento_pnia->save();
                        //echo($model_documento_pnia->nombre_documento .' ');
                        array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                        //$model->documento_pnia_id = $model_documento_pnia->documento_pnia_id;  
                    }
                }

                $model->flg_es_staff = 'no';
                $model->save();
                $model->asignarDocumentos($array_documentos_id);
                return $this->redirect(['view', 'id' => $model->contrato_contrato_id]);
                
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_entidades' => $array_entidades,
                    'array_areas' => $array_areas,
                    'array_contratos' => $array_contratos,
                    'array_flags_es_staff' => $array_flags_es_staff,
                    'model_documento_pnia' => $model_documento_pnia,
                    'array_adquisicion' => $array_adquisicion,
                    'lista_presupuestos_ramas' => $lista_presupuestos_ramas,

                ]);
            }
        }
    }

    /**
     * Delete an existing ContratoContrato model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $lista_contratos_documentos = ContratoDocumento::find()->where(['contrato_id'=>$id])->all();
        //todo se borra del puente y de documentos antes de actualizar un documento nuevo subido o varios
        foreach($lista_contratos_documentos as $documento_actual){
            $documento = DocumentoPnia::find()->where(['documento_pnia_id' => $documento_actual->documento_pnia_id])->one();
            unlink(Yii::getAlias('@uploadedfilesdir') . $documento->nombre_documento);
            $documento_actual->delete();
            $documento->delete();
        }
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
     * Delete multiple existing ContratoContrato model.
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
     * Finds the ContratoContrato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContratoContrato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContratoContrato::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::$app->params['testoEspañol']['paginaNoEncontrada']);
        }
    }

    public function actionCreatePenalidad(){
        return Yii::$app->runAction('rrhh/contrato-penalidad/create');
    }
    
    public function actionCreateEntregable(){
        return Yii::$app->runAction('rrhh/contrato-entregable/create');
    }

}
