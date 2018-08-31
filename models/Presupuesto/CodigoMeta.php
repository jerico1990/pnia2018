<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "codigo_meta".
 *
 * @property int $codigo_meta_id
 * @property string $descripcion
 * @property int $unidad_medida_id
 * @property int $estado_regitro
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property PresupuestoCabecera[] $presupuestoCabeceras
 */
class CodigoMeta extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'codigo_meta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unidad_medida_id'], 'required'],
            [['unidad_medida_id', 'estado_regitro', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['unidad_medida_id', 'estado_regitro', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['descripcion'], 'string', 'max' => 255],
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
            'codigo_meta_id' => 'Codigo Meta ID',
            'descripcion' => 'Descripción',
            'unidad_medida_id' => 'Unidad Medida',
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
        return $this->hasMany(PresupuestoCabecera::className(), ['codigo_meta_id' => 'codigo_meta_id']);
    }

    static function getComboBoxItems(){
        return ArrayHelper::map(CodigoMeta::find()->all(),'codigo_meta_id','descripcion');
    }
}
