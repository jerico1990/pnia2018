<?php

namespace app\controllers\rrhh;

use Yii;
use app\models\rrhh\ConformidadEntregable;
use app\models\rrhh\ConformidadEntregableSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\controllers\BehaviorController;
use app\models\Patrimonio\Metacodigo;
use app\models\Patrimonio\DocumentoPnia;
use yii\web\UploadedFile;
/**
 * ConformidadEntregableController implements the CRUD actions for ConformidadEntregable model.
 */
class ConformidadEntregableController extends BehaviorController
{

    /**
     * Lists all ConformidadEntregable models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new ConformidadEntregableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single ConformidadEntregable model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Conformidad de entregable ",
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
     * Creates a new ConformidadEntregable model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new ConformidadEntregable();  
        $array_tipo_conformidad = ConformidadEntregable::getComboBoxListConformidad();
        $model_documento_pnia = new DocumentoPnia();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Dar conformidad",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_tipo_conformidad' => $array_tipo_conformidad,
                        'model_documento_pnia' => $model_documento_pnia,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Dar conformidad",
                    'content'=>'<span class="text-success">Conformidad Creada</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Dar conformidad",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_tipo_conformidad' => $array_tipo_conformidad,
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
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->conformidad_entregable_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_tipo_conformidad' => $array_tipo_conformidad,
                    'model_documento_pnia' => $model_documento_pnia,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing ConformidadEntregable model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
        $array_tipo_conformidad = ConformidadEntregable::getComboBoxListConformidad();
        
        $model_documento_pnia = new DocumentoPnia();
        $model_documento_actual_a_borrar = $model_documento_pnia->getDocumentoPorNombre($model->documento_pnia_id);
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Dar conformidad",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_tipo_conformidad' => $array_tipo_conformidad,
                        'model_documento_pnia' => $model_documento_pnia,
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

                    $model->documento_pnia_id = $model_documento_pnia->documento_pnia_id;
                }

                if($model->load($request->post()) && $model->save()){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Dar conformidad",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                            'array_tipo_conformidad' => $array_tipo_conformidad,
                            'model_documento_pnia' => $model_documento_pnia,
                        ]),
                        'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];  
                }  
                else
                    echo ("Asegurese de subir un documento");
            }else{
                 return [
                    'title'=> "Dar conformidad",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_tipo_conformidad' => $array_tipo_conformidad,
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
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->conformidad_entregable_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_tipo_conformidad' => $array_tipo_conformidad,
                    'model_documento_pnia' => $model_documento_pnia,
                ]);
            }
        }
    }

    /**
     * Delete an existing ConformidadEntregable model.
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
     * Delete multiple existing ConformidadEntregable model.
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
     * Finds the ConformidadEntregable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConformidadEntregable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConformidadEntregable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
