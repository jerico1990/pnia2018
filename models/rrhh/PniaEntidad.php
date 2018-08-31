<?php

namespace app\models\rrhh;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use yii\helpers\ArrayHelper;
use app\models\ModeloGenerico;

use Yii;

/**
 * This is the model class for table "pnia_entidad".
 *
 * @property int $pnia_entidad_id
 * @property int $tipo_entidad
 * @property string $ruc
 * @property string $razon_social
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ContratoCartaFianza[] $contratoCartaFianzas
 * @property ContratoContrato[] $contratoContratos
 * @property Metacodigo $tipoEntidad
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 */
class PniaEntidad extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pnia_entidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_entidad', 'ruc', 'actualizado_por', 'creado_por'], 'integer'],
            ['ruc', 'validarRuc' ],
            ['ruc', 'unique' ],
            [['razon_social'], 'string'],
            [['actualizado_en', 'creado_en'], 'safe'],
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
            'pnia_entidad_id' => Yii::t('app', 'Pnia Entidad ID'),
            'tipo_entidad' => Yii::t('app', 'Tipo Entidad'),
            'ruc' => Yii::t('app', 'Ruc'),
            'razon_social' => Yii::t('app', 'Razón Social'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
        ];
    }
    
    static function getPniaEntidades(){
        $entidades = static::find()->orderBy(['razon_social' => SORT_ASC])->all();
        return ArrayHelper::map($entidades, 'pnia_entidad_id','razon_social');
    }
    
    public function getArrayTipoEntidad()
    {
        return $array_metacodigo_tipo_entidad   = Metacodigo::getComboBoxItems('Tipo_Entidad');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratoCartaFianzas()
    {
        return $this->hasMany(ContratoCartaFianza::className(), ['entidad_afianzada' => 'pnia_entidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratoContratos()
    {
        return $this->hasMany(ContratoContrato::className(), ['entidad_contratista' => 'pnia_entidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoEntidad()
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
