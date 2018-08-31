<?php

namespace app\controllers\Viatico;

use Yii;
use app\models\Viatico\FondoDistribucionMonto;
use app\models\Viatico\FondoDistribucionMontoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\controllers\BehaviorController;
use app\models\Patrimonio\Metacodigo;
use app\models\Utilitario\UtilitarioUbigeo;

/**
 * FondoDistribucionMontoController implements the CRUD actions for FondoDistribucionMonto model.
 */
class FondoDistribucionMontoController extends BehaviorController
{
    
    /**
     * Lists all FondoDistribucionMonto models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new FondoDistribucionMontoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single FondoDistribucionMonto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = $this->findModel($id);
        $title = "Fondo de Distribución por ".$model->monto_determinado;
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
     * Creates a new FondoDistribucionMonto model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new FondoDistribucionMonto();  
        $title = "Registrar Nuevo Monto de Distribución";
        
        $array_metacodigo_escala   = Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Escala_Distribucion']);

        $array_metacodigo_concepto = Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Concepto_Distribucion']);

        $array_niveles = [1 => 'Nivel 1', 2 => 'Nivel 2', 3 => 'Nivel 3'];

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
                        'array_metacodigo_escala'   => $array_metacodigo_escala,
                        'array_metacodigo_concepto' => $array_metacodigo_concepto,
                        'array_niveles' => $array_niveles,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success"> Registro Exitoso </span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_metacodigo_escala'   => $array_metacodigo_escala,
                        'array_metacodigo_concepto' => $array_metacodigo_concepto,
                        'array_niveles' => $array_niveles,
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
                return $this->redirect(['view', 'id' => $model->fondo_distribucion_monto_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_metacodigo_escala'   => $array_metacodigo_escala,
                    'array_metacodigo_concepto' => $array_metacodigo_concepto,
                    'array_niveles' => $array_niveles,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing FondoDistribucionMonto model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = "Actualizar Fondo de Distribución por ".$model->monto_determinado. ' Nuevos Soles';  

        $array_metacodigo_escala   = Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Escala_Distribucion']);

        $array_metacodigo_concepto = Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Concepto_Distribucion']);

        $array_niveles = [1 => 'Nivel 1', 2 => 'Nivel 2', 3 => 'Nivel 3'];

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
                        'array_metacodigo_escala'   => $array_metacodigo_escala,
                        'array_metacodigo_concepto' => $array_metacodigo_concepto,
                        'array_niveles' => $array_niveles,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_metacodigo_escala'   => $array_metacodigo_escala,
                        'array_metacodigo_concepto' => $array_metacodigo_concepto,
                        'array_niveles' => $array_niveles,
                    ]),
                    'footer'=> Html::button('Guardar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_metacodigo_escala'   => $array_metacodigo_escala,
                        'array_metacodigo_concepto' => $array_metacodigo_concepto,
                        'array_niveles' => $array_niveles,
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
                return $this->redirect(['view', 'id' => $model->fondo_distribucion_monto_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_metacodigo_escala'   => $array_metacodigo_escala,
                    'array_metacodigo_concepto' => $array_metacodigo_concepto,
                    'array_niveles' => $array_niveles,
                ]);
            }
        }
    }

    /**
     * Delete an existing FondoDistribucionMonto model.
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
     * Delete multiple existing FondoDistribucionMonto model.
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
     * Finds the FondoDistribucionMonto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FondoDistribucionMonto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FondoDistribucionMonto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
