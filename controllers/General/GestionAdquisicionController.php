<?php

namespace app\controllers\General;

use app\models\Presupuesto\PresupuestoCabecera;
use Yii;
use app\models\Viatico\FlujoRequerimiento;
use app\models\Viatico\FlujoRequerimientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\controllers\BehaviorController;
use app\models\rrhh\StaffPersona;
use app\models\Patrimonio\Metacodigo;
use app\models\Viatico\FlujoFlujo;
use app\models\Viatico\FlujoPaso;
use app\models\Viatico\ArbolPnia;
use app\models\Patrimonio\DocumentoPnia;
use app\models\Patrimonio\DocumentoPniaSearch;
use app\models\Viatico\RequerimientoDocumento;
use yii\web\UploadedFile;

use app\models\rrhh\StaffArea;
use app\models\Viatico\ArbolArea;
use app\models\Presupuesto\Periodo;

/**
 * FlujoRequerimientoController implements the CRUD actions for FlujoRequerimiento model.
 */
class GestionAdquisicionController extends BehaviorController
{
    // public function actionCreateDocumentoPnia(){
    //     return Yii::$app->runAction('Patrimonio/documento-pnia/create');
    // }

    public function actionEnviarCodigoRequerimiento(){
        $_SESSION['flujo_requerimiento_id'] = $_POST['flujo_requerimiento_id'];
        $_SESSION['codigo_requerimiento'] = $_POST['codigo_requerimiento'];
        return true;
    }

    public function actionAvanzarPaso(){
        $objeto_flujo_requerimiento = new FlujoRequerimiento();
        $objeto_flujo_requerimiento = $objeto_flujo_requerimiento->findById($_POST['flujo_requerimiento_id']);
        
        
        return $objeto_flujo_requerimiento->avanzarPaso($_POST['siguiente_paso'],$_POST['observacion']);
    }

    public function actionLlenarOpciones(){
        $objeto_flujo_requerimiento = new FlujoRequerimiento();
        $objeto_flujo_requerimiento = $objeto_flujo_requerimiento->findById($_POST['flujo_requerimiento_id']);
        $array_opciones = $objeto_flujo_requerimiento->getOpcionesSiguienteNivel();
        return json_encode($array_opciones);
    }

    public function actionCambiarComboFlujoPaso(){
        $flujo_flujo_id = $_POST['flujo_flujo_id']; 
        $objeto_flujo_paso = new FlujoPaso();
        $array_flujo_paso = $objeto_flujo_paso->getComboBoxFiltrado($flujo_flujo_id);
        return json_encode($array_flujo_paso);
         
    }

    /**
     * Lists all FlujoRequerimiento models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new FlujoRequerimientoSearch();
        $dataProvider = $searchModel->searchGestionAdq(Yii::$app->request->queryParams);

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
     * Displays a single FlujoRequerimiento model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $objeto_flujo_requerimiento = new FlujoRequerimiento();
        $objeto_flujo_requerimiento = $objeto_flujo_requerimiento->findById($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Flujo requerimiento: ".$objeto_flujo_requerimiento->descripcion,
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
     * Creates a new FlujoRequerimiento model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new FlujoRequerimiento();  
        $model_persona = new StaffPersona();
        $array_personas = $model_persona->getArrayPersonas();
        
        $id_persona = Yii::$app->user->identity->persona_id;
        $model_staff_area = StaffArea::find()->where(['responsable' => $id_persona])->one();
        $lista_presupuestos_ramas = ArbolArea::getComboBoxItemsArea($model_staff_area->staff_area_id);

        $title = "Gestionar nueva adquisición";
        $model_documento_pnia = new DocumentoPnia();

        $array_flujo_flujo = FlujoFlujo::getComboBoxItemsAdquisicion();

        $objeto_flujo_paso = new FlujoPaso();
        $array_flujo_paso = [];

        $array_metacodigo_estado_paso  = Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Estado_paso']);
        
        $array_documentos_id = [];

        $array_periodo = Periodo::getComboBoxItems();

        $array_ro_rooc = $model->getComboBoxRoRooc();

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
                        'array_personas' => $array_personas,
                        'array_flujo_flujo' => $array_flujo_flujo,
                        'array_flujo_paso' => $array_flujo_paso,
                        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'array_ro_rooc' => $array_ro_rooc

                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if ($model_documento_pnia->load(Yii::$app->request->post())) {
                
                //$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
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

                if($model->load($request->post()) && $model->save()){
                    //return $array_documentos_id;
                    // return $model->beforeSave(); // && $model->save()
                    $model->asignarDocumentos($array_documentos_id);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> $title,
                        'content'=>'<span class="text-success">Adquisición gestionada</span>',
                        'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
            
                    ]; 
                }
                else
                    echo ("Verifique los campos ingresados, el monto requerido debe ser menor o igual a lo disponible");        
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_personas' => $array_personas,
                        'array_flujo_flujo' => $array_flujo_flujo,
                        'array_flujo_paso' => $array_flujo_paso,
                        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'array_ro_rooc' => $array_ro_rooc


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
                
                $documento = UploadedFile::getInstances($model_documento_pnia, 'ruta_documento');
                
                if (isset($documento[0]->extension))
                {
                    foreach ($documento as $file) {
                        $model_documento_pnia = new DocumentoPnia();
                        $file->saveAs(Yii::getAlias('@uploadedfilesdir') . $file->baseName . '.' . $file->extension); 
                        $model_documento_pnia->ruta_documento = null;
                        $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->nombre_documento = $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->documento_mimetype = $file->extension;
                        $model_documento_pnia->save();
                        array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                        //$model->documento_pnia_id = $model_documento_pnia->documento_pnia_id;  
                    }
                }
                
                if ($model->load($request->post()) && $model->save()) {
                    $model->asignarDocumentos($array_documentos_id);
                    return $this->redirect(['view', 'id' => $model->patrimonio_item_id]);
                }
                else
                    echo ("Algo no salió bien");     
    
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_personas' => $array_personas,
                    'array_flujo_flujo' => $array_flujo_flujo,
                    'array_flujo_paso' => $array_flujo_paso,
                    'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                    'model_documento_pnia' => $model_documento_pnia,
                    'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                    'array_periodo' => $array_periodo,
                    'array_ro_rooc' => $array_ro_rooc

                ]);
            }
        }
       
    }

    /**
     * Updates an existing FlujoRequerimiento model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $model_documento_pnia = new DocumentoPnia();
        $model_puente_requerimiento_documento = new RequerimientoDocumento();
        $lista_requerimiento_documentos = RequerimientoDocumento::find()->where(['flujo_requerimiento_id'=>$id])->all();
        $array_documentos_id = [];

        $model_persona = new StaffPersona();
        $array_personas = $model_persona->getArrayPersonas();

        $objeto_flujo_flujo = new FlujoFlujo();
        $array_flujo_flujo = $objeto_flujo_flujo->getComboBoxItems();

        $objeto_flujo_paso = new FlujoPaso();
        $array_flujo_paso = $objeto_flujo_paso->getComboBoxItems();

        $array_metacodigo_estado_paso  = Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Estado_paso']);
        
        $id_persona = Yii::$app->user->identity->persona_id;
        $model_staff_area = StaffArea::find()->where(['responsable' => $id_persona])->one();
        $lista_presupuestos_ramas = ArbolArea::getComboBoxItemsArea($model_staff_area->staff_area_id);

        $array_periodo = Periodo::getComboBoxItems();
        
        $array_ro_rooc = $model->getComboBoxRoRooc();
        
        $title = "Procesar adquisición: ".$model->descripcion;
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
                        'array_personas' => $array_personas,
                        'array_flujo_flujo' => $array_flujo_flujo,
                        'array_flujo_paso' => $array_flujo_paso,
                        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'array_ro_rooc' => $array_ro_rooc

                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if ($model_documento_pnia->load(Yii::$app->request->post())) {
                
                //todo se borra del puente y de documentos antes de actualizar un documento nuevo subido o varios
                foreach($lista_requerimiento_documentos as $documento_actual){
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
               
                if($model->load($request->post()) && $model->save()){
                    $model->asignarDocumentos($array_documentos_id);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Flujo requerimiento: ".$model->descripcion,
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                            'array_personas' => $array_personas,
                            'array_flujo_flujo' => $array_flujo_flujo,
                            'array_flujo_paso' => $array_flujo_paso,
                            'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                            'model_documento_pnia' => $model_documento_pnia,
                            'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                            'array_periodo' => $array_periodo,
                            'array_ro_rooc' => $array_ro_rooc

                        ]),
                        'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];
                }
                else
                    echo ("Algo no salió bien");     
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_personas' => $array_personas,
                        'array_flujo_flujo' => $array_flujo_flujo,
                        'array_flujo_paso' => $array_flujo_paso,
                        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                        'model_documento_pnia' => $model_documento_pnia,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo,
                        'array_ro_rooc' => $array_ro_rooc

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
                
                foreach($lista_requerimiento_documentos as $documento_actual){
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
                
                if ($model->load($request->post()) && $model->save()) {
                    $model->asignarDocumentos($array_documentos_id);
                    return $this->render('update', [
                        'model' => $model,
                        'array_personas' => $array_personas,
                        'array_flujo_flujo' => $array_flujo_flujo,
                        'array_flujo_paso' => $array_flujo_paso,
                        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
                        'array_periodo' => $array_periodo

                    ]);
                }
                else
                    echo ("Algo no salió bien");  
            }
        }
    }

    /**
     * Delete an existing FlujoRequerimiento model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $objeto_metacodigo = new Metacodigo();
        $objeto_metacodigo = $objeto_metacodigo->getMetacodigoId("Estado_paso","En Digitación");
        if($model->estado_paso == $objeto_metacodigo)
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
     * Delete multiple existing FlujoRequerimiento model.
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
     * Finds the FlujoRequerimiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FlujoRequerimiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FlujoRequerimiento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionObtenerPresupuestosDisponibles(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($_POST['periodo_id'])){
            $periodo_id = $_POST['periodo_id'];
        }else{
            return false;
        }
        if (isset($_POST['presupuesto_cabecera_id'])){
            $presupuesto_cabecera_id = $_POST['presupuesto_cabecera_id'];
        }else{
            return false;
        }
        $cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($presupuesto_cabecera_id);
        $disponible = $cabecera->obtenerPresupuestoDisponible($periodo_id);
        return "Disponible:  ".$disponible['ro']." Ro / ".$disponible['rooc']." Rooc";
    }
}
