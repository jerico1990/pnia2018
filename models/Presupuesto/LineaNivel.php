<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "linea_nivel".
 *
 * @property int $linea_nivel_id
 * @property int $linea_id
 * @property string $nombre_linea
 * @property string $numeracion
 * @property int $nivel
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Linea $linea
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property PresupuestoCabecera[] $presupuestoCabeceras
 */
class LineaNivel extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linea_nivel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['linea_id', 'nivel'], 'required'],
            [['linea_id', 'nivel', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['linea_id', 'nivel', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['nombre_linea','numeracion'], 'string', 'max' => 255],
            [['linea_id'], 'exist', 'skipOnError' => true, 'targetClass' => Linea::className(), 'targetAttribute' => ['linea_id' => 'linea_id']],
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
            'linea_nivel_id' => 'Linea Nivel ID',
            'linea_id' => 'Linea ID',
            'nombre_linea' => 'Nombre Linea',
            'numeracion' => 'Numeración Interna',
            'nivel' => 'Nivel',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinea()
    {
        return $this->hasOne(Linea::className(), ['linea_id' => 'linea_id']);
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
    public function getPresupuestoCabeceras()
    {
        return $this->hasMany(PresupuestoCabecera::className(), ['linea_nivel_id' => 'linea_nivel_id']);
    }

}
