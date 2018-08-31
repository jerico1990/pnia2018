<?php

namespace app\controllers\Auditoria;

use Yii;
use app\models\rrhh\StaffPersona;
use app\models\Auditoria\Usuario;
use app\models\Auditoria\UsuarioSearch;
use app\models\Auditoria\RolUsuario;
use app\models\Auditoria\RolSearch;
use app\controllers\BehaviorController;
use yii\web\NotFoundHttpException;
use \yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\RolProceso;
Use yii\filters\AccessControl;
//use yii\web\Controller;


/// agregue esto para pruebas con Mau, borrar
//Use yii\filters\AccessControl;
/// agregue esto para pruebas con Mau, borrar
/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends BehaviorController
{

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $rol_searchModel = new RolSearch();
        $rol_dataProvider = $rol_searchModel->search(Yii::$app->request->queryParams);

        $model = $this->findModel($id);
        if (isset($model->persona_id)) {
            $persona = StaffPersona::findOne($model->persona_id);
            $name = $persona->nombres.' '.$persona->apellido_paterno.' '.$persona->apellido_materno;

        } else {
            $name = $model->alias;
        }
        $title = "Datos de ".$name;//." ".$model->apellido_paterno." ".$model->apellido_materno; 

        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'rol_searchModel' => $rol_searchModel,
                        'rol_dataProvider' => $rol_dataProvider
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
                'rol_searchModel' => $rol_searchModel,
                'rol_dataProvider' => $rol_dataProvider
            ]);
        }
    }

    /**
     * Creates a new Usuario model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Usuario();  
        $title = "Crear Nuevo Usuario";
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Nuevo Usuario Registrado, Contraseña Autogenerada: '.$model->password_temporal.'  </span>',
                    
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::$app->params['textoEspañol']['crearMas'],['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model
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
                return $this->redirect(['view', 'id' => $model->usuario_id]);
            } else {
                return $this->render('create', [
                    'model' => $model
                ]);
            }
        }
    }

    /**
     * Updates an existing Usuario model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if (isset($model->persona_id)) {
            $persona = StaffPersona::findOne($model->persona_id);
            $name = $persona->nombres.' '.$persona->apellido_paterno.' '.$persona->apellido_materno;

        } else {
            $name = $model->alias;
        }
        $title = "Actualizar Datos de ".$name;;//nombre." ".$model->apellido_paterno." ".$model->apellido_materno;  

        if(!isset($_SESSION['valoresSeleccionados'])){
            $this->actionLimpiarSesion();
        }

        /// Inicialización de los datos
        if(! $model->load($request->post())) {
            $usuario_temporal = new Usuario();
            $array_rol_ids = ArrayHelper::map($usuario_temporal->getRoles($model->usuario_id) , 'rol_id', 'rol_id');
            $this->actionEstablecerSesion($array_rol_ids);
        }

        $rol_searchModel = new RolSearch();
        $rol_dataProvider = $rol_searchModel->search(Yii::$app->request->queryParams);

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
                        'rol_searchModel'  => $rol_searchModel,
                        'rol_dataProvider' => $rol_dataProvider
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                $model->AsignarRoles($this->getValoresSeleccionados());
                return [
                    // 'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'rol_searchModel' => $rol_searchModel,
                        'rol_dataProvider' => $rol_dataProvider
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'rol_searchModel' => $rol_searchModel,
                        'rol_dataProvider' => $rol_dataProvider
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
                $model->AsignarRoles($this->getValoresSeleccionados());
                return $this->redirect(['view', 'id' => $model->usuario_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'rol_searchModel' => $rol_searchModel,
                    'rol_dataProvider' => $rol_dataProvider
                ]);
            }
        }
    }

    /**
     * Delete an existing Usuario model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->AsignarRoles([]);
        $model->delete();

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
     * Delete multiple existing Usuario model.
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
     * Delete multiple existing Usuario model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAgregarRolAUsuario()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $RolUsuario = new RolUsuario();
            $RolUsuario->rol_id = $pk;
            $RolUsuario->usuario_id = '1';
            //print_r($RolUsuario);
            $RolUsuario->save();
            // if($RolUsuario->save())
            //     echo "bien";
            // else
            //     echo "mal";
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
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * [actionFormula description]
     * @return [type] [description]
     */
    public function actionCustomUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = "Actualizar Datos de ".$model->alias;//nombre." ".$model->apellido_paterno." ".$model->apellido_materno;  
        /// Inicialización de los datos
        if(! $model->load($request->post())) {
            $usuario_temporal = new Usuario();
            $array_rol_ids = ArrayHelper::map($usuario_temporal->getRoles($model->usuario_id) , 'rol_id', 'rol_id');
            $this->actionEstablecerSesion($array_rol_ids);
        }

        $rol_searchModel = new RolSearch();
        $rol_dataProvider = $rol_searchModel->search(Yii::$app->request->queryParams);
        
        $arreglo_de_preguntas = array(
            '0' => '¿En qué ciudad naciste?',
            '1' => '¿Cuál es el nombre de tu primera mascota?',
            '2' => '¿Cuál es tu color favorito?',
            '3' => '¿En qué ciudad se conocieron tus padres?',
            '20' => 'No establecida',
        );

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
                        'rol_searchModel' => $rol_searchModel,
                        'rol_dataProvider' => $rol_dataProvider,
                        'arreglo_de_preguntas' => $arreglo_de_preguntas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){

                $model->AsignarRoles($this->getValoresSeleccionados());
                
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'rol_searchModel' => $rol_searchModel,
                        'rol_dataProvider' => $rol_dataProvider,
                        'arreglo_de_preguntas' => $arreglo_de_preguntas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'rol_searchModel' => $rol_searchModel,
                        'rol_dataProvider' => $rol_dataProvider,
                        'arreglo_de_preguntas' => $arreglo_de_preguntas,
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
                $model->AsignarRoles($this->getValoresSeleccionados());
                return $this->redirect(['view', 'id' => $model->usuario_id]);
            } else {
                return $this->render('password_update', [
                    'model' => $model,
                    'rol_searchModel' => $rol_searchModel,
                    'rol_dataProvider' => $rol_dataProvider,
                    'arreglo_de_preguntas' => $arreglo_de_preguntas,
                ]);
            }
        }
    }


    /**
     * [actionFormula description]
     * @return [type] [description]
     */
    public function actionResetPassword($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = "Restaurar Contraseña ";
  
        if ($model->pregunta_secreta_1 == NULL){
            $model->pregunta_secreta_1 = 20;
            $model->pregunta_secreta_2 = 20;
            $model->pregunta_secreta_3 = 20;
        }
  
        $arreglo_de_preguntas = array(
            '0' => '¿En qué ciudad naciste?',
            '1' => '¿Cuál es el nombre de tu primera mascota?',
            '2' => '¿Cuál es tu color favorito?',
            '3' => '¿En qué ciudad se conocieron tus padres?',
            '20' => 'No establecida',
        );
        
        $reset = false;
        
        ///?????????????????????????????????????????????????????????????
        /// Inicialización de los datos
        if(! $model->load($request->post())) {

            $rand_index_1 = rand(0,2);
            $rand_index_2 = rand(0,2);

            while($rand_index_1 == $rand_index_2){
                $rand_index_1 = rand(0,2);
            }

            $preguntas = [  $model->pregunta_secreta_1,
                            $model->pregunta_secreta_2,
                            $model->pregunta_secreta_3,];

            $respuestas = [ $model->respuesta_secreta_1,
                            $model->respuesta_secreta_2,
                            $model->respuesta_secreta_3,];

            $preguntas = [  $preguntas[$rand_index_1],
                            $preguntas[$rand_index_2]];

            $respuestas = [ $respuestas[$rand_index_1],
                            $respuestas[$rand_index_2]];

            $model->respuesta_random_1 = '';
            $model->respuesta_random_2 = '';

            $_SESSION['randIndex1'] = $rand_index_1;
            $_SESSION['randIndex2'] = $rand_index_2;
            
        }else{
            $respuestas = [ 0 => $model->respuesta_secreta_1,
                            1 => $model->respuesta_secreta_2,
                            2 => $model->respuesta_secreta_3,];

            $respuestas = [ 
                $respuestas[$_SESSION['randIndex1'] ],
                $respuestas[$_SESSION['randIndex2'] ]
            ];
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('_form_re_establecer_password', [
                        'model' => $model,
                        'preguntas'  => $preguntas,
                        'arreglo_de_preguntas' => $arreglo_de_preguntas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if ($model->load($request->post())) {

                
               if ( $model->respuesta_random_1 != $model->respuesta_secreta_1){
                    $reset = false;
                }
                else{
                    $reset = true;
                }
                if ( $model->respuesta_random_2 != $model->respuesta_secreta_2){
                    $reset = false;
                }
                else{
                    $reset = true;
                }
                
//                $reset = strcmp( $model->respuesta_random_1,
//                                 $respuestas[0]) +
//                         strcmp( $model->respuesta_random_2,
//                                 $respuestas[1]) ;

                if ($reset == true){
                    $password_temporal = $model->generateRandomString();
                    $model->setPassword($password_temporal);
                    $model->password_temporal = $password_temporal;
                    $model->save();
                }

                return [
                    /// aqui se guardo y se muestra la contraseña re-establecida
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view_password_restablecido', [
                        'model' => $model,
                        'reset' => $reset,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('_form_re_establecer_password', [
                        'model' => $model,
                        'preguntas'  => $preguntas,
                        'arreglo_de_preguntas' => $arreglo_de_preguntas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post())) {

//                $reset = strcmp( $model->respuesta_random_1,
//                                 $respuestas[0]) +
//                         strcmp( $model->respuesta_random_2,
//                                 $respuestas[1]) ;
                
                if ( $model->respuesta_random_1 != $model->respuesta_secreta_1){
                    $reset = false;
                }
                else{
                    $reset = true;
                }
                if ( $model->respuesta_random_2 != $model->respuesta_secreta_2){
                    $reset = false;
                }
                else{
                    $reset = true;
                }
                              

                if ($reset == true){
                    $password_temporal = $model->generateRandomString();
                    $model->setPassword($password_temporal);
                    $model->password_temporal = $password_temporal;
                    $model->save();
                }

                return $this->render('view_password_restablecido',[
                    'model' => $model,
                ]);

            } else {
                return $this->render('_form_re_establecer_password', [
                    'model'      => $model,
                    'preguntas'  => $preguntas,
                    'arreglo_de_preguntas' => $arreglo_de_preguntas,
                ]);

            }
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
