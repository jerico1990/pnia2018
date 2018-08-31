<?php

namespace app\controllers\Patrimonio;

use Yii;
use app\models\Patrimonio\PatrimonioMovimiento;
use app\models\Patrimonio\PatrimonioMovimientoSearch;
use app\models\Patrimonio\Metacodigo;
use app\models\Patrimonio\Ubicacion;
use app\models\Patrimonio\PatrimonioItem;
use app\models\Auditoria\Usuario;
use \yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\controllers\BehaviorController;


/**
 * PatrimonioMovimientoController implements the CRUD actions for PatrimonioMovimiento model.
 */
class PatrimonioMovimientoController extends BehaviorController
{

    /**
     * Lists all PatrimonioMovimiento models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new PatrimonioMovimientoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single PatrimonioMovimiento model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $metacodigoDescripcion = $model->getMetacodigo()->one()->descripcion;
        $itemDescripcion = $model->getPatrimonioItem()->one()->descripcion;
        $title = "Movimiento : ".$metacodigoDescripcion." - ".$itemDescripcion;

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
     * Creates a new PatrimonioMovimiento model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionListaItemsPatrimonio($id){
        // you may need to check whether the entered ID is valid or not
        $model= \app\models\Patrimonio\PatrimonioItem::findOne(['patrimonio_item_id'=>$id]);
        return \yii\helpers\Json::encode([
            'descripcion'=>$model->descripcion,
            'marca'=>$model->marca,
            'modelo'=>$model->modelo,
            'serie'=>$model->serie,
        ]);
    }
    
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PatrimonioMovimiento();  
        $title = "Registrar Movimiento";
        $PatrimonioItem = new PatrimonioItem();
        //$PatrimonioItemsLista = $PatrimonioItems->getTodosLosItems(); //agregada funcion
        
        $array_metacodigos      = [];
        $array_ubicaciones       = [];
        $array_items     = [];
        $array_user     = [];

        $array_metacodigos         = ArrayHelper::map(Metacodigo::getComboBoxList(Yii::$app->params['metacodigoFlags']['Movimiento']), 'metacodigo_id', 'descripcion');

        $array_ubicaciones          = ArrayHelper::map((new Ubicacion())->getUbicaciones(), 'ubicacion_id', 'nombre');
        $array_items        = ArrayHelper::map((new PatrimonioItem())->getTodosLosItems(), 'patrimonio_item_id', 'descripcion');
        $array_user        = ArrayHelper::map((new Usuario())->getUser(), 'usuario_id', 'nombre');
        
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
                        'metacodigos' => $array_metacodigos,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_user,
                        'model_item' => $PatrimonioItem,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Creación exitosa</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'metacodigos' => $array_metacodigos,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_user,
                        'model_item' => $PatrimonioItem,
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
                return $this->redirect(['view', 'id' => $model->patrimonio_movimiento_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                        'metacodigos' => $array_metacodigos,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_user,
                        'model_item' => $PatrimonioItem,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing PatrimonioMovimiento model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);  
        
        $metacodigoDescripcion = $model->getMetacodigo()->one()->descripcion;
        $itemDescripcion = $model->getPatrimonioItem()->one()->descripcion;
        $title = "Actualizar Movimiento : ".$metacodigoDescripcion." - ".$itemDescripcion;

        $PatrimonioItem = new PatrimonioItem();
        $PatrimonioItem = $PatrimonioItem->findIdentity($model->patrimonio_item_id);
        //$PatrimonioItemsLista = $PatrimonioItem->getTodosLosItems(); //agregada funcion
        
        
        $array_metacodigos      = [];
        $array_ubicaciones       = [];
        $array_items     = [];
        $array_user     = [];     
        if(! $model->load($request->post())) {
            $array_metacodigos         = ArrayHelper::map(Metacodigo::getComboBoxList('Movimiento'), 'metacodigo_id', 'descripcion');
            $array_ubicaciones          = ArrayHelper::map((new Ubicacion())->getUbicaciones(), 'ubicacion_id', 'nombre');
            $array_items        = ArrayHelper::map((new PatrimonioItem())->getTodosLosItems(), 'patrimonio_item_id', 'descripcion');
            $array_user        = ArrayHelper::map((new Usuario())->getUser(), 'usuario_id', 'nombre');
        }
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
                        'metacodigos' => $array_metacodigos,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_user,
                        'model_item' => $PatrimonioItem,
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
                        'metacodigos' => $array_metacodigos,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_user,
                        'model_item' => $PatrimonioItem,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'metacodigos' => $array_metacodigos,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_user,
                        'model_item' => $PatrimonioItem,

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
                return $this->redirect(['view', 'id' => $model->patrimonio_movimiento_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'metacodigos' => $array_metacodigos,
                        'ubicaciones' => $array_ubicaciones,
                        'items' => $array_items,
                        'user' => $array_user,
                        'model_item' => $PatrimonioItem,
                ]);
            }
        }
    }

    /**
     * Delete an existing PatrimonioMovimiento model.
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
     * Delete multiple existing PatrimonioMovimiento model.
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
     * Finds the PatrimonioMovimiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrimonioMovimiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioMovimiento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
