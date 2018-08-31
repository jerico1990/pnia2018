<?php

namespace app\models\General;
use app\models\Auditoria\Usuario;
use app\models\Viatico\FlujoRequerimiento;
use app\models\rrhh\StaffArea;
use app\models\rrhh\StaffPersona;
use app\models\Viatico\ArbolArea;
use app\models\Patrimonio\Metacodigo;
use app\models\Utilitario\UtilitarioUbigeo;

use Yii;

/**
 * This is the model class for table "requerimiento_detalle".
 *
 * @property int $requerimiento_detalle_id
 * @property int $codigo_arbol
 * @property int $periodo_id
 * @property double $monto
 * @property int $ro_rooc
 * @property int $entregable_id
 * @property int $penalidad_id
 * @property int $flujo_requerimiento_id
 * @property int $cantidad
 * @property string $unidad_medida_cantidad
 * @property int $costo_unitario
 * @property int $staff_area_id
 * @property string $bien_servicio
 * @property string $descripcion_bien_servicio
 * @property string $especificacion_tecnica_o_tdr
 * @property int $tiempo_garantia_numero_meses
 * @property string $lugar_entrega
 * @property int $forma_pago
 * @property int $duracion_servicio
 * @property double $monto_total_contrato_fake
 * @property int $staff_persona_id
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property FlujoRequerimiento $flujoRequerimiento
 * @property Metacodigo $formaPago
 * @property StaffArea $staffArea
 * @property StaffPersona $staffPersona
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property UtilitarioUbigeo $lugarEntrega
 */
class RequerimientoDetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requerimiento_detalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_arbol', 'periodo_id', 'ro_rooc', 'entregable_id', 'penalidad_id', 'flujo_requerimiento_id', 'cantidad', 'costo_unitario', 'staff_area_id', 'tiempo_garantia_numero_meses', 'forma_pago', 'duracion_servicio', 'staff_persona_id', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['codigo_arbol', 'periodo_id', 'ro_rooc', 'entregable_id', 'penalidad_id', 'flujo_requerimiento_id', 'cantidad', 'costo_unitario', 'staff_area_id', 'tiempo_garantia_numero_meses', 'duracion_servicio', 'staff_persona_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['monto', 'monto_total_contrato_fake'], 'number'],
            [['staff_area_id', 'bien_servicio', 'forma_pago'], 'required'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['unidad_medida_cantidad', 'bien_servicio', 'descripcion_bien_servicio', 'especificacion_tecnica_o_tdr', 'lugar_entrega'], 'string', 'max' => 255],
            [['flujo_requerimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => FlujoRequerimiento::className(), 'targetAttribute' => ['flujo_requerimiento_id' => 'flujo_requerimiento_id']],
//            [['forma_pago'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['forma_pago' => 'metacodigo_id']],
            [['staff_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffArea::className(), 'targetAttribute' => ['staff_area_id' => 'staff_area_id']],
            [['staff_persona_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffPersona::className(), 'targetAttribute' => ['staff_persona_id' => 'staff_persona_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['lugar_entrega'], 'exist', 'skipOnError' => true, 'targetClass' => UtilitarioUbigeo::className(), 'targetAttribute' => ['lugar_entrega' => 'utilitario_ubigeo_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'requerimiento_detalle_id' => Yii::t('app', 'Requerimiento Detalle ID'),
            'codigo_arbol' => Yii::t('app', 'Codigo Arbol'),
            'periodo_id' => Yii::t('app', 'Periodo ID'),
            'monto' => Yii::t('app', 'Monto'),
            'ro_rooc' => Yii::t('app', 'Ro Rooc'),
            'entregable_id' => Yii::t('app', 'Entregable ID'),
            'penalidad_id' => Yii::t('app', 'Penalidad ID'),
            'flujo_requerimiento_id' => Yii::t('app', 'Flujo Requerimiento ID'),
            'cantidad' => Yii::t('app', 'Cantidad'),
            'unidad_medida_cantidad' => Yii::t('app', 'Unidad Medida Cantidad'),
            'costo_unitario' => Yii::t('app', 'Costo Unitario'),
            'staff_area_id' => Yii::t('app', 'Staff Area ID'),
            'bien_servicio' => Yii::t('app', 'Bien Servicio'),
            'descripcion_bien_servicio' => Yii::t('app', 'Descripcion Bien Servicio'),
            'especificacion_tecnica_o_tdr' => Yii::t('app', 'Especificacion Tecnica O Tdr'),
            'tiempo_garantia_numero_meses' => Yii::t('app', 'Tiempo Garantia Numero Meses'),
            'lugar_entrega' => Yii::t('app', 'Lugar Entrega'),
            'forma_pago' => Yii::t('app', 'Forma Pago'),
            'duracion_servicio' => Yii::t('app', 'Duracion Servicio'),
            'monto_total_contrato_fake' => Yii::t('app', 'Monto Total Contrato Fake'),
            'staff_persona_id' => Yii::t('app', 'Staff Persona ID'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlujoRequerimiento()
    {
        return $this->hasOne(FlujoRequerimiento::className(), ['flujo_requerimiento_id' => 'flujo_requerimiento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getFormaPago()
//    {
//        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'forma_pago']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffArea()
    {
        return $this->hasOne(StaffArea::className(), ['staff_area_id' => 'staff_area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffPersona()
    {
        return $this->hasOne(StaffPersona::className(), ['staff_persona_id' => 'staff_persona_id']);
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
    public function getLugarEntrega()
    {
        return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'lugar_entrega']);
    }
}
