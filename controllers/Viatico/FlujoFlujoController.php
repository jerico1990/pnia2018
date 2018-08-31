<?php

namespace app\controllers\Viatico;

use Yii;
use app\models\Viatico\FlujoFlujo;
use app\models\Viatico\FlujoFlujoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\controllers\BehaviorController;
use app\models\Patrimonio\Metacodigo;
use app\models\Viatico\FlujoPaso;
use app\models\Viatico\FlujoPasoSearch;

/**
 * FlujoFlujoController implements the CRUD actions for FlujoFlujo model.
 */
class FlujoFlujoController extends BehaviorController
{
    /**
     * Lists all FlujoFlujo models.
     * @return mixed
     */
    
     public function actionEnviarCodigoRequerimiento(){
        $_SESSION['flujo_flujo_id'] = $_POST['flujo_flujo_id'];
        return true;
    }
    
    public function actionIndex()
    {    
        $searchModel = new FlujoFlujoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchModelFlujoPaso = new FlujoPasoSearch();
        $dataProviderFlujoPaso = $searchModelFlujoPaso->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelFlujoPaso' => $searchModelFlujoPaso,
            'dataProviderFlujoPaso' => $dataProviderFlujoPaso
        ]);
    }


    /**
     * Displays a single FlujoFlujo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $objeto_flujo_flujo = new FlujoFlujo();
        $objeto_flujo_flujo = $objeto_flujo_flujo->findById($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Flujo: ".$objeto_flujo_flujo->nombre_flujo,
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
     * Creates a new FlujoFlujo model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new FlujoFlujo();  
        $title = "Crear nuevo flujo";
        if(! $model->load($request->post())) {
            $array_metacodigo_tipo_flujo  = Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Tipo_flujo']);
        }
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
                        'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Create FlujoFlujo success</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo
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
                return $this->redirect(['view', 'id' => $model->flujo_flujo_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo
                ]);
            }
        }
       
    }

    /**
     * Updates an existing FlujoFlujo model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id); 
        $title = "Actualizar flujo: ".$model->nombre_flujo;      
        $array_metacodigo_tipo_flujo  = Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Tipo_flujo']);

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
                        'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Flujo: ".$model->nombre_flujo,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo
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
                return $this->redirect(['view', 'id' => $model->flujo_flujo_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo
                ]);
            }
        }
    }

    /**
     * Delete an existing FlujoFlujo model.
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
     * Delete multiple existing FlujoFlujo model.
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
     * Finds the FlujoFlujo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FlujoFlujo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FlujoFlujo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCreatePaso(){
        return Yii::$app->runAction('Viatico/flujo-paso/create');
    }
//    public function actionUpdatePaso(){
//        return Yii::$app->runAction('Viatico/flujo-paso/update');
//    }
}
