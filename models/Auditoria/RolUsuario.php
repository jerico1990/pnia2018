<?php

namespace app\models\Auditoria;

use Yii;

/**
 * This is the model class for table "rol_usuario".
 *
 * @property int $rol_usuario_id
 * @property int $usuario_id
 * @property int $rol_id
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Rol $rol
 * @property Usuario $usuario
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class RolUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rol_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'rol_id'], 'required'],
            [['usuario_id', 'rol_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['rol_id' => 'rol_id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'usuario_id']],
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
            'rol_usuario_id' => 'Rol Usuario ID',
            'usuario_id' => 'Usuario ID',
            'rol_id' => 'Rol ID',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolProcesos()
    {
        return $this->hasMany(RolProceso::className(), ['rol_id' => 'rol_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolProcesoAccion()
    {
    //     $array_rol_proceso = RolProceso::find()->where(['rol_id'=>$this->rol_id])->all();
    //     $array = [];
    //     foreach ($array_rol_proceso as $actual_rol_proceso) {
    //         $temporal_array = RolProcesoAccion::find()->where(['rol_proceso_id'=>$actual_rol_proceso->rol_proceso_id])->all();
    //         $array = array_merge($array,$temporal_array);
    //     }
    //     return $array;
        return $this->hasMany(RolProcesoAccion::className(),['rol_proceso_id' => 'rol_proceso.rol_proceso_id']);
    }

    public function getRoles()
    {
        return $this->find(Rol::className(), ['rol_id' => 'rol_id'])->all();
    }

    public function getListaRoles($roles)
    {
        if ($roles)
            return $roles->getRoles();
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
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'usuario_id']);
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
