<?php

namespace app\models\Auditoria;

use Yii;

/**
 * This is the model class for table "Accion".
 *
 * @property int $accion_id
 * @property string $descripcion
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 */
class RolProcesoAccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rol_proceso_accion';
    }

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'rol_proceso_accion_id' => 'Rol Proceso Accion id',
            'rol_proceso_id' => 'Rol proceso id',
            'accion' => 'Accion id',
            
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    public function getRolProcesos()
    {
        return $this->hasMany(RolProceso::className(), ['rol_proceso_id' => 'rol_proceso_id']);
    }

    public function findById($id){
        return static::findOne(['rol_proceso_accion_id' => $id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolProceso()
    {
        return $this->hasOne(RolProceso::className(), ['rol_proceso_id' => 'rol_proceso_id']);
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
