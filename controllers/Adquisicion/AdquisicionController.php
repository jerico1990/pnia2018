<?php

namespace app\controllers\Adquisicion;

use Yii;
use app\models\Adquisicion\Adquisicion;
use app\models\Adquisicion\AdquisicionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Viatico\FlujoRequerimiento;
use app\models\rrhh\ContratoContrato;
use \yii\helpers\ArrayHelper;
use app\controllers\BehaviorController;
use app\models\Patrimonio\Metacodigo;
/**
 * AdquisicionController implements the CRUD actions for Adquisicion model.
 */
class AdquisicionController extends BehaviorController
{

    public function actionMontoEstimado()
    {    
        return Adquisicion::montoEstimado($_POST['flujo_requerimiento_id']);
    }

    /**
     * Lists all Adquisicion models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new AdquisicionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Adquisicion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Adquisicion #".$id,
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
     * Creates a new Adquisicion model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Adquisicion();  

        $array_tipo_revision = Metacodigo::getComboBoxItems('Tipo_Revision');
        $array_categoria_adquisicion = Metacodigo::getComboBoxItems('Categoria_Adquisicion');
        $array_enfoque_mercado = Metacodigo::getComboBoxItems('Enfoque_Mercado');
        $array_estado_actividad = Metacodigo::getComboBoxItems('Estado_Actividad');

        $objeto_flujo_requerimiento = new FlujoRequerimiento();
        $array_flujo_requerimiento = $objeto_flujo_requerimiento->getComboBoxParaAdquisiciones();

        $array_ro_rooc = $model->getComboBoxRoRooc();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Crear nueva adquisición",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_flujo_requerimiento' => $array_flujo_requerimiento,
                        'array_tipo_revision' => $array_tipo_revision,
                        'array_categoria_adquisicion' => $array_categoria_adquisicion,
                        'array_enfoque_mercado' => $array_enfoque_mercado,
                        'array_estado_actividad' => $array_estado_actividad,
                        'array_ro_rooc' => $array_ro_rooc
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Crear nueva adquisición",
                    'content'=>'<span class="text-success">Adquisición Creada</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Crear nueva adquisición",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_flujo_requerimiento' => $array_flujo_requerimiento,
                        'array_tipo_revision' => $array_tipo_revision,
                        'array_categoria_adquisicion' => $array_categoria_adquisicion,
                        'array_enfoque_mercado' => $array_enfoque_mercado,
                        'array_estado_actividad' => $array_estado_actividad,
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
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->adquisicion_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_flujo_requerimiento' => $array_flujo_requerimiento,
                    'array_tipo_revision' => $array_tipo_revision,
                    'array_categoria_adquisicion' => $array_categoria_adquisicion,
                    'array_enfoque_mercado' => $array_enfoque_mercado,
                    'array_estado_actividad' => $array_estado_actividad,
                    'array_ro_rooc' => $array_ro_rooc
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Adquisicion model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);   

        $array_tipo_revision = Metacodigo::getComboBoxItems('Tipo_Revision');
        $array_categoria_adquisicion = Metacodigo::getComboBoxItems('Categoria_Adquisicion');
        $array_enfoque_mercado = Metacodigo::getComboBoxItems('Enfoque_Mercado');
        $array_estado_actividad = Metacodigo::getComboBoxItems('Estado_Actividad');    

        $objeto_flujo_requerimiento = new FlujoRequerimiento();
        $array_flujo_requerimiento = $objeto_flujo_requerimiento->find()->all();
        $array_flujo_requerimiento = ArrayHelper::map($array_flujo_requerimiento, 'flujo_requerimiento_id', 'descripcion');

        $array_ro_rooc = $model->getComboBoxRoRooc();
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Actualizar adquisición ".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_flujo_requerimiento' => $array_flujo_requerimiento,
                        'array_tipo_revision' => $array_tipo_revision,
                        'array_categoria_adquisicion' => $array_categoria_adquisicion,
                        'array_enfoque_mercado' => $array_enfoque_mercado,
                        'array_estado_actividad' => $array_estado_actividad,
                        'array_ro_rooc' => $array_ro_rooc
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Adquisición ".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_flujo_requerimiento' => $array_flujo_requerimiento,
                        'array_tipo_revision' => $array_tipo_revision,
                        'array_categoria_adquisicion' => $array_categoria_adquisicion,
                        'array_enfoque_mercado' => $array_enfoque_mercado,
                        'array_estado_actividad' => $array_estado_actividad,
                        'array_ro_rooc' => $array_ro_rooc
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Actualizar adquisición ".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_flujo_requerimiento' => $array_flujo_requerimiento,
                        'array_tipo_revision' => $array_tipo_revision,
                        'array_categoria_adquisicion' => $array_categoria_adquisicion,
                        'array_enfoque_mercado' => $array_enfoque_mercado,
                        'array_estado_actividad' => $array_estado_actividad,
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
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->adquisicion_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_flujo_requerimiento' => $array_flujo_requerimiento,
                    'array_tipo_revision' => $array_tipo_revision,
                    'array_categoria_adquisicion' => $array_categoria_adquisicion,
                    'array_enfoque_mercado' => $array_enfoque_mercado,
                    'array_estado_actividad' => $array_estado_actividad,
                    'array_ro_rooc' => $array_ro_rooc
                ]);
            }
        }
    }

    /**
     * Delete an existing Adquisicion model.
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
     * Delete multiple existing Adquisicion model.
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
     * Finds the Adquisicion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adquisicion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adquisicion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
