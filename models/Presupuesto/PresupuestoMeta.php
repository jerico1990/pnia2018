<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "presupuesto_meta".
 *
 * @property int $presupuesto_meta_id
 * @property int $presupuesto_id
 * @property int $meta_fisica_id
 * @property int $meta_financiera_id
 * @property double $unidad_fisica_consumida_temp
 * @property double $unidad_financiera_consumida_temp
 * @property double $unidad_fisica_consumida_final
 * @property double $unidad_financiera_consumida_final
 * @property int $estado_meta
 * @property int $estado_financiero
 * @property int $estado_regitro
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property MetaFinanciera $metaFinanciera
 * @property MetaFisica $metaFisica
 * @property Presupuesto $presupuesto
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class PresupuestoMeta extends ModeloGenerico
{
    public $presupuesto_cabecera_id;
    public $periodo_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'presupuesto_meta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['presupuesto_id', 'meta_fisica_id', 'meta_financiera_id', 'estado_meta'], 'required'],
            [['presupuesto_cabecera_id'],'required','when' => function($model){return $model->isNewRecord;}],
            //[['estado_meta'], 'required'],
            [['presupuesto_id', 'meta_fisica_id', 'meta_financiera_id', 'estado_meta', 'estado_financiero', 'estado_regitro', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['presupuesto_id', 'meta_fisica_id', 'meta_financiera_id', 'estado_meta', 'estado_financiero', 'estado_regitro', 'actualizado_por', 'creado_por','presupuesto_cabecera_id','periodo_id'], 'integer'],
            [['unidad_fisica_consumida_temp', 'unidad_financiera_consumida_temp', 'unidad_fisica_consumida_final', 'unidad_financiera_consumida_final'], 'number'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['meta_financiera_id'], 'exist', 'skipOnError' => true, 'targetClass' => MetaFinanciera::className(), 'targetAttribute' => ['meta_financiera_id' => 'meta_financiera_id']],
            [['meta_fisica_id'], 'exist', 'skipOnError' => true, 'targetClass' => MetaFisica::className(), 'targetAttribute' => ['meta_fisica_id' => 'meta_fisica_id']],
            [['presupuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Presupuesto::className(), 'targetAttribute' => ['presupuesto_id' => 'presupuesto_id']],
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
            'presupuesto_meta_id' => 'Presupuesto Meta ID',
            'presupuesto_id' => 'Presupuesto ID',
            'meta_fisica_id' => 'Meta Fisica ID',
            'meta_financiera_id' => 'Meta Financiera ID',
            'unidad_fisica_consumida_temp' => 'Unidad Fisica Consumida Temp',
            'unidad_financiera_consumida_temp' => 'Unidad Financiera Consumida Temp',
            'unidad_fisica_consumida_final' => 'Unidad Fisica Consumida Final',
            'unidad_financiera_consumida_final' => 'Unidad Financiera Consumida Final',
            'estado_meta' => 'Estado Meta',
            'estado_financiero' => 'Estado Financiero',
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
    public function getMetaFinanciera()
    {
        return $this->hasOne(MetaFinanciera::className(), ['meta_financiera_id' => 'meta_financiera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetaFisica()
    {
        return $this->hasOne(MetaFisica::className(), ['meta_fisica_id' => 'meta_fisica_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuesto()
    {
        return $this->hasOne(Presupuesto::className(), ['presupuesto_id' => 'presupuesto_id']);
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
            if (Yii::$app->user->isGuest){
                return false;
            }

            $presupuestoCabecera = PresupuestoCabecera::findOne($this->presupuesto_cabecera_id);
            $presupuesto = $presupuestoCabecera->getPresupuestoEn($this->periodo_id);
            $this->presupuesto_id = $presupuesto->presupuesto_id;
            $this->meta_fisica_id = MetaFisica::find()->where(['presupuesto_cabecera_id' => $this->presupuesto_cabecera_id])->one()->meta_fisica_id;
            $this->meta_financiera_id = MetaFinanciera::find()->where(['presupuesto_cabecera_id' => $this->presupuesto_cabecera_id])->one()->meta_financiera_id;
            $this->actualizado_por= Yii::$app->user->identity->usuario_id;
            $this->actualizado_en = date('Y-m-d H:i:s');
            if ($this->isNewRecord) {
                $this->creado_por = Yii::$app->user->identity->usuario_id;
                $this->creado_en = date('Y-m-d H:i:s');
                $this->estado_meta = 0;        // (0)pediente/en espera
                $this->estado_regitro = 1;     // (1)activo
                $this->estado_financiero = 0;  // (0)planificado
                $this->unidad_financiera_consumida_final = 0;
                $this->unidad_fisica_consumida_final = 0;
            }
            return true;
        }
        return false;
    }

    /**
     * El campo origen es de donde se tomara el presupuesto y a donde caminara, en el primer paso pasa de planificado a certificado (los tags estan en el orden del recorrido que deberian tener
     * @param $campo_origen  : String :: planificado, certificado , compromiso, devengado,girado, pagado, ejecutado
     * @param $campo_destino : String :: planificado, certificado , compromiso, devengado,girado, pagado, ejecutado
     */
    public function consumirMeta($campo_origen,$campo_destino){
        $presupuesto_cabecera = $this->presupuesto->presupuestoCabecera;
        $meta_financiera = $presupuesto_cabecera->metaFinanciera;
        $gasto_ro   = $meta_financiera->precio_unitario_ro * $this->unidad_financiera_consumida_temp;
        $gasto_rooc = $meta_financiera->precio_unitario_rooc * $this->unidad_financiera_consumida_temp;
        $aceptado_ro = true; $aceptado_rooc = true;
        if ($gasto_ro > 0 ){
            $aceptado_ro = $presupuesto_cabecera->moverMontos($this->presupuesto->periodo_id,'presupuesto_'.$campo_origen.'_ro','presupuesto_'.$campo_destino.'_ro',$gasto_ro);
        }
        if ($gasto_rooc > 0 ){
            $aceptado_rooc = $presupuesto_cabecera->moverMontos($this->presupuesto->periodo_id,'presupuesto_'.$campo_origen.'_rooc','presupuesto_'.$campo_destino.'_rooc',$gasto_rooc);
        }
        if ($aceptado_ro){
            $this->unidad_financiera_consumida_final = $this->unidad_financiera_consumida_temp;
            $this->unidad_fisica_consumida_final = $this->unidad_fisica_consumida_temp;
        }
        if ($aceptado_rooc){
            $this->unidad_financiera_consumida_final = $this->unidad_financiera_consumida_temp;
            $this->unidad_fisica_consumida_final = $this->unidad_fisica_consumida_temp;
        }
        if ($aceptado_rooc and $aceptado_ro){
            $meta_fisica = $presupuesto_cabecera->metaFisica;
            $meta_fisica->avance_actual = $this->unidad_fisica_consumida_final;
            $meta_fisica->save();

            $meta_financiera->avance_actual = $this->unidad_financiera_consumida_final;
            $meta_financiera->save();
            $this->save();
            return true;
        }
        return false;
    }

}
