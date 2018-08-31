<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "unidad_medida".
 *
 * @property int $unidad_medida_id
 * @property string $unidad_medida_descripcion
 * @property int $estado_regitro
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Meta[] $metas
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class UnidadMedida extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unidad_medida';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado_regitro', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['estado_regitro', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['unidad_medida_descripcion'], 'string', 'max' => 255],
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
            'unidad_medida_id' => 'Unidad Medida ID',
            'unidad_medida_descripcion' => 'Unidad Medida Descripcion',
            'estado_regitro' => 'Estado Regitro',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetas()
    {
        return $this->hasMany(Meta::className(), ['unidad_medida_id' => 'unidad_medida_id']);
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

    static function getComboBoxItems(){
        return ArrayHelper::map(UnidadMedida::find()->all(),'unidad_medida_id','unidad_medida_descripcion');
    }
}
