<?php

namespace app\models\rrhh;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\ModeloGenerico;
use \yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "pnia_ent_financiera".
 *
 * @property int $pnia_ent_financiera_id
 * @property int $tipo_entidad
 * @property string $razon_social
 * @property string $cuenta_bancaria
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ContratoCartaFianza[] $contratoCartaFianzas
 * @property Metacodigo $tipoEntidad
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 */
class PniaEntFinanciera extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pnia_ent_financiera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_entidad', 'actualizado_por', 'creado_por'], 'integer'],
            [['razon_social', 'cuenta_bancaria'], 'string'],
            [['actualizado_en', 'creado_en'], 'safe'],
            //[['actualizado_por', 'creado_por'], 'required'],
            [['tipo_entidad'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['tipo_entidad' => 'metacodigo_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pnia_ent_financiera_id' => Yii::t('app', 'Pnia Ent Financiera ID'),
            'tipo_entidad' => Yii::t('app', 'Tipo Entidad'),
            'razon_social' => Yii::t('app', 'Razón Social'),
            'cuenta_bancaria' => Yii::t('app', 'Cuenta Bancaria'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getArrayTipoEntidadFinanciera()
    {
        return $array_metacodigo_tipo_entidad_financiera   = Metacodigo::getComboBoxItems('Tipo_Entidad_Financiera');
    }

    static function getComboBoxItems(){
        $items  = PniaEntFinanciera::find()->all();
        return ArrayHelper::map($items, 'pnia_ent_financiera_id', 'razon_social');
    }
    
    public function getContratoCartaFianzas()
    {
        return $this->hasMany(ContratoCartaFianza::className(), ['entidad_emisora' => 'pnia_ent_financiera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoEntidadFinanciera()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'tipo_entidad']);
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
    public function getActualizadoPor()
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'actualizado_por']);
    }
}
