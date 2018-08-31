<?php

namespace app\controllers\Presupuesto;

use app\models\Presupuesto\Partida;
use Yii;
use app\models\Presupuesto\Presupuesto;
use app\models\Presupuesto\PresupuestoCabecera;
use app\models\Presupuesto\PresupuestoCabeceraSearch;
use app\models\Presupuesto\PresupuestoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * PresupuestoCabeceraController implements the CRUD actions for PresupuestoCabecera model.
 */
class PresupuestoCabeceraController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PresupuestoCabecera models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new PresupuestoCabeceraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchPresupuesto = new PresupuestoSearch();
        $dataPresupuesto = $searchPresupuesto->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $actual_id = Yii::$app->request->post('editableKey');
            $model = Presupuesto::findOne($actual_id);
            $out = Json::encode(['output' => '', 'message' => '']);
            $post = [];
            $posted = current($_POST['Presupuesto']);
            $post['Presupuesto'] = $posted;

            if ($model->load($post)) {
                $model->save();
                //$output = '';
                //$out = Json::encode(['output' => $output, 'message' => '']);
            }
            return $out;
            //echo $out;
            //return;
        }

        //$columns = PresupuestoCabecera::getColumnFieldsOld();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchPresupuesto' => $searchPresupuesto,
            'dataPresupuesto' => $dataPresupuesto,
            //'columns' => $columns,
            'title' => null,
        ]);
    }

    /**
     * Lists all PresupuestoCabecera models.
     * @return mixed
     *//*
    public function actionIndexFactibilidad()
    {
        $searchModel = new PresupuestoCabeceraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchPresupuesto = new PresupuestoSearch();
        $dataPresupuesto = $searchPresupuesto->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $actual_id = Yii::$app->request->post('editableKey');
            $model = Presupuesto::findOne($actual_id);
            $out = Json::encode(['output' => '', 'message' => '']);
            $post = [];
            $posted = current($_POST['Presupuesto']);
            $post['Presupuesto'] = $posted;

            if ($model->load($post)) {
                $model->save();
                //$output = '';
                //$out = Json::encode(['output' => $output, 'message' => '']);
            }
            return $out;
            //echo $out;
            //return;
        }

        //$columns = PresupuestoCabecera::getColumnFieldsOld();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchPresupuesto' => $searchPresupuesto,
            'dataPresupuesto' => $dataPresupuesto,
            'esFactibilidad' => true.
            //'columns' => $columns,
            'title' => null,
        ]);
    }// */


    /**
     * Displays a single PresupuestoCabecera model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = "Rama Presupuestal : ".$model->lineaNivel->nombre_linea;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> $title,
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
     * Creates a new PresupuestoCabecera model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PresupuestoCabecera();
        $title = "Crear Nueva Rama Presupuestal";
        $array_partidas = Partida::getComboBoxItems();
        $array_padres   = PresupuestoCabecera::getComboBoxItems(false);
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
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new PresupuestoCabecera",
                    'content'=>'<span class="text-success">Registro exitoso</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];         
            }else{           
                return [
                    'title'=> "Create new PresupuestoCabecera",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
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
                return $this->redirect(['view', 'id' => $model->presupuesto_cabecera_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_partidas' => $array_partidas,
                    'array_padres'   => $array_padres,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing PresupuestoCabecera model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $array_partidas = Partida::getComboBoxItems();
        $array_padres   = PresupuestoCabecera::getComboBoxItems(false);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update PresupuestoCabecera #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "PresupuestoCabecera #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update PresupuestoCabecera #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_partidas' => $array_partidas,
                        'array_padres'   => $array_padres,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->presupuesto_cabecera_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_partidas' => $array_partidas,
                    'array_padres'   => $array_padres,
                ]);
            }
        }
    }

    /**
     * Delete an existing PresupuestoCabecera model.
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
     * Delete multiple existing PresupuestoCabecera model.
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
     * Finds the PresupuestoCabecera model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PresupuestoCabecera the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PresupuestoCabecera::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreatePresupuesto(){
        return Yii::$app->runAction('Presupuesto/presupuesto/create');
    }


}
