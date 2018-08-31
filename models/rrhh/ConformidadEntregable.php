<?php

namespace app\models\rrhh;
use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use app\models\Presupuesto\PresupuestoCabecera;
use app\models\Viatico\FlujoRequerimiento;
use app\models\Adquisicion\Adquisicion;
use app\models\Patrimonio\Metacodigo;
use \yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "conformidad_entregable".
 *
 * @property int $conformidad_entregable_id
 * @property int $contrato_entregable_id
 * @property int $staff_area_id
 * @property int $flag_conformidad
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ContratoEntregable $contratoEntregable
 * @property StaffPersona $staffPersona
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class ConformidadEntregable extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conformidad_entregable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contrato_entregable_id', 'staff_area_id'], 'required'],
            [['contrato_entregable_id', 'staff_area_id', 'flag_conformidad', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['contrato_entregable_id', 'staff_area_id', 'flag_conformidad', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['contrato_entregable_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContratoEntregable::className(), 'targetAttribute' => ['contrato_entregable_id' => 'contrato_entregable_id']],
            [['staff_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffArea::className(), 'targetAttribute' => ['staff_area_id' => 'staff_area_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            ['observacion', 'string'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'conformidad_entregable_id' => 'Conformidad Entregable ID',
            'contrato_entregable_id' => 'Contrato Entregable ID',
            'staff_area_id' => 'Staff área',
            'flag_conformidad' => 'Conformidad',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    static function getComboBoxListConformidad(){
        $items = Metacodigo::find()->where([ 'nombre_lista' => 'Tipo_conformidad' ])
                ->andFilterWhere(['!=', 'descripcion', 'Sin conformidad'])
                ->all();
        return ArrayHelper::map($items, 'metacodigo_id', 'descripcion');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlagConformidad()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'flag_conformidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratoEntregable()
    {
        return $this->hasOne(ContratoEntregable::className(), ['contrato_entregable_id' => 'contrato_entregable_id']);
    }

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
                $this->flag_conformidad==0;
                $this->creado_por = Yii::$app->user->identity->usuario_id;
                $this->creado_en = date('Y-m-d H:i:s');
                $objeto_metacodigo = Metacodigo::find()->where(['nombre_lista'=>'Tipo_conformidad','descripcion'=>'Sin conformidad'])->one();
                $this->flag_conformidad = $objeto_metacodigo->metacodigo_id;

            }
            $objeto_contrato_entregable = new ContratoEntregable();
            $objeto_contrato_entregable = $objeto_contrato_entregable->find()->where(['contrato_entregable_id'=>$this->contrato_entregable_id])->one();
            $objeto_metacodigo = Metacodigo::find()->where(['nombre_lista'=>'Tipo_conformidad','descripcion'=>'Conforme'])->one();
            if($this->flag_conformidad==$objeto_metacodigo->metacodigo_id){
                $objeto_contrato_entregable->flag_conformidad = 1;
                $objeto_contrato_entregable->save();
                
                $objeto_contrato_contrato = new ContratoContrato();
                $objeto_contrato_contrato = $objeto_contrato_contrato->find()->where(['contrato_contrato_id'=>$objeto_contrato_entregable->codigo_contrato])->one();
                if($objeto_contrato_contrato){
                    $objeto_adquisicion = Adquisicion::find()->where(['adquisicion_id'=>$objeto_contrato_contrato->adquisicion_id])->one();
                    if($objeto_adquisicion){
                        $objeto_flujo_requerimiento = FlujoRequerimiento::find()->where(['flujo_requerimiento_id'=>$objeto_adquisicion->flujo_requerimiento_id])->one();
                        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($objeto_flujo_requerimiento->codigo_arbol);

                        if($objeto_flujo_requerimiento->ro_rooc==1){
                            $objeto_presupuesto_cabecera->moverMontos($objeto_contrato_entregable->periodo_id,'presupuesto_compromiso_ro','presupuesto_ejecutado_ro',$objeto_contrato_entregable->monto);
                            $objeto_adquisicion->monto_ejecutado=$objeto_adquisicion->monto_ejecutado+$objeto_contrato_entregable->monto;
                        }
                        if($objeto_flujo_requerimiento->ro_rooc==0){
                            $objeto_presupuesto_cabecera->moverMontos($objeto_contrato_entregable->periodo_id,'presupuesto_compromiso_rooc','presupuesto_ejecutado_rooc',$objeto_contrato_entregable->monto);

                            $objeto_adquisicion->monto_ejecutado=$objeto_adquisicion->monto_ejecutado+$objeto_contrato_entregable->monto;
                        }
                    }
                    else{
                        $objeto_presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink($objeto_contrato_contrato->codigo_arbol);
                        $objeto_presupuesto_cabecera->crearRequerimiento($objeto_contrato_entregable->periodo_id, $objeto_contrato_entregable->monto,'presupuesto_ejecutado_ro');
                    }
                }
            }
            else{
                $objeto_contrato_entregable->flag_conformidad = 0;
                $objeto_contrato_entregable->save();
            }

            return true;
        }
        return false;
    }
}
