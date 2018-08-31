<?php

namespace app\controllers\Patrimonio;

use Yii;
use app\models\Patrimonio\PatrimonioInventario;
use app\models\Patrimonio\PatrimonioInventarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

use app\models\Patrimonio\PatrimonioItem;
use yii\helpers\ArrayHelper;
use app\models\Patrimonio\Metacodigo;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Ubicacion;
use app\controllers\BehaviorController;
use app\models\Patrimonio\DocumentoPnia;
use app\models\Viatico\ContratoDocumento;
use app\models\Patrimonio\DocumentoPniaSearch;


use yii\web\UploadedFile;
/**
 * PatrimonioInventarioController implements the CRUD actions for PatrimonioInventario model.
 */
class PatrimonioInventarioController extends BehaviorController
{
    /**
     * Lists all PatrimonioInventario models.
     * @return mixed
     */
    
    public function actionEnviarCodigoInterno(){
        $_SESSION['patrimonio_inventario_id'] = $_POST['patrimonio_inventario_id'];
        return true;
    }
    
    public function actionIndex()
    {    
        $searchModel = new PatrimonioInventarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchModelDocumentoPnia = new DocumentoPniaSearch();
        $dataProviderDocumentoPnia = $searchModelDocumentoPnia->searchPatrimonioInventario(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelDocumentoPnia' => $searchModelDocumentoPnia,
            'dataProviderDocumentoPnia' => $dataProviderDocumentoPnia,
        ]);
    }


    /**
     * Displays a single PatrimonioInventario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = $this->findModel($id);
        $modelItem = $model->getPatrimonioItem()->one();
        $date = date_create($model->fecha_inventario);
        if($modelItem == null){
            $title = "Inventario de ".date_format($date,"Y/m/d");
        }else{
            $title = "Inventario : ".$modelItem->descripcion." de ".date_format($date,"Y/m/d");
        }

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
     * Creates a new PatrimonioInventario model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PatrimonioInventario();    
        
        $model_documento_pnia = new DocumentoPnia();

        $array_metacodigo_condicion         = ArrayHelper::map(Metacodigo::getComboBoxList(Yii::$app->params['metacodigoFlags']['Condición']), 'metacodigo_id', 'descripcion');
        $array_metacodigo_estado         = ArrayHelper::map(Metacodigo::getComboBoxList(Yii::$app->params['metacodigoFlags']['Estado']), 'metacodigo_id', 'descripcion');
        $array_items        = ArrayHelper::map((new PatrimonioItem())->getTodosLosItems(), 'patrimonio_item_id', 'descripcion');

        $array_ubicaciones          = ArrayHelper::map((new Ubicacion())->getUbicaciones(), 'ubicacion_id', 'nombre');
        $array_usuario        = ArrayHelper::map((new Usuario())->getUser(), 'usuario_id', 'nombre');
        
        $array_documentos_id = [];
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Registrar Nuevo Inventario",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'metacodigo_condicion' => $array_metacodigo_condicion,
                        'metacodigo_estado' => $array_metacodigo_estado,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_usuario,
                        'model_documento_pnia' => $model_documento_pnia,
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
                    'title'=> "Create new PatrimonioInventario",
                    'content'=>'<span class="text-success">Inventario Creado</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];         
             
            }else{           
                return [
                    'title'=> "Create new PatrimonioInventario",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'metacodigo_condicion' => $array_metacodigo_condicion,
                        'metacodigo_estado' => $array_metacodigo_estado,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_usuario,
                        'model_documento_pnia' => $model_documento_pnia,
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
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new PatrimonioInventario",
                    'content'=>'<span class="text-success">Create PatrimonioInventario success</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];         
                
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'metacodigo_condicion' => $array_metacodigo_condicion,
                    'metacodigo_estado' => $array_metacodigo_estado,
                    'ubicaciones' => $array_ubicaciones,
                    'items' => $array_items,
                    'user' => $array_usuario,
                    'model_documento_pnia' => $model_documento_pnia,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing PatrimonioInventario model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
        $modelItem = $model->getPatrimonioItem()->one();
        $date = date_create($model->fecha_inventario);
        if($modelItem == null){
            $title = "Actualizar Inventario de ".date_format($date,"Y/m/d");
        }else{
            $title = "Actualizar Inventario : ".$modelItem->descripcion." de ".date_format($date,"Y/m/d");
        }


        $model_documento_pnia = new DocumentoPnia();
        $model_documento_actual_a_borrar = $model_documento_pnia->getDocumentoPorNombre($model->documento_pnia_id);
        
                //Pregunta si:  "NO" es post, es decir esta dibujando
        $array_metacodigo_condicion         = ArrayHelper::map(Metacodigo::getComboBoxList(Yii::$app->params['metacodigoFlags']['Condición']), 'metacodigo_id', 'descripcion');
        $array_metacodigo_estado         = ArrayHelper::map(Metacodigo::getComboBoxList(Yii::$app->params['metacodigoFlags']['Estado']), 'metacodigo_id', 'descripcion');
        $array_items        = ArrayHelper::map((new PatrimonioItem())->getTodosLosItems(), 'patrimonio_item_id', 'descripcion');

        $array_ubicaciones          = ArrayHelper::map((new Ubicacion())->getUbicaciones(), 'ubicacion_id', 'nombre');
        $array_usuario        = ArrayHelper::map((new Usuario())->getUser(), 'usuario_id', 'nombre');
        
        $lista_contratos_documentos = ContratoDocumento::find()->where(['patrimonio_inventario_id'=>$id])->all();
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
                        'metacodigo_condicion' => $array_metacodigo_condicion,
                        'metacodigo_estado' => $array_metacodigo_estado,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_usuario,
                        'model_documento_pnia' => $model_documento_pnia,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ]; 
            } else if ($model->load($request->post()) && $model_documento_pnia->load($request->post()) && $model->validate()){
                
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
                        'metacodigo_condicion' => $array_metacodigo_condicion,
                        'metacodigo_estado' => $array_metacodigo_estado,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_usuario,
                        'model_documento_pnia' => $model_documento_pnia,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
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
                return $this->redirect(['view', 'id' => $model->patrimonio_inventario_id]);
            }
        }
        
    }

    /**
     * Delete an existing PatrimonioInventario model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $lista_contratos_documentos = ContratoDocumento::find()->where(['patrimonio_inventario_id'=>$id])->all();
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
     * Delete multiple existing PatrimonioInventario model.
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
     * Finds the PatrimonioInventario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrimonioInventario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioInventario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
