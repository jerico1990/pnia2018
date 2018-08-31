<?php

namespace app\controllers\Viatico;

use Yii;
use app\models\Viatico\FondoRendicionGenerico;
use app\models\Viatico\FondoRendicionGenericoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\controllers\BehaviorController;
use app\models\Patrimonio\Metacodigo;
use app\models\rrhh\PniaEntidad;

/**
 * FondoRendicionGenericoController implements the CRUD actions for FondoRendicionGenerico model.
 */
class GestionRendicionCajaChicaController extends BehaviorController
{
    /**
     * @inheritdoc
     */

    /**
     * Lists all FondoRendicionGenerico models.
     * @return mixed
     */
    public function actionEnviarCodigoRendicion(){
        $_SESSION['fondo_rendicion_caja_chica_id'] = $_POST['fondo_rendicion_caja_chica_id'];
        return true;
    }
    
    public function actionIndex()
    {    
        $searchModel = new FondoRendicionGenericoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single FondoRendicionGenerico model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Detalle de Rendición de Caja Chica ",
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
     * Creates a new FondoRendicionGenerico model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new FondoRendicionGenerico();  
        
        $array_tipo_afecto = [1 => 'Si', 2 => 'No'];
        $array_metacodigo_tipo_bien_servicio = Metacodigo::getComboBoxItems('Tipo_Bien_Servicio');
        $array_metacodigo_documento_rendicion = Metacodigo::getComboBoxItems('Tipo_Documento_Rendicion');
        $array_pnia_entidades = PniaEntidad::getPniaEntidades();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Agregar Nuevo Detalle de Rendición de Caja Chica",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_tipo_afecto' => $array_tipo_afecto,
                        'array_metacodigo_tipo_bien_servicio' => $array_metacodigo_tipo_bien_servicio,
                        'array_metacodigo_documento_rendicion' => $array_metacodigo_documento_rendicion,
                        'array_pnia_entidades' => $array_pnia_entidades,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $model->asignarSaldos();
                $model->fondo_rendicion_caja_chica_id = $_SESSION['fondo_rendicion_caja_chica_id'];
                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-rendicion-caja-chica-pjax',
                    'title'=> "Agregar Nuevo Detalle de Rendición de Caja Chica",
                    'content'=>'<span class="text-success">Detalle de Rendición de Caja Chica Agregado</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Agregar Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Agregar Nuevo Detalle de Rendición de Caja Chica",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_tipo_afecto' => $array_tipo_afecto,
                        'array_metacodigo_tipo_bien_servicio' => $array_metacodigo_tipo_bien_servicio,
                        'array_metacodigo_documento_rendicion' => $array_metacodigo_documento_rendicion,
                        'array_pnia_entidades' => $array_pnia_entidades,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if($model->load($request->post()) && $model->validate()){
                $model->fondo_rendicion_caja_chica_id = $_SESSION['fondo_rendicion_caja_chica_id'];
                $model->save();
                return $this->redirect(['view', 'id' => $model->fondo_rendicion_generico_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_tipo_afecto' => $array_tipo_afecto,
                    'array_metacodigo_tipo_bien_servicio' => $array_metacodigo_tipo_bien_servicio,
                    'array_metacodigo_documento_rendicion' => $array_metacodigo_documento_rendicion,
                    'array_pnia_entidades' => $array_pnia_entidades,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing FondoRendicionGenerico model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);     
        
        $array_tipo_afecto = [1 => 'Si', 2 => 'No'];
        $array_metacodigo_tipo_bien_servicio = Metacodigo::getComboBoxItems('Tipo_Bien_Servicio');
        $array_metacodigo_documento_rendicion = Metacodigo::getComboBoxItems('Tipo_Documento_Rendicion');
        $array_pnia_entidades = PniaEntidad::getPniaEntidades();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Actualizar Detalle de Rendición de Caja Chica ",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_tipo_afecto' => $array_tipo_afecto,
                        'array_metacodigo_tipo_bien_servicio' => $array_metacodigo_tipo_bien_servicio,
                        'array_metacodigo_documento_rendicion' => $array_metacodigo_documento_rendicion,
                        'array_pnia_entidades' => $array_pnia_entidades,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $model->asignarSaldos();
                $model->fondo_rendicion_caja_chica_id = $_SESSION['fondo_rendicion_caja_chica_id'];
                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-rendicion-caja-chica-pjax',
                    'title'=> "Detalle de Rendición de Caja Chica ",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_tipo_afecto' => $array_tipo_afecto,
                        'array_metacodigo_tipo_bien_servicio' => $array_metacodigo_tipo_bien_servicio,
                        'array_metacodigo_documento_rendicion' => $array_metacodigo_documento_rendicion,
                        'array_pnia_entidades' => $array_pnia_entidades,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Actualizar Detalle de Rendición de Caja Chica ",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_tipo_afecto' => $array_tipo_afecto,
                        'array_metacodigo_tipo_bien_servicio' => $array_metacodigo_tipo_bien_servicio,
                        'array_metacodigo_documento_rendicion' => $array_metacodigo_documento_rendicion,
                        'array_pnia_entidades' => $array_pnia_entidades,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if($model->load($request->post()) && $model->validate()){
                $model->fondo_rendicion_caja_chica_id = $_SESSION['fondo_rendicion_caja_chica_id'];
                $model->save();
                return $this->redirect(['view', 'id' => $model->fondo_rendicion_generico_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_tipo_afecto' => $array_tipo_afecto,
                    'array_metacodigo_tipo_bien_servicio' => $array_metacodigo_tipo_bien_servicio,
                    'array_metacodigo_documento_rendicion' => $array_metacodigo_documento_rendicion,
                    'array_pnia_entidades' => $array_pnia_entidades,
                ]);
            }
        }
    }

    /**
     * Delete an existing FondoRendicionGenerico model.
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-rendicion-caja-chica-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing FondoRendicionGenerico model.
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-rendicion-caja-chica-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the FondoRendicionGenerico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FondoRendicionGenerico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FondoRendicionGenerico::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
