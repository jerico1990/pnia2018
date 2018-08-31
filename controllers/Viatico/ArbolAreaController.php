<?php

namespace app\controllers\Viatico;

use Yii;
use app\models\Viatico\ArbolArea;
use app\models\Viatico\ArbolAreaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

use app\models\rrhh\StaffArea;
use app\models\Presupuesto\PresupuestoCabecera;
use app\controllers\BehaviorController;

/**
 * ArbolAreaController implements the CRUD actions for ArbolArea model.
 */
class ArbolAreaController extends BehaviorController
{

    /**
     * Lists all ArbolArea models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new ArbolAreaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single ArbolArea model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "ArbolArea #".$id,
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
     * Creates a new ArbolArea model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new ArbolArea();  
        $model_area = new StaffArea();
        $array_lista_areas = $model_area->getArrayAreas();
        
        $array_presupuesto_raiz = PresupuestoCabecera::getComboBoxItems();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Crear nueva Asignación Presupuestal",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_lista_areas' => $array_lista_areas,
                        'array_presupuesto_raiz' => $array_presupuesto_raiz,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Crear nueva Asignación Presupuestal",
                    'content'=>'<span class="text-success">Asignación Presupuestal Creada</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Crear nueva Asignación Presupuestal",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_lista_areas' => $array_lista_areas,
                        'array_presupuesto_raiz' => $array_presupuesto_raiz,
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
                return $this->redirect(['view', 'id' => $model->arbol_area_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_lista_areas' => $array_lista_areas,
                    'array_presupuesto_raiz' => $array_presupuesto_raiz,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing ArbolArea model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);      
        
        $model_area = new StaffArea();
        $array_lista_areas = $model_area->getArrayAreas();
        
        $array_presupuesto_raiz = PresupuestoCabecera::getComboBoxItems();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Actualizar Asignación Presupuestal #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_lista_areas' => $array_lista_areas,
                        'array_presupuesto_raiz' => $array_presupuesto_raiz,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "ArbolArea #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_lista_areas' => $array_lista_areas,
                        'array_presupuesto_raiz' => $array_presupuesto_raiz,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['Actualizar','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update ArbolArea #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_lista_areas' => $array_lista_areas,
                        'array_presupuesto_raiz' => $array_presupuesto_raiz,
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
                return $this->redirect(['view', 'id' => $model->arbol_area_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_lista_areas' => $array_lista_areas,
                    'array_presupuesto_raiz' => $array_presupuesto_raiz,
                ]);
            }
        }
    }

    /**
     * Delete an existing ArbolArea model.
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
     * Delete multiple existing ArbolArea model.
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
     * Finds the ArbolArea model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArbolArea the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArbolArea::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
