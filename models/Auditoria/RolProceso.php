<?php

namespace app\models\Auditoria;

use Yii;

/**
 * This is the model class for table "rol_proceso".
 *
 * @property int $rol_proceso_id
 * @property int $rol_id
 * @property int $proceso_id
 * @property string $permiso
 * @property string $descripcion
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Proceso $proceso
 * @property Rol $rol
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class RolProceso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    var $lista = []; 
    public static function tableName()
    {
        return 'rol_proceso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rol_id', 'proceso_id', 'descripcion'], 'required'],
            [['rol_id', 'proceso_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['permiso', 'descripcion'], 'string', 'max' => 100],
            [['proceso_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proceso::className(), 'targetAttribute' => ['proceso_id' => 'proceso_id']],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['rol_id' => 'rol_id']],
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
            'rol_proceso_id' => 'Rol Proceso ID',
            'rol_id' => 'Rol ID',
            'proceso_id' => 'Proceso ID',
            'permiso' => 'Permiso',
            'descripcion' => 'Descripcion',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    public function getRolProcesoAccion()
    {
        return $this->hasMany(RolProcesoAccion::className(),['rol_proceso_id' => 'rol_proceso_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolUsuarios()
    {
        return $this->hasMany(RolUsuario::className(), ['rol_id' => 'rol_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProceso()
    {
        return $this->hasOne(Proceso::className(), ['proceso_id' => 'proceso_id']);
        
    }

    public function getProcesos()
    {
        //return $this->hasMany(Proceso::className(), ['proceso_id' => 'proceso_id']);
        return $this->find(Proceso::className(), ['proceso_id' => 'proceso_id'])->all();
    }
    
    
    public function getListaProcesos($procesos)
    {
        if ($procesos)
            return $procesos->getProcesos();
        else
            return NULL;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['rol_id' => 'rol_id']);
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
    
    public function getListaDeRolesYPermisos()
    {
        $array_todos_rol_proceso = RolProceso::find()->all();
        $array_arrays_de_roles_y_permisos = [];
        $respuesta_ordenada = array();
        
        foreach($array_todos_rol_proceso as $actual_rol_proceso)
        {
            $nombre_rol = '';
            $nombre_rol = $actual_rol_proceso->rol['nombre'];
            $roles = [ $actual_rol_proceso->rol['nombre'] =>  array() ]; 
            foreach($array_todos_rol_proceso as $actual_rol_proceso_anidado)
            {
                if ($actual_rol_proceso['rol_id'] === $actual_rol_proceso_anidado['rol_id'])
                {                     
                    array_push($roles[$actual_rol_proceso->rol['nombre']], $actual_rol_proceso_anidado['permiso']);
                }          
            }
            array_push($array_arrays_de_roles_y_permisos, $roles);    
        }

        foreach($array_arrays_de_roles_y_permisos as $actual_array_rol_y_permisos)
        {
            $respuesta_ordenada += $actual_array_rol_y_permisos;      
        }
        array_merge($respuesta_ordenada, $array_arrays_de_roles_y_permisos);
        
        return $respuesta_ordenada;
    }
    public function getListaDePermisos()
    {
        //funcion para probar traer los permisos, devuelve un array de permisos, todos los registros en RolProceso
        $array_rol_procesos = RolProceso::find()->all();
        
        //muestra un array de permisos perfecto como el permissions2, pero dinamico
        $array_arrays_de_permisos = [];
        $respuesta_ordenada = [];
        foreach($array_rol_procesos as $actual_rol_proceso)
        {
           
           $permiso_nuevo = [
               $actual_rol_proceso['permiso'] => ['desc' => $actual_rol_proceso['descripcion']]
               
           ];
           array_push($array_arrays_de_permisos, $permiso_nuevo);
        }
        
        foreach ($array_arrays_de_permisos as $array_actual_de_permiso)
        {
            $respuesta_ordenada += $array_actual_de_permiso;      
        }
        return $respuesta_ordenada;
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
