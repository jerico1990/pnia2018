<?php

namespace app\models\Utilitario;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "utilitario_ubigeo".
 *
 * @property string $utilitario_ubigeo_id
 * @property string $nombre
 * @property string $ubigeo_region_id
 * @property string $ubigeo_provincia_id
 * @property string $actualizado_en
 * @property string $creado_en
 * @property int $creado_por
 * @property int $actualizado_por
 *
 * @property FondoDistribucionMonto[] $fondoDistribucionMontos
 * @property FondoDistribucionMonto[] $fondoDistribucionMontos0
 * @property FondoViaticoDetalle[] $fondoViaticoDetalles
 * @property FondoViaticoDetalle[] $fondoViaticoDetalles0
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 * @property UtilitarioUbigeo $ubigeoRegion
 * @property UtilitarioUbigeo[] $utilitarioUbigeos
 * @property UtilitarioUbigeo $ubigeoProvincia
 * @property UtilitarioUbigeo[] $utilitarioUbigeos0
 */
class UtilitarioUbigeo extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilitario_ubigeo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilitario_ubigeo_id'], 'required'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['creado_por', 'actualizado_por'], 'default', 'value' => null],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['utilitario_ubigeo_id', 'nombre', 'ubigeo_region_id', 'ubigeo_provincia_id'], 'string', 'max' => 255],
            [['utilitario_ubigeo_id'], 'unique'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['ubigeo_region_id'], 'exist', 'skipOnError' => true, 'targetClass' => UtilitarioUbigeo::className(), 'targetAttribute' => ['ubigeo_region_id' => 'utilitario_ubigeo_id']],
            [['ubigeo_provincia_id'], 'exist', 'skipOnError' => true, 'targetClass' => UtilitarioUbigeo::className(), 'targetAttribute' => ['ubigeo_provincia_id' => 'utilitario_ubigeo_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'utilitario_ubigeo_id' => 'Utilitario Ubigeo ID',
            'nombre' => 'Nombre',
            'ubigeo_region_id' => 'Ubigeo Region ID',
            'ubigeo_provincia_id' => 'Ubigeo Provincia ID',
            'actualizado_en' => 'Actualizado En',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
            'actualizado_por' => 'Actualizado Por',
        ];
    }

    static function getAreasUbigeo(){
        $ubicaciones = static::find()->select(['utilitario_ubigeo_id', 'nombre'])->distinct()->orderBy(['nombre' => SORT_ASC])->all();
        return ArrayHelper::map($ubicaciones, 'utilitario_ubigeo_id','nombre');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoDistribucionMontos()
    {
        return $this->hasMany(FondoDistribucionMonto::className(), ['destino_ini_ubigeo' => 'utilitario_ubigeo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoDistribucionMontos0()
    {
        return $this->hasMany(FondoDistribucionMonto::className(), ['destino_fin_ubigeo' => 'utilitario_ubigeo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoViaticoDetalles()
    {
        return $this->hasMany(FondoViaticoDetalle::className(), ['destino_inicial_ubigeo' => 'utilitario_ubigeo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondoViaticoDetalles0()
    {
        return $this->hasMany(FondoViaticoDetalle::className(), ['destino_final_ubigeo' => 'utilitario_ubigeo_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbigeoRegion()
    {
        return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'ubigeo_region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUtilitarioUbigeos()
    {
        return $this->hasMany(UtilitarioUbigeo::className(), ['ubigeo_region_id' => 'utilitario_ubigeo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbigeoProvincia()
    {
        return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'ubigeo_provincia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUtilitarioUbigeos0()
    {
        return $this->hasMany(UtilitarioUbigeo::className(), ['ubigeo_provincia_id' => 'utilitario_ubigeo_id']);
    }
}
