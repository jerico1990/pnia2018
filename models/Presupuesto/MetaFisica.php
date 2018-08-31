<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "meta_fisica".
 *
 * @property int $meta_fisica_id
 * @property string $descripcion
 * @property double $avance_total
 * @property double $avance_actual
 * @property int $unidad_medida_id
 * @property int $presupuesto_cabecera_id
 * @property int $estado_regitro
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property PresupuestoCabecera $presupuestoCabecera
 * @property UnidadMedida $unidadMedida
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class MetaFisica extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meta_fisica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['avance_total', 'avance_actual'], 'number'],
            [['unidad_medida_id', 'presupuesto_cabecera_id'], 'required'],
            [['unidad_medida_id', 'presupuesto_cabecera_id', 'estado_regitro', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['unidad_medida_id', 'presupuesto_cabecera_id', 'estado_regitro', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['descripcion'], 'string', 'max' => 255],
            [['presupuesto_cabecera_id'], 'exist', 'skipOnError' => true, 'targetClass' => PresupuestoCabecera::className(), 'targetAttribute' => ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']],
            [['unidad_medida_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnidadMedida::className(), 'targetAttribute' => ['unidad_medida_id' => 'unidad_medida_id']],
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
            'meta_fisica_id' => 'Meta Fisica ID',
            'descripcion' => 'Descripcion',
            'avance_total' => 'Avance Total',
            'avance_actual' => 'Avance Actual',
            'unidad_medida_id' => 'Unidad Medida ID',
            'presupuesto_cabecera_id' => 'Presupuesto Cabecera ID',
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
    public function getPresupuestoCabecera()
    {
        return $this->hasOne(PresupuestoCabecera::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidadMedida()
    {
        return $this->hasOne(UnidadMedida::className(), ['unidad_medida_id' => 'unidad_medida_id']);
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
