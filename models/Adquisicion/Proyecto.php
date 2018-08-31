<?php

namespace app\models\Adquisicion;

use app\models\Auditoria\Usuario;

use Yii;

/**
 * This is the model class for table "proyecto".
 *
 * @property int $proyecto_id
 * @property string $nombre
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property LogisticaProceso[] $logisticaProcesos
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class Proyecto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proyecto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actualizado_en', 'creado_en'], 'safe'],
            [['actualizado_por', 'creado_por'], 'required'],
            [['actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['actualizado_por', 'creado_por'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'proyecto_id' => Yii::t('app', 'Proyecto ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogisticaProcesos()
    {
        return $this->hasMany(LogisticaProceso::className(), ['proyecto_id' => 'proyecto_id']);
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
}
