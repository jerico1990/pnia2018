<?php

namespace app\models\Auditoria;

use app\models\Auditoria\RolProceso;
use app\models\Auditoria\Proceso;
use app\models\Auditoria\AuthorizationManager;
use app\models\Auditoria\RolProcesoAccion;
use Yii;

/**
 * This is the model class for table "rol".
 *
 * @property int $rol_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property RolProceso[] $rolProcesos
 * @property RolUsuario[] $rolUsuarios
 */
class Rol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['actualizado_por', 'creado_por'], 'integer'],
            [['nombre', 'descripcion'], 'string', 'max' => 255],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rol_id' => 'Rol ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }
    public function getRolProcesoAccion(){
        $array_asignable_sesion = [];

        $array_rol_proceso = RolProceso::find()->where(['rol_id'=>$this->rol_id])->all();
        foreach ($array_rol_proceso as $actual_rol_proceso) {
            $array_acciones = RolProcesoAccion::find()->where(
                [
                    'rol_proceso_id'=>$actual_rol_proceso->rol_proceso_id
                ])->all();

            $temporal_array = [];
            foreach ($array_acciones as $actual_accion) {
                $cadena = $actual_accion->accion."_".$actual_rol_proceso->proceso_id;
                $temporal_array[$cadena] = $cadena;
            }
            

            $array_asignable_sesion[$actual_rol_proceso->proceso_id] = $temporal_array;
        }
        return $array_asignable_sesion;
    }

    public function getProcesosActuales(){
        $array_rol_proceso = RolProceso::find()->where(['rol_id' => $this->rol_id])->all();
        return $array_rol_proceso;
    }

    public function getProcesosActualesUrl(){
        $array_rol_proceso = RolProceso::find()->where(['rol_id' => $this->rol_id])->all();
        $array_procesos_urls = [];

        foreach ($array_rol_proceso as $actual_rol_proceso) {
            $objeto_proceso = Proceso::findOne(['proceso_id' => $actual_rol_proceso->proceso_id]);
            array_push($array_procesos_urls,$objeto_proceso->url_accion);     
        }

        return $array_procesos_urls;
    }


    public function AsignarProcesos($valores_seleccionados) {
        $array_rol_proceso = RolProceso::find()->where(['rol_id' => $this->rol_id])->all();
        foreach ($array_rol_proceso as $actual_rol_proceso) {
            RolProcesoAccion::deleteAll('rol_proceso_id ='.$actual_rol_proceso->rol_proceso_id);
        }

        RolProceso::deleteAll('rol_id = '.$this->rol_id);

        if(!empty($valores_seleccionados)){           
            foreach( $valores_seleccionados as $key => $value ){
                $temporal_proceso = new Proceso();
                $temporal_proceso = $temporal_proceso->findById($key);
                $nuevo_rol_proceso = new RolProceso();
                $nuevo_rol_proceso->proceso_id = $key;
                $nuevo_rol_proceso->rol_id = $this->rol_id;

                $url_accion = $temporal_proceso->url_accion;

                $nuevo_rol_proceso->permiso = $url_accion;
                $nuevo_rol_proceso->descripcion = $temporal_proceso->descripcion;

                foreach ($value as $identificador => $valor) {
                    $crear = strpos($identificador,"crear");
                    $ver = strpos($identificador,"ver");
                    $actualizar = strpos($identificador,"actualizar");
                    $eliminar = strpos($identificador,"eliminar");
                    
                    $objeto_rol_proceso_accion = new RolProcesoAccion();
                    if(strpos($valor, 'create') !== false){
                        $nuevo_rol_proceso->save();
                        $objeto_rol_proceso_accion->rol_proceso_id = $nuevo_rol_proceso->rol_proceso_id;
                        $objeto_rol_proceso_accion->accion = "create";
                        $objeto_rol_proceso_accion->save();

                        $objeto_rol_proceso_index = new RolProcesoAccion();
                        $objeto_rol_proceso_index->rol_proceso_id = $nuevo_rol_proceso->rol_proceso_id;
                        $objeto_rol_proceso_index->accion = "index";
                        $objeto_rol_proceso_index->save();
                    }
                    if(strpos($valor, 'view') !== false){
                        $nuevo_rol_proceso->save();
                        $objeto_rol_proceso_accion->rol_proceso_id = $nuevo_rol_proceso->rol_proceso_id;
                        $objeto_rol_proceso_accion->accion = "view";
                        $objeto_rol_proceso_accion->save();

                        $objeto_rol_proceso_index = new RolProcesoAccion();
                        $objeto_rol_proceso_index->rol_proceso_id = $nuevo_rol_proceso->rol_proceso_id;
                        $objeto_rol_proceso_index->accion = "index";
                        $objeto_rol_proceso_index->save();
                    }
                    if(strpos($valor, 'update') !== false){
                        $nuevo_rol_proceso->save();
                        $objeto_rol_proceso_accion->rol_proceso_id = $nuevo_rol_proceso->rol_proceso_id;
                        $objeto_rol_proceso_accion->accion = "update";
                        $objeto_rol_proceso_accion->save();

                        $objeto_rol_proceso_index = new RolProcesoAccion();
                        $objeto_rol_proceso_index->rol_proceso_id = $nuevo_rol_proceso->rol_proceso_id;
                        $objeto_rol_proceso_index->accion = "index";
                        $objeto_rol_proceso_index->save();
                    }
                    if(strpos($valor, 'delete') !== false){
                        $nuevo_rol_proceso->save();
                        $objeto_rol_proceso_accion->rol_proceso_id = $nuevo_rol_proceso->rol_proceso_id;
                        $objeto_rol_proceso_accion->accion = "delete";
                        $objeto_rol_proceso_accion->save();

                        $objeto_rol_proceso_index = new RolProcesoAccion();
                        $objeto_rol_proceso_index->rol_proceso_id = $nuevo_rol_proceso->rol_proceso_id;
                        $objeto_rol_proceso_index->accion = "index";
                        $objeto_rol_proceso_index->save();
                    }
                }

            }
            // $objeto_autorization_manager->initializeAuthorizations();
            return true;
        }
        else{
            // $objeto_autorization_manager->initializeAuthorizations();
            return false;
        }
        // */
    }

    // public function AsignarProcesos($valores_seleccionados) {
    //     RolProceso::deleteAll('rol_id = '.$this->rol_id);
    //     // $objeto_autorization_manager = new AuthorizationManager();
    //     // $objeto_autorization_manager->removeAllPermissions();
    //     if(!empty($valores_seleccionados)){           
    //         foreach( $valores_seleccionados as $actual_proceso ){
    //             $temporal_proceso = new Proceso();
    //             $temporal_proceso = $temporal_proceso->findById($actual_proceso);
    //             $nuevo_rol_proceso = new RolProceso();
    //             $nuevo_rol_proceso->proceso_id = $actual_proceso;
    //             $nuevo_rol_proceso->rol_id = $this->rol_id;
    //             $url_accion = $temporal_proceso->url_accion;
    //             $nuevo_rol_proceso->permiso = $url_accion;
    //             $nuevo_rol_proceso->descripcion = $temporal_proceso->descripcion;
    //             $nuevo_rol_proceso->save();

    //         }
    //         // $objeto_autorization_manager->initializeAuthorizations();
    //         return true;
    //     }
    //     else{
    //         // $objeto_autorization_manager->initializeAuthorizations();
    //         return false;
    //     }
    //     // */
    // }

    /**
     * Esta función retorna la lista de procesos asociados al usuario con rol_id = $id
     * @param int $id
     * @return rol-model-array
     */
    static function getProcesosYAcciones($id){         
        $array_rol_proceso = RolProceso::find()->where([ 'rol_id' => $id ])->all();
        $array_procesos = [];
        foreach ($array_rol_proceso as $actual_rol_proceso) {
            $nuevo_proceso = $actual_rol_proceso->getProceso()->one();
            $array_procesos[] = $nuevo_proceso;
        }
        return $array_procesos;     
    }


    /**
     * Esta función retorna la lista de procesos asociados al usuario con rol_id = $id
     * @param int $id
     * @return rol-model-array
     */
    static function getProcesos($id){         
        $array_rol_proceso = RolProceso::find()->where([ 'rol_id' => $id ])->all();
        $array_procesos = [];
        foreach ($array_rol_proceso as $actual_rol_proceso) {
            $nuevo_proceso = $actual_rol_proceso->getProceso()->one();
            $array_procesos[] = $nuevo_proceso;
        }
        return $array_procesos;     
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor()
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'actualizado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor()
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolProcesos()
    {
        return $this->hasMany(RolProceso::className(), ['rol_id' => 'rol_id']);
    }

    public function findById($id){
        return static::findOne(['rol_id' => $id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolUsuarios()
    {
        return $this->hasMany(RolUsuario::className(), ['rol_id' => 'rol_id']);
    }
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
             if(!Yii::$app->user->isGuest)
             {
                 $this->actualizado_por= Yii::$app->user->identity->usuario_id;
             }
             else
             {
                 return false;
             }
            $this->actualizado_en = date('Y-m-d H:i:s');
            if ($this->isNewRecord) {
                $this->creado_por = Yii::$app->user->identity->usuario_id;
                $this->creado_en = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }
}
