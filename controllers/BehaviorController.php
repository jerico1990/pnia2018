<?php

namespace app\controllers;

use Yii;
use app\models\Rol;
use app\models\RolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Auditoria\Usuario;
use app\models\RolProceso;
Use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * RolMaintenanceController implements the CRUD actions for Rol model.
 */
class BehaviorController extends Controller
{
	public function getRols(){
		return ['Administrador'];
	}

	/**
     * {@inheritdoc}
     */
    
    
    
    // public function behaviors()
    // {
    //     if (Yii::$app->user->isGuest)
    //         $this->redirect(Yii::$app->urlManager->createUrl ('site/login'));
        
    //     $usuario_autenticado = Usuario::findOne(Yii::$app->user->id);  

    //     $auth = Yii::$app->authManager;
    //     $array_roles = array();
    //     $array_permisos = array();
    //     if(!($auth->getRolesByUser(Yii::$app->user->id)))
    //     {
    //         //como no tiene roles no podra entrar a ninguna accion a excepcion de actionNoRolAction que bota un mensaje de alerta diciendo que no tiene rol asignado
    //         $array_permisos = ['no-rol-action'];
    //     }
    //     else{   
             
    //         $array_roles_usuario_autenticado = $auth->getRolesByUser($usuario_autenticado['id']);
    //         $array_permisos_usuario_autenticado = $auth->getPermissionsByUser($usuario_autenticado['id']);
            
    //         foreach ($array_roles_usuario_autenticado as $actual_rol_usuario_autenticado)
    //         {
    //             array_push($array_roles, $actual_rol_usuario_autenticado->name);
    //         }
    //         foreach ($array_permisos_usuario_autenticado as $actual_permiso_usuario_autenticado)
    //         {
    //             array_push($array_permisos, $actual_permiso_usuario_autenticado->name);
    //         }
    //     }
    //     if($usuario_autenticado->id==1){
    //         $acceder = [
    //             'allow' => true
    //         ]; 
    //     }
    //     else{
    //         $url= $_SERVER["REQUEST_URI"];
    //         $url_base = Url::base();
    //         $rpta='';
    //         $rpta=substr($url,strlen($url_base)+1, strlen($url)-1);
    //         $contador=0;
    //         for ($i=0; $i < strlen($rpta); $i++) { 
    //             if($rpta[$i]=='/' || $rpta[$i]=='?')
    //                 $contador++;
    //             if($contador==2){
    //                 $rpta=substr($rpta,0,$i);
    //                 break;
    //             }
    //         }
    //         if(in_array($rpta,$array_permisos)){
    //             $acceder = [
    //                 'allow' => true
    //             ]; 
    //         }
    //         else{
    //             $acceder = [
    //                 'allow' => false
    //             ];
    //         }
    //     }
    //      return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['post'],
    //                 'bulk-delete' => ['post'],
    //             ],
    //         ],
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [
    //                 $acceder
    //             ],
    //                 // [
    //                 //     'allow' => $acceder,
    //                 //     //'roles' => $Roles,
    //                 // ] 
    //                 // [
    //                 //     'allow' => true,
    //                 //     //$Permisos,
    //                 // ],
    //             //],

    //         ],
    //     ];
    // }





    public function behaviors()
    {
        if (Yii::$app->user->isGuest){
            $this->redirect(Yii::$app->urlManager->createUrl ('site/login'));
            $acceder = [
                    'allow' => false
            ]; 
        }
        else{
            if (Yii::$app->user->id)
                $usuario_autenticado = Usuario::findOne(Yii::$app->user->id);
            else
                $this->redirect(Yii::$app->urlManager->createUrl('Viatico/flujo-requerimiento'));

        // if (Yii::$app->user->isGuest)
        //     $this->redirect(Yii::$app->urlManager->createUrl('site/login'));


        $usuario_autenticado = Usuario::findOne(Yii::$app->user->id);

        // if (Yii::$app->user->id){
        //     $this->redirect(Yii::$app->urlManager->createUrl('site/login'));
        // }
        $array_permisos_actuales = $usuario_autenticado->getPermisosUrl();
        array_push($array_permisos_actuales, 'Patrimonio/documento-pnia');

        $actions=[];
        
        // if($usuario_autenticado->id==1){
        //     ///////////////////////////////////////
        //         array_push($actions,'index'); 
        //         array_push($actions,'view'); 
        //         array_push($actions,'create');
        //         array_push($actions,'update');                
        //         array_push($actions,'delete');                
        //         array_push($actions,'llenar-opciones'); 
        //         array_push($actions,'avanzar-paso');
        //         array_push($actions,'custom-update');                
        //         array_push($actions,'reset-password');                
        //         array_push($actions,'valorizar');                
        //         array_push($actions,'lista-items-patrimonio');                
        //         array_push($actions,'autocompletar-nombre-completo');                
        //         array_push($actions,'autocompletar-nombre-completo_edu');                
        //         array_push($actions,'enviar-codigo-interno');                
        //         array_push($actions,'create-penalidad');                
        //         array_push($actions,'create-entregable');                
        //         array_push($actions,'create-viatico-detalle');                
        //         array_push($actions,'calcular-monto');                
        //         array_push($actions,'autocomplete-fondo');                
        //         array_push($actions,'cambiar-combo-flujo-paso');                
        //         array_push($actions,'establecer-sesion-rol');                
        //         array_push($actions,'establecer-sesion');                
        //         array_push($actions,'limpiar-sesion-rol');                
        //         array_push($actions,'limpiar-sesion');                
        //         array_push($actions,'descargar-doc');                
        //         array_push($actions,'modificar-sesion-rol');                
        //         array_push($actions,'modificar-sesion');
        //         array_push($actions,'enviar-codigo-requerimiento');
        //         array_push($actions,'create-paso');
        //         array_push($actions,'cargar-rendicion-generica');
        //         array_push($actions,'enviar-codigo-rendicion');
        //         array_push($actions,'llenar-importe-gravado');
        //         array_push($actions,'create-rendicion-generica-caja-chica');
        //         array_push($actions,'create-rendicion-generica-viatico');
        //         array_push($actions,'create-rendicion-generica-encargo');
        //         array_push($actions,'enviar-codigo-rendicion');
        //         array_push($actions,'llenar-importe-gravado');
        //         array_push($actions,'cargar-periodos');
                
                
        //         ///////////////////////////////////////
        //     $acceder = [
        //         'allow' => true,
        //         'actions' => $actions
        //     ]; 
        // }
        // else{
            $url= $_SERVER["REQUEST_URI"];
            $url_base = Url::base();
            $rpta='';
            $rpta=substr($url,strlen($url_base)+1, strlen($url)-1);
            $contador=0;
            for ($i=0; $i < strlen($rpta); $i++) { 
                if($rpta[$i]=='/' || $rpta[$i]=='?')
                    $contador++;
                if($contador==2){
                    $rpta=substr($rpta,0,$i);
                    break;
                }
            }
            if(in_array($rpta,$array_permisos_actuales)){
                if($rpta=='Patrimonio/documento-pnia'){
                    array_push($actions,'index');
                }
                $acciones = $usuario_autenticado->getAccionesPermiso($rpta);
                
                foreach ($acciones as $actual_accion) {
                    array_push($actions,$actual_accion->accion);
                }
                ///////////////////////////////////////              
                array_push($actions,'llenar-opciones'); 
                array_push($actions,'avanzar-paso');
                array_push($actions,'custom-update');                
                array_push($actions,'reset-password');                
                array_push($actions,'valorizar');                
                array_push($actions,'lista-items-patrimonio');                
                array_push($actions,'autocompletar-nombre-completo');                
                array_push($actions,'autocompletar-nombre-completo_edu');                
                array_push($actions,'enviar-codigo-interno');                
                array_push($actions,'create-penalidad');                
                array_push($actions,'create-entregable');                
                array_push($actions,'create-viatico-detalle');                
                array_push($actions,'calcular-monto');                
                array_push($actions,'autocomplete-fondo');                
                array_push($actions,'cambiar-combo-flujo-paso');                
                array_push($actions,'establecer-sesion-rol');                
                array_push($actions,'establecer-sesion');                
                array_push($actions,'limpiar-sesion-rol');                
                array_push($actions,'limpiar-sesion');                
                array_push($actions,'descargar-doc');                
                array_push($actions,'modificar-sesion-rol');                
                array_push($actions,'modificar-sesion');
                array_push($actions,'enviar-codigo-requerimiento');
                array_push($actions,'create-paso');
                array_push($actions,'cargar-rendicion-generica');
                array_push($actions,'enviar-codigo-rendicion');
                array_push($actions,'llenar-importe-gravado');
                array_push($actions,'create-rendicion-generica-caja-chica');
                array_push($actions,'create-rendicion-generica-viatico');
                array_push($actions,'create-rendicion-generica-encargo');
                array_push($actions,'enviar-codigo-rendicion');
                array_push($actions,'llenar-importe-gravado');
                array_push($actions,'cargar-periodos');
                array_push($actions,'llenar-monto-predeterminado');
                array_push($actions,'monto-estimado');
                array_push($actions,'analiza-contrato-adquisicion');
                array_push($actions,'validar-monto-periodo');
                array_push($actions,'validar-porcentaje');
                array_push($actions,'cargar-documentos-contrato');
                array_push($actions,'obtener-presupuestos-disponibles');

                
                ///////////////////////////////////////
                
                $acceder = [
                    'allow' => true,
                    'actions' => $actions
                ]; 
            }
            else{
                $acceder = [
                    'allow' => false
                ];
            }
        // }
    }
         return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    $acceder
                ],
                    // [
                    //     'allow' => $acceder,
                    //     //'roles' => $Roles,
                    // ] 
                    // [
                    //     'allow' => true,
                    //     //$Permisos,
                    // ],
                //],

            ],
        ];
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