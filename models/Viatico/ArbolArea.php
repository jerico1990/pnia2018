<?php

namespace app\models\Viatico;
use app\models\rrhh\StaffArea;
use app\models\Auditoria\Usuario;
use app\models\Presupuesto\PresupuestoCabecera;
use app\models\ModeloGenerico;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "arbol_area".
 *
 * @property int $arbol_area_id
 * @property int $staff_area_id
 * @property int presupuesto_cabecera_id
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property StaffArea $staffArea
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class ArbolArea extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arbol_area';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_area_id', 'presupuesto_cabecera_id'], 'required'],
            [['staff_area_id', 'presupuesto_cabecera_id'], 'default', 'value' => null],
            [['staff_area_id', 'presupuesto_cabecera_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['presupuesto_cabecera_id'], 'exist', 'skipOnError' => true, 'targetClass' => PresupuestoCabecera::className(), 'targetAttribute' => ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']],
            [['staff_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffArea::className(), 'targetAttribute' => ['staff_area_id' => 'staff_area_id']],
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
            'arbol_area_id' => Yii::t('app', 'Arbol Area ID'),
            'staff_area_id' => Yii::t('app', 'Staff Area ID'),
            'presupuesto_cabecera_id' => Yii::t('app', 'Cabecera Presupuesto'),
            'presupuesto_cabecera_nombre' => Yii::t('app', 'Nombre Presupuesto Cabecera'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    static function getComboBoxItemsArea($staff_area_id){
        $items  = ArbolArea::find()->where(['staff_area_id' => $staff_area_id])->all();
        return ArrayHelper::map($items, 'presupuesto_cabecera_id', 'presupuesto_cabecera_nombre');
    }
    
    public function getCabeceraPresupuesto()
    {
        return $this->hasOne(PresupuestoCabecera::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']);
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
    
    public function afterSave($insert, $changedAttributes){
        $model_presupuesto_cabecera = PresupuestoCabecera::find()->where(['presupuesto_cabecera_id' => $this->presupuesto_cabecera_id])->one();
        if(!Yii::$app->user->isGuest){
            if($insert){
                $this->presupuesto_cabecera_nombre = $model_presupuesto_cabecera->getNombre();
                $this->save();
            }
            parent::afterSave($insert, $changedAttributes);
            return true;
        }
        return false;
    }
    
}
