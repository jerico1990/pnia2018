<?php

namespace app\controllers\Viatico;

use Yii;
use app\models\Viatico\FlujoPaso;
use app\models\Viatico\FlujoPasoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\controllers\BehaviorController;
use app\models\Patrimonio\Metacodigo;
use app\models\Viatico\FlujoFlujo;
use app\models\rrhh\StaffArea;

/**
 * FlujoPasoController implements the CRUD actions for FlujoPaso model.
 */
class FlujoPasoController extends BehaviorController
{
    // /**
    //  * @inheritdoc
    //  */
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['post'],
    //                 'bulk-delete' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    /**
     * Lists all FlujoPaso models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new FlujoPasoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single FlujoPaso model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $objeto_flujo_paso = new FlujoPaso();
        $objeto_flujo_paso = $objeto_flujo_paso->findById($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Flujo paso: ".$objeto_flujo_paso->nombre_paso,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['Update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new FlujoPaso model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new FlujoPaso();

        $title = "Crear nuevo paso";

        $objeto_flujo_flujo = new FlujoFlujo();
        $array_flujo_flujo = $objeto_flujo_flujo->getComboBoxItemsProcesos();

        $objeto_staff_area = new StaffArea();
        $array_staff_area = $objeto_staff_area->getComboBoxItems();

        $array_metacodigo_estado_paso  = Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Estado_paso']);

        $array_proceso_presupuesto = $model->getComboBoxProcesosPresupuesto();

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
                        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                        'array_flujo_flujo' => $array_flujo_flujo,
                        'array_staff_area' => $array_staff_area,
                        'array_proceso_presupuesto' => $array_proceso_presupuesto
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-flujo-paso-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Paso del Flujo Creado</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                        'array_flujo_flujo' => $array_flujo_flujo,
                        'array_staff_area' => $array_staff_area,
                        'array_proceso_presupuesto' => $array_proceso_presupuesto
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
                return $this->redirect(['view', 'id' => $model->flujo_paso_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                    'array_flujo_flujo' => $array_flujo_flujo,
                    'array_staff_area' => $array_staff_area,
                    'array_proceso_presupuesto' => $array_proceso_presupuesto
                ]);
            }
        }
       
    }


    /*
    public function actionTest(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rpta=[];
        $model = FlujoPaso::find()->where(['nombre_paso'=>'CAMINO APROBADO 2'])->one();
        $paso_previo = FlujoPaso::find()->where(['nivel_siguiente' => $model->nivel])->one();
        $rpta['model'] = $model;
        $rpta['paso_previo'] = $paso_previo;
        return $rpta;
    }// */

    /**
     * Updates an existing FlujoPaso model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $paso_previo = FlujoPaso::find()->where(['nivel_siguiente' => $model->nivel])->one();
        if ($paso_previo != null){
            $model->paso_previo = $paso_previo->flujo_paso_id;
        }

        $objeto_flujo_flujo = new FlujoFlujo();
        $array_flujo_flujo = $objeto_flujo_flujo->getComboBoxItemsProcesos();

        $objeto_staff_area = new StaffArea();
        $array_staff_area = $objeto_staff_area->getComboBoxItems();

        $array_metacodigo_estado_paso  = Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Estado_paso']);
        $title = "Actualizar flujo paso: ".$model->nombre_paso;

        $array_proceso_presupuesto = $model->getComboBoxProcesosPresupuesto();
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('Update', [
                        'model' => $model,
                        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                        'array_flujo_flujo' => $array_flujo_flujo,
                        'array_staff_area' => $array_staff_area,
                        'array_proceso_presupuesto' => $array_proceso_presupuesto
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-flujo-paso-pjax',
                    'title'=> "Flujo paso: ".$model->nombre_paso,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                        'array_flujo_flujo' => $array_flujo_flujo,
                        'array_proceso_presupuesto' => $array_proceso_presupuesto
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['Update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('Update', [
                        'model' => $model,
                        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                        'array_flujo_flujo' => $array_flujo_flujo,
                        'array_staff_area' => $array_staff_area,
                        'array_proceso_presupuesto' => $array_proceso_presupuesto
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
                return $this->redirect(['view', 'id' => $model->flujo_paso_id]);
            } else {
                return $this->render('Update', [
                    'model' => $model,
                    'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
                    'array_flujo_flujo' => $array_flujo_flujo,
                    'array_staff_area' => $array_staff_area,
                    'array_proceso_presupuesto' => $array_proceso_presupuesto
                ]);
            }
        }
    }

    /**
     * Delete an existing FlujoPaso model.
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-flujo-paso-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing FlujoPaso model.
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
     * Finds the FlujoPaso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FlujoPaso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FlujoPaso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
