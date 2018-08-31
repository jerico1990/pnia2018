<?php

namespace app\controllers\rrhh;

use Yii;
use app\models\rrhh\StaffArea;
use app\models\rrhh\StaffAreaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\rrhh\StaffPersona;
use app\controllers\BehaviorController;


/**
 * StaffAreaController implements the CRUD actions for StaffArea model.
 */
class StaffAreaController extends BehaviorController
{

    /**
     * Lists all StaffArea models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new StaffAreaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single StaffArea model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = "Área : ".$model->codigo."-".$model->descripcion;
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
     * Creates a new StaffArea model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new StaffArea();  
        $model_persona = new StaffPersona();
        $title = "Registrar Nueva Área";
        $array_lista_areas = $model->getArrayAreas();
        $array_personas = $model_persona->getArrayPersonas();

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
                        'array_lista_areas' => $array_lista_areas,
                        'array_personas' => $array_personas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){

                $persona = StaffPersona::findOne(['staff_persona_id' => $model->responsable]);
                $persona->staff_area_id = $model->staff_area_id;
                $persona->save();

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Área Creada</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Crear nueva Área",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_lista_areas' => $array_lista_areas,
                        'array_personas' => $array_personas,
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
                return $this->redirect(['view', 'id' => $model->staff_area_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_lista_areas' => $array_lista_areas,
                    'array_personas' => $array_personas,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing StaffArea model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        
        $model = $this->findModel($id);
        $title = "Actualizar Área : ".$model->codigo."-".$model->descripcion;

        $model_persona = new StaffPersona();
        
        $array_lista_areas = $model->getArrayAreas();
        $array_personas = $model_persona->getArrayPersonas();
        
        if($model->responsable)
        {
            $model->autocomplete_staff_persona = StaffPersona::getDniNombreById($model->responsable);
        }
        else
            $model->autocomplete_staff_persona = null;
            
        

        $jefe_actl_id = $model->responsable;

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
                        'array_lista_areas' => $array_lista_areas,
                        'array_personas' => $array_personas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                $exJefe  = StaffPersona::findOne(['staff_persona_id' => $jefe_actl_id]);
                $exJefe->staff_area_id = null;
                $exJefe->save();
                $persona = StaffPersona::findOne(['staff_persona_id' => $model->responsable]);
                $persona->staff_area_id = $model->staff_area_id;
                $persona->save();

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_lista_areas' => $array_lista_areas,
                        'array_personas' => $array_personas,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_lista_areas' => $array_lista_areas,
                        'array_personas' => $array_personas,
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
                return $this->redirect(['view', 'id' => $model->staff_area_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_lista_areas' => $array_lista_areas,
                    'array_personas' => $array_personas,
                ]);
            }
        }
    }

    /**
     * Delete an existing StaffArea model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        //$this->findModel($id)->delete();
        
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
           throw new \yii\web\HttpException(500,"No puede borrar esta área. Primero debe desasociarla de su persona asociada y revisar que no sea parte de un paso de flujo.", 405);
        }catch (\Exception $e) {
          throw new \yii\web\HttpException(500,"No puede borrar esta área. Primero debe desasociarla de su persona asociada y revisar que no sea parte de un paso de flujo.", 405);
        }

    }

     /**
     * Delete multiple existing StaffArea model.
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
     * Finds the StaffArea model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaffArea the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaffArea::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::$app->params['testoEspañol']['paginaNoEncontrada']);
        }
    }
}
