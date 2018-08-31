<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "meta_financiera".
 *
 * @property int $meta_financiera_id
 * @property string $descripcion
 * @property double $avance_total
 * @property double $avance_actual
 * @property int $unidad_medida_id
 * @property double $precio_unitario_ro
 * @property double $precio_unitario_rooc
 * @property double $monto_total_ro
 * @property double $monto_total_rooc
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
class MetaFinanciera extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meta_financiera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['avance_total', 'avance_actual', 'precio_unitario_ro', 'precio_unitario_rooc', 'monto_total_ro', 'monto_total_rooc'], 'number'],
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
            'meta_financiera_id' => 'Meta Financiera ID',
            'descripcion' => 'Descripcion',
            'avance_total' => 'Avance Total',
            'avance_actual' => 'Avance Actual',
            'unidad_medida_id' => 'Unidad Medida ID',
            'precio_unitario_ro' => 'Precio Unitario Ro',
            'precio_unitario_rooc' => 'Precio Unitario Rooc',
            'monto_total_ro' => 'Monto Total Ro',
            'monto_total_rooc' => 'Monto Total Rooc',
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
