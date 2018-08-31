<?php

namespace app\controllers\Auditoria;

use Yii;
use app\models\Auditoria\Rol;
use app\models\Auditoria\RolSearch;
use app\models\Auditoria\Proceso;
use app\models\Auditoria\ProcesoSearch;
use app\controllers\BehaviorController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use \yii\helpers\ArrayHelper;

use app\models\Auditoria\Usuario;
use yii\helpers\Url;
use app\models\RolProceso;
Use yii\filters\AccessControl;

/**
 * RolController implements the CRUD actions for Rol model.
 */
class RolController extends BehaviorController
{

    /**
     * Lists all Rol models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new RolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
//        $RolProcesos = new \app\models\RolProceso;
//        $listaProcesos = \app\models\RolProceso::findOne(['rol_proceso_id' => '1'])->procesos;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Rol model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = "Datos de ".$model->nombre;
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
     * Creates a new Rol model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Rol(); 
        $title = "Registrar Nuevo Rol";
        
        $procesos = new Proceso();
        
        $PuenteRolProceso = new Proceso();

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
                        'procesos' => $procesos,
                        'puenteRolProceso' => $PuenteRolProceso,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Rol Creado</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'procesos' => $procesos,
                        'puenteRolProceso' => $PuenteRolProceso,
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
                return $this->redirect(['view', 'id' => $model->rol_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'procesos' => $procesos,
                    'puenteRolProceso' => $PuenteRolProceso,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Rol model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $request = Yii::$app->request;
        $model = $this->findModel($id);   
        $title = "Actualizar Datos de ".$model->nombre;
        //$this->actionLimpiarSesion();
        // if(!isset($_SESSION['valoresSeleccionados'])){
        //     $this->actionLimpiarSesion();
        // }
        
        if(! $model->load($request->post())) {
            $rol_temporal = new Rol();
            $this->actionLimpiarSesionRol();
            $rol_temporal = $rol_temporal->findById($model->rol_id);
            $array_asignable_sesion = $rol_temporal->getRolProcesoAccion();
            //print_r($array_asignable_sesion);
            $this->actionEstablecerSesionRol($array_asignable_sesion);
        }
        
        $proceso_searchModel = new ProcesoSearch();
        $proceso_dataProvider = $proceso_searchModel->search(Yii::$app->request->queryParams);

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
                        'proceso_searchModel' => $proceso_searchModel,
                        'proceso_dataProvider' => $proceso_dataProvider
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                //return $this->getValoresSeleccionados();
                $model->AsignarProcesos($this->getValoresSeleccionadosRol());
                return [
                    // 'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'proceso_searchModel' => $proceso_searchModel,
                        'proceso_dataProvider' => $proceso_dataProvider
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'proceso_searchModel' => $proceso_searchModel,
                        'proceso_dataProvider' => $proceso_dataProvider
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
                return $this->redirect(['view', 'id' => $model->rol_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'proceso_searchModel' => $proceso_searchModel,
                        'proceso_dataProvider' => $proceso_dataProvider
                ]);
            }
        }
    }

    /**
     * Delete an existing Rol model.
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
     * Delete multiple existing Rol model.
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
    public function actionAgregarProcesosARol(){
        return $this->redirect(['index']);
    }
    
    public function actionCreate1(){
        $request = Yii::$app->request;
        $model = new \app\models\RolUsuario();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new RolUsuario",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new RolUsuario",
                    'content'=>'<span class="text-success">Create RolUsuario success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new RolUsuario",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
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
                return $this->redirect(['view', 'id' => $model->rol_usuario_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Finds the Rol model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rol the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rol::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getRols(){
        return ['Administrador'];
    }


    /**
     * [getValoresSeleccionados retorna los valores seleccionados por medio del actionModificarSesion]
     * @return [??] [valores almacenados en $_SESSION['valoresSeleccionados']]
     */
    public function getValoresSeleccionadosRol(){
        if (isset($_SESSION['valoresSeleccionadosRol'])) {
            return $_SESSION['valoresSeleccionadosRol'];
        } else {
            return [];
        }
    }

    /**
     * [getValoresSeleccionados retorna los valores seleccionados por medio del actionModificarSesion]
     * @return [??] [valores almacenados en $_SESSION['valoresSeleccionados']]
     */
    public function getValoresSeleccionados(){
        if (isset($_SESSION['valoresSeleccionados'])) {
            return $_SESSION['valoresSeleccionados'];
        } else {
            return [];
        }
    }

    public function actionEstablecerSesionRol($variable){
        $this->actionLimpiarSesion();
        $_SESSION['valoresSeleccionadosRol'] = $variable;
    }

    public function actionEstablecerSesion($variable){
        $this->actionLimpiarSesion();
        $_SESSION['valoresSeleccionados'] = $variable;
    }

    /**
     * [actionLimpiarSesion : Limpia la variable de sesión : "valoresSeleccionados"]
     * @return [-] 
     */
    public function actionLimpiarSesion(){
        $_SESSION['valoresSeleccionados']=[];

        // unset($_SESSION['valoresSeleccionados']);
        // unset($_SESSION['codigo_interno_contrato']);
        // unset($_SESSION['codigo_visible_contrato']);
        // unset($_SESSION['flujo_requerimiento_id']);
        // unset($_SESSION['codigo_requerimiento']);
        // unset($_SESSION['fondo_fondo_id']);
    }

    /**
     * [actionLimpiarSesion : Limpia la variable de sesión : "valoresSeleccionados"]
     * @return [-] 
     */
    public function actionLimpiarSesionRol(){
        $_SESSION['valoresSeleccionadosRol']=[];
    }

    /**
     * [actionModificarSesion : Cuando un elemento es seleccionado debe ser enviado por metodo POST con la llave(key) : 'nuevoSeleccionado', la función procesa dicho envio y lo agrega a SESSION['valoresSeleccionados']]
     * @return [['id' => 'id'] ] [$_SESSION['valoresSeleccionados']]
     */
    public function actionModificarSesionRol(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //proceso_id
        if(isset($_SESSION['valoresSeleccionadosRol'][$_POST['proceso_id']][$_POST['nuevoSeleccionado']])){
            unset($_SESSION['valoresSeleccionadosRol'][$_POST['proceso_id']][$_POST['nuevoSeleccionado']]);
            return $_SESSION['valoresSeleccionadosRol'];
        } 
        else {             
            $_SESSION['valoresSeleccionadosRol'][$_POST['proceso_id']][$_POST['nuevoSeleccionado']] = $_POST['nuevoSeleccionado']; 
            return $_SESSION['valoresSeleccionadosRol'];
        }        
    }

    public function actionModificarSesion(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(isset($_SESSION['valoresSeleccionados'][$_POST['nuevoSeleccionado']])){
            unset($_SESSION['valoresSeleccionados'][$_POST['nuevoSeleccionado']]);
            return $_SESSION['valoresSeleccionados'];
        } 
        else {             
            $_SESSION['valoresSeleccionados'][$_POST['nuevoSeleccionado']] = $_POST['nuevoSeleccionado']; 
            return $_SESSION['valoresSeleccionados'];
        }        
    }
    
        public function actionDescargarDoc($doc_id) 
    { 
        $download = \app\models\Patrimonio\DocumentoPnia::findOne($doc_id); 
        //$path = Yii::getAlias('@webroot').'/uploads/'.$download->project_file;
        $path = $download->ruta_documento;
        //$path = 'http://localhost/pnia/uploadedfiles/' . $download->nombre_documento;
        if (file_exists($path)){
            return  Yii::$app->response->sendFile($path)->send();
                    //response->SendFile($path, $download->image_web_filename)->send());
        }
            else
                echo($path);
                echo ('Algo salio mal');
    }
}
