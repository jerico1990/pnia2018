<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "meta".
 *
 * @property int $meta_id
 * @property string $meta_descripcion
 * @property bool $tipo
 * @property double $avance_total
 * @property double $avance_actual
 * @property int $unidad_medida_id
 * @property double $precio_unitario
 * @property double $monto_total
 * @property bool $presupuesto_afectado
 * @property int $estado_regitro
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property UnidadMedida $unidadMedida
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property PresupuestoCabecera[] $presupuestoCabeceras
 * @property PresupuestoCabecera[] $presupuestoCabeceras0
 */
class Meta extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'presupuesto_afectado'], 'boolean'],
            [['avance_total', 'avance_actual', 'precio_unitario', 'monto_total'], 'number'],
            [['unidad_medida_id'], 'required'],
            [['unidad_medida_id', 'estado_regitro', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['unidad_medida_id', 'estado_regitro', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['meta_descripcion'], 'string', 'max' => 255],
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
            'meta_id' => 'Meta ID',
            'meta_descripcion' => 'Descripción',
            'tipo' => 'Tipo de Meta',
            'avance_total' => 'Avance Total',
            'avance_actual' => 'Avance Actual',
            'unidad_medida_id' => 'Unidad Medida ID',
            'precio_unitario' => 'Precio por Unidad de Medida',
            'monto_total' => 'Monto Total',
            'presupuesto_afectado' => 'Presupuesto Afectado',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoCabeceras()
    {
        return $this->hasMany(PresupuestoCabecera::className(), ['meta_fisica_id' => 'meta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoCabeceras0()
    {
        return $this->hasMany(PresupuestoCabecera::className(), ['meta_financiera_id' => 'meta_id']);
    }

    static function getComboBoxItems(){
        return ArrayHelper::map(Meta::find()->all(),'meta_id','meta_descripcion');
    }
}
