<?php

namespace app\controllers\Patrimonio;

use Yii;
use app\models\Patrimonio\PatrimonioItem;
use app\models\Patrimonio\PatrimonioItemSearch;
use app\models\Patrimonio\Metacodigo;
use app\models\Patrimonio\MetacodigoSearch;
use app\models\Patrimonio\PatrimonioClase;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use Datetime;

use app\models\Viatico\ContratoDocumento;
use yii\web\UploadedFile;
use app\models\Patrimonio\DocumentoPnia;
use app\controllers\BehaviorController;
use app\models\Patrimonio\DocumentoPniaSearch;

/**
 * PatrimonioItemController implements the CRUD actions for PatrimonioItem model.
 */
class PatrimonioItemController extends BehaviorController
{
    public function actionValorizar(){
        $objeto_patrimonio_item = new PatrimonioItem();  
        $objeto_patrimonio_item = $objeto_patrimonio_item->findById($_POST['patrimonio_item_id']);
        return $objeto_patrimonio_item->valorizar();
    }
   
    public function actionEnviarCodigoInterno(){
        $_SESSION['patrimonio_item_id'] = $_POST['patrimonio_item_id'];
        return true;
    }

    /**
     * Lists all PatrimonioItem models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new PatrimonioItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchModelDocumentoPnia = new DocumentoPniaSearch();
        $dataProviderDocumentoPnia = $searchModelDocumentoPnia->searchPatrimonioItem(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelDocumentoPnia' => $searchModelDocumentoPnia,
            'dataProviderDocumentoPnia' => $dataProviderDocumentoPnia,
        ]);
    }


    /**
     * Displays a single PatrimonioItem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = "Item - ".$model->descripcion;
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
     * Creates a new PatrimonioItem model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PatrimonioItem();  
        $title = "Registrar Nuevo Item";
        $model_documento_pnia = new DocumentoPnia();
        $patrimonios_clases = new PatrimonioClase();
        $patrimonios_clases = $patrimonios_clases->getPatrimoniosClases(); 

        $array_metacodigo_condicion  = Metacodigo::getComboBoxList(Yii::$app->params['metacodigoFlags']['Condición']);
        
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
                        'array_metacodigo_condicion' => $array_metacodigo_condicion,
                        'model_documento_pnia' => $model_documento_pnia,
                        'patrimonios_clases' => $patrimonios_clases,
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
                $model->save();
                $model->asignarDocumentos($array_documentos_id);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Item Creado</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];      
                
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_metacodigo_condicion' => $array_metacodigo_condicion,
                        'model_documento_pnia' => $model_documento_pnia,
                        'patrimonios_clases' => $patrimonios_clases,
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
                $model->save();
                $model->asignarDocumentos($array_documentos_id);
                return $this->redirect(['view', 'id' => $model->patrimonio_item_id]);  
    
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_metacodigo_condicion' => $array_metacodigo_condicion,
                    'model_documento_pnia' => $model_documento_pnia,
                    'patrimonios_clases' => $patrimonios_clases,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing PatrimonioItem model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        
        $model = $this->findModel($id);
        $title = "Actualizar datos de ".$model->descripcion;

        $model_documento_pnia = new DocumentoPnia();
        $patrimonios_clases = new PatrimonioClase();
        $patrimonios_clases = $patrimonios_clases->getPatrimoniosClases(); 
        $model_documento_actual_a_borrar = $model_documento_pnia->getDocumentoPorNombre($model->documento_pnia_id);
        
        if($model->load($request->post())) {
            if (!Yii::$app->user->isGuest) {
                $model->actualizado_por = Yii::$app->user->identity->usuario_id;
            }
            $model->actualizado_en = date("Y-m-d");
        } 
        
        $array_metacodigo_condicion  = Metacodigo::getComboBoxList('Condición');
        
        $lista_contratos_documentos = ContratoDocumento::find()->where(['patrimonio_item_id'=>$id])->all();
        $array_documentos_id = [];


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
                        'array_metacodigo_condicion' => $array_metacodigo_condicion,
                        'model_documento_pnia' => $model_documento_pnia,
                        'patrimonios_clases' => $patrimonios_clases,
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
                $model->save();
                $model->asignarDocumentos($array_documentos_id);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_metacodigo_condicion' => $array_metacodigo_condicion,
                        'model_documento_pnia' => $model_documento_pnia,
                        'patrimonios_clases' => $patrimonios_clases,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_metacodigo_condicion' => $array_metacodigo_condicion,
                        'model_documento_pnia' => $model_documento_pnia,
                        'patrimonios_clases' => $patrimonios_clases,
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
                $model->save();
                $model->asignarDocumentos($array_documentos_id);
                return $this->render('update', [
                    'model' => $model,
                    'array_metacodigo_condicion' => $array_metacodigo_condicion,
                    'model_documento_pnia' => $model_documento_pnia,
                    'patrimonios_clases' => $patrimonios_clases,
                ]);
                
            }
            
        }
    }

    /**
     * Delete an existing PatrimonioItem model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        
        $lista_contratos_documentos = ContratoDocumento::find()->where(['patrimonio_item_id'=>$id])->all();
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
     * Delete multiple existing PatrimonioItem model.
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
     * Finds the PatrimonioItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrimonioItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
