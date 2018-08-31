<?php

namespace app\models\Auditoria;

use Yii;
//use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Url;

use app\models\rrhh\StaffPersona;
use app\models\Mensaje;
use app\models\Auditoria\RolUsuario;
use app\models\Auditoria\RolProceso;
use app\models\Auditoria\Proceso;
use app\models\Auditoria\AuthorizationManager;
use \yii\helpers\ArrayHelper;
use app\models\Auditoria\RolProcesoAccion;


/**
 * This is the model class for table "usuario".
 *
 * @property int $usuario_id
 * @property string $alias
 * @property string $clave_autenticacion
 * @property string $password_hash
 * @property string $token_de_acceso
 * @property string $pregunta_secreta_1
 * @property string $pregunta_secreta_2
 * @property string $pregunta_secreta_3
 * @property string $respuesta_secreta_1
 * @property string $respuesta_secreta_2
 * @property string $respuesta_secreta_3
 * 
 * @property Mensaje[] $mensajesDe
 * @property Mensaje[] $mensajesPara
 * @property Modulo[] $modulos
 * @property Modulo[] $modulos0
 * @property Proceso[] $procesos
 * @property Proceso[] $procesos0
 * @property Rol[] $rols
 * @property Rol[] $rols0
 * @property RolProceso[] $rolProcesos
 * @property RolProceso[] $rolProcesos0
 * @property RolUsuario[] $rolUsuarios
 * @property RolUsuario[] $rolUsuarios0
 * @property RolUsuario[] $rolUsuarios1
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $autocomplete_staff_persona;
    public $password_repeat;
    public $password_temporal;
    public $password_viejo;

    public $respuesta_random_1;
    public $respuesta_random_2;
    public $respuesta_random_3;

    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['alias'],'unique'],
            [['autocomplete_staff_persona'],'string'],
            [['alias', 'password_hash'], 'string', 'max' => 255],
            [['pregunta_secreta_1', 'pregunta_secreta_2', 'pregunta_secreta_3', 'respuesta_secreta_1', 'respuesta_secreta_2', 'respuesta_secreta_3'], 'string', 'max' => 255],
            [['respuesta_random_1', 'respuesta_random_2'], 'string', 'max' => 255],
            [['clave_autenticacion'], 'string', 'max' => 32],
            [['token_de_acceso'], 'string', 'max' => 100],
            [['password_viejo','password_repeat'], 'string'],
            [['password_hash'],     'checkPasswordComplexity'],
            [['password_repeat'],   'checkPasswordRepeate'],
            [['password_viejo'],'checkPasswordViejo'],
            [['persona_id'],'unique'], /// evita que un usuario tenga más de una cuenta
            
            //['password_repeat', 'compare', 'compareAttribute'=>'password_hash', 'message'=>"Contraseñas no coinciden" ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => 'Usuario ID',
            'alias' => 'Alias',
            'clave_autenticacion' => 'Clave Autenticación',
            'password_hash' => 'Nuevo Password',
            'token_de_acceso' => 'Token De Acceso',
            'password_repeat' => 'Repetir Password',
            'password_viejo' => 'Password Actual',
            'pregunta_secreta_1' => 'Pregunta Secreta 1',
            'pregunta_secreta_2' => 'Pregunta Secreta 2',
            'pregunta_secreta_3' => 'Pregunta Secreta 3',
            'respuesta_secreta_1' => 'Respuesta Secreta 1',
            'respuesta_secreta_2' => 'Respuesta Secreta 2',
            'respuesta_secreta_3' => 'Respuesta Secreta 3',
            'persona_id' => 'Persona ID',
        ];
    }
    
    public function validarPreguntaSecreta1(){
        if ($this->$respuesta_random_1 != $this->pregunta_secreta_1){
            $this->addError('$respuesta_random_1', 'La respuesta no es correcta.');
        }
    }
    
    public function validarPreguntaSecreta2(){
        if (!($this->dni >= 10000000 && $this->dni <= 99999999))
        {
            $this->addError('dni', 'DNI no válido');
        }
    }
    
    public function validarPreguntaSecreta3(){
        if (!($this->dni >= 10000000 && $this->dni <= 99999999))
        {
            $this->addError('dni', 'DNI no válido');
        }
    }

    public function getAccionesPermiso($url_accion){
        $array_acciones = [];
        $array_rol_usuario = RolUsuario::find()->where(['usuario_id'=>$this->usuario_id])->all();
        foreach ($array_rol_usuario as $actual_rol_usuario) {
            $array_rol_proceso = RolProceso::find()->where(['rol_id'=>$actual_rol_usuario->rol_id])->all();
            
            foreach ($array_rol_proceso as $actual_rol_proceso) {

                if($actual_rol_proceso->permiso == $url_accion){
                    $temporal_array_acciones = RolProcesoAccion::find()->where(
                        ['rol_proceso_id'=>$actual_rol_proceso->rol_proceso_id])->all();
                    $array_acciones = array_merge($array_acciones,$temporal_array_acciones);

                }
            }
        }
        return $array_acciones;

        // // 

        // $array_acciones = RolProcesoAccion::find()
        //     ->joinWith(['rolProcesos'])
        //     ->joinWith('rolProcesoAccion')
        //     ->where(['rol_proceso.rol_id' => 'rol_usuario.rol_id'])
        //     ->where(['rol_proceso.rol_proceso_id' => 'rol_proceso_accion.rol_proceso_id'])
        //     ->where(['usuario_id' => $this->usuario_id])
        //     ->where(['rol_proceso_accion.rol_proceso_id' => 'rol_proceso.rol_proceso_id'])
        //     ->where(['rol_proceso.permiso' => $url_accion])
            
        //     ->all();
            

        // return $array_acciones;

    }



    public function getPermisosUrl(){
        $array_rol_usuario = RolUsuario::find()->where(['usuario_id' => $this->usuario_id])->all();
        $array_permisos=[];

        foreach ($array_rol_usuario as $actual_rol_usuario) {
            $objeto_rol = Rol::findOne(['rol_id' => $actual_rol_usuario->rol_id]);
            $array_permisos = array_merge($array_permisos, $objeto_rol->getProcesosActualesUrl()); 
        }
        $array_permisos = array_unique($array_permisos);
        return $array_permisos;

    }

    /**
     * [eliminarTodosLosRoles Elimina todos los roles del usuario_id pasado ]
     * @param [rol model] $nuevosRoles, array de modelos
     */
    
    public function findById($id){
        return static::find(['usuario_id'=>$id]);      
    }

    public function getPersona()
    {
        return $this->hasOne(StaffPersona::className(), ['staff_persona_id' => 'persona_id']);
    }

    public function eliminarTodosLosRoles($usuario_id) {
        RolUsuario::deleteAll('usuario_id = '.$this->usuario_id);
    }

    public function getNombre(){
        $persona = $this->getPersona()->one();
        if(isset($persona)){
            return $persona->nombres.' '.$persona->apellido_paterno.' '.$persona->apellido_materno;
        }else{
            return 'sin-nombre';
        }
    }

    /**
     * [AsignarRoles Asigna los ids guardados en el array : $nuevosRoles se han de establecer como los roles para el usuario actual ]
     * @param [rol model] $nuevosRoles, array de modelos
     */
    public function AsignarRoles($nuevosRoles) {
        $this->eliminarTodosLosRoles($this->usuario_id);
        // $objeto_autorization_manager = new AuthorizationManager();
        // $objeto_autorization_manager->borrarTodosLosRoles($this->usuario_id);

        if(!empty($nuevosRoles)){            
            foreach ( $nuevosRoles as $rol ) {
                $RolUsuario = new RolUsuario();
                $Rol = new Rol();
                $Rol = $Rol->findById($rol);
                $RolUsuario->rol_id = $rol;
                $RolUsuario->usuario_id = $this->usuario_id;
                $RolUsuario->save();
                // $objeto_autorization_manager->addRole($this->usuario_id, $Rol->nombre);
            }
            return true;
        }else{
            return false;
        }
    }

    /**
     * Esta función retorna la lista de roles asociados al usuario con ususario_id = $id
     * @param int $id
     * @return rol-model-array
     */
    static function getRoles($id){         
        $array_rol_usuario = RolUsuario::find()->where([ 'usuario_id' => $id ])->all();
        $roles = [];
        foreach ($array_rol_usuario as $actl_rol_usuario) {
            $rolX = $actl_rol_usuario->getRol()->one();
            $roles[] = $rolX;
        }
        return $roles;     
    }


    /**
     * Retorna los mensajes escritos POR "mi"
     * @return [\yii\dv\ActiveQuery] [description]
     */
    public function getMensajesDe()
    {
        return $this->hasMany(Mensaje::className(), ['usuario_id_de' => 'usuario_id']);
    }

    /**
     * Retorna los mensajes escritos PARA "mi"
     * @return [\yii\dv\ActiveQuery] [description]
     */
    public function getMensajesPara()
    {
        return $this->hasMany(Mensaje::className(), ['usuario_id_para' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModulos()
    {
        return $this->hasMany(Modulo::className(), ['actualizado_por' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModulos0()
    {
        return $this->hasMany(Modulo::className(), ['creado_por' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesos()
    {
        return $this->hasMany(Proceso::className(), ['actualizado_por' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesos0()
    {
        return $this->hasMany(Proceso::className(), ['creado_por' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRols()
    {
        return $this->hasMany(Rol::className(), ['actualizado_por' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRols0()
    {
        return $this->hasMany(Rol::className(), ['creado_por' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolProcesos()
    {
        return $this->hasMany(RolProceso::className(), ['actualizado_por' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolProcesos0()
    {
        return $this->hasMany(RolProceso::className(), ['creado_por' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolUsuarios()
    {
        return $this->hasMany(RolUsuario::className(), ['usuario_id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolUsuarios0()
    {
        return $this->hasMany(RolUsuario::className(), ['actualizado_por' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolUsuarios1()
    {
        return $this->hasMany(RolUsuario::className(), ['creado_por' => 'usuario_id']);
    }

    /// Inicio >> funciones requeridas para acceder por Login
    /**
     * este metodo busca una instancia de clase en base al identificador otorgado
     * @param  [type] $id [identificador de entrada]
     * @return [type]     [usuario con el id entregado]
     */
        public static function findIdentity($id){
            return static::findOne(['usuario_id' => $id]);
        }

        public static function findIdentityByAccessToken($token, $type = null)
        {
           return static::findOne(['token_de_acceso' => $token]);
        }

        public static function findByUsername($username)
       {
           return static::findOne(['alias' => $username]);
       }

       public function getId()
       {
           return $this->getPrimaryKey();
       }

       public function getAuthKey()
       {
           return $this->clave_autenticacion;
       }

       public function validateAuthKey($authKey)
       {
           return $this->getAuthKey() === $authKey;
       }

       public function validatePassword($password)
       {
           return Yii::$app->security->validatePassword($password, $this->password_hash);
       }

       /**
        * [setPassword Establece la contraseña encriptandola]
        * @param String $password [description]
        */
       public function setPassword($password)
        {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }

        /**
         * [generateAuthKey Genera la clave de Autenticación de forma aleatorea]
         */
        public function generateAuthKey()
        {
            $this->clave_autenticacion = Yii::$app->security->generateRandomString();
        }

    /// Fin >> funciones requeridas para acceder por Login

    public function getUser() 
    {  
        return static::find()->all();
    }

    /**
     * [checkPasswordComplexity Revisa la complejidad de la contraseña, estableciendo como minimo una longitud y tener al menos una letra y número]
     * @return [Array de String]           [Lista de Errores acumulados, si son 0 la contraseña debe ser aceptada]
     */
    public function checkPasswordComplexity() {
 
        // if (strcmp($this->password_hash, '@@') ){
        //     return ;
        // }

        $password = $this->password_hash;
        $passRept = $this->password_repeat;

        $longitud = 8;
        $password_longitud  = strlen($password);
        $passRept_longitud  = strlen($passRept);

        if ($password_longitud < $longitud && $password_longitud != 0 ) {
            $error = 'La contraseña debe tener una longitud mayor a '.$longitud;
            $this->addError('password_hash',$error);
            return;
        } else {
            if (!preg_match("#[0-9]+#", $password)) {
                $error = 'La contraseña debe tener al menos un número.';
                $this->addError('password_hash',$error);
                return;
            }
            if (!preg_match("#[a-zA-Z]+#", $password)) {
                $error = 'La contraseña debe incluir al menos una letra.';
                $this->addError('password_hash',$error);
                return;
            }
        }
    }

    public function checkPasswordRepeate() {
 
        // if (strcmp($this->password_hash, '@@') ){
        //     return ;
        // }qiJuMtrt

        $password = $this->password_hash;
        $passRept = $this->password_repeat;

        $longitud = 8;
        $password_longitud  = strlen($password);
        $passRept_longitud  = strlen($passRept);
        
        if( ($passRept_longitud != $password_longitud) || (strcmp($password, $passRept) != 0)) {
            $this->addError('password_repeat','Los campos de contraseña no coinciden.');
        }
    }

    /**
     * [checkPasswordViejo Revisa la coincidencia del password cuando es remplazado]
     */
    public function checkPasswordViejo(){
        $password_hash_actual = Usuario::findOne($this->id)->password_hash;
        
        if (strlen($this->password_viejo) > 1 && !Yii::$app->security->validatePassword($this->password_viejo, $password_hash_actual) ){
            $this->addError('password_viejo','La contraseña no coincide con su contraseña actual.');
        }
    }

    /**
     * [beforeSave Función que ha de generar los campos de clave de autenticación y encripta el password]
     * @param  [-] $insert [parametro por defecto]
     * @return [boolean]         [true(sin errores)/false(con errores, no guarda cambios)]
     */
    // public function beforeSave($insert) {
    //         if ($this->isNewRecord) {
    //             /// Se genera un password aleatoreo(Para mostrar luego de ser creado) y se lo guarda codigicado
    //             $this->password_temporal = $this->generateRandomString();
    //             $this->setPassword($this->password_temporal);
    //             /// autogeneración de la clave de autenticación
    //             $this->clave_autenticacion = Yii::$app->security->generateRandomString();
    //         } else {
    //             if (strlen($this->password_hash) != 0) {
    //                 $this->setPassword($this->password_hash);
    //             } else {
    //                 $this->password_hash = Usuario::findOne($this->id)->password_hash;
    //             }
    //         }

    //         if (isset($this->autocomplete_staff_persona)) {
    //             $this->persona_id = StaffPersona::getIdByDniNombre($this->autocomplete_staff_persona);
    //         }

    //         return true;
        
    // }
    public function beforeSave($insert) {
            if ($this->isNewRecord) {
                /// Se genera un password aleatoreo(Para mostrar luego de ser creado) y se lo guarda codigicado
                $this->password_temporal = $this->generateRandomString();
                $this->setPassword($this->password_temporal);
                /// autogeneración de la clave de autenticación
                $this->clave_autenticacion = Yii::$app->security->generateRandomString();
            } else {
                if (strlen($this->password_repeat) != 0) {
                    $this->setPassword($this->password_hash);
                } /* else {
                    $this->password_hash = Usuario::findOne($this->id)->password_hash;
                }// */
            }

            if (isset($this->autocomplete_staff_persona)) {
                $this->persona_id = StaffPersona::getIdByDniNombre($this->autocomplete_staff_persona);
            }

            return true;
        
    }
    /**
     * @return [dictionary] [Retorna los elementos requeridos para formuar el menú de opciones]
     */
    public function getRolMenuItems(){
        $db = Yii::$app->db;
        $sql = 'SELECT 
                    rol.nombre as nombre_rol,
                    modulo.nombre as nombre_modulo, 
                    proceso.descripcion as nombre_proceso, 
                    proceso.url_accion as proceso_url 
                    FROM
                    rol_usuario,
                    rol, rol_proceso,
                    proceso,
                    modulo
                    Where
                    rol_proceso.mostrar_en_arbol = 1 and
                    rol_usuario.rol_id = rol.rol_id and
                    rol.rol_id = rol_proceso.rol_id and
                    rol_proceso.proceso_id = proceso.proceso_id and
                    proceso.modulo_id = modulo.modulo_id and
                    rol_usuario.usuario_id = '. $this->id .' ORDER BY rol.nombre, modulo.nombre';

        $queryItems = $db->createCommand($sql)->queryAll();
        $count = count($queryItems);

        if ( $count < 1 ){
          return [];
        }

        $menuItems  = [];
        $rootUrl        = Url::base();

        foreach ($queryItems as $actlItem) {
            $actlRol     = $actlItem['nombre_rol'];
            $actlModule  = $actlItem['nombre_modulo'];
            $actlProcess = $actlItem['nombre_proceso'];
            $actlUrl     = $actlItem['proceso_url'];

            /// si no existe el rol actual, se agrega al árbol
            if(! isset($menuItems[$actlRol]) ) {
                $menuItems[$actlRol] = [];
            }

            /// si no existe el modulo actual, se agrega al árbol
            if(! isset($menuItems[$actlRol][$actlModule]) ) {
                $menuItems[$actlRol][$actlModule] = [];
            }

            $menuItems[$actlRol][$actlModule][$actlProcess] = $actlUrl;
        }

        $menuOptions = [];
        foreach ($menuItems as $actlRol_key => $actlRol_items) {
            //echo "rol: " . $actlRol_key.'<p>';
            $menuModules = [];
            foreach ($actlRol_items as $actlModule_key => $actlModule_items) {
                //echo "   modulo: " . $actlModule_key. "<p>";
                $menuProces = [];
                foreach ($actlModule_items as $processName => $processUrl) {
                    $menuProces[] = ['label' => $processName, 'url' => $rootUrl.'/'.$processUrl];
                    //echo " process :" . $processName. "<p>";
                }
                $menuModules[] = ['label' => $actlModule_key, 'url' => '#' , 'items' => $menuProces];
            }
            $menuOptions[] = ['label' => $actlRol_key, 'url' => '#', 'items' => $menuModules];
        }

        return $menuOptions;
    }

    /**
     * [generateRandomString Genera una cadena de caracteres aleatorea]
     * @param  integer $length [longitud de la cadena aleatorea]
     * @return [string]          [random string]
     */
    public function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
        //return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
    }


    
}
