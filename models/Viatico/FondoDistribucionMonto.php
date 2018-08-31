<?php

namespace app\models\Viatico;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\Utilitario\UtilitarioUbigeo;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "fondo_distribucion_monto".
 *
 * @property int $fondo_distribucion_monto_id
 * @property int $escala_metacodigo
 * @property int $concepto_metacodigo
 * @property int $destino_ini_ubigeo
 * @property int $destino_fin_ubigeo
 * @property double $monto_determinado
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Metacodigo $escalaMetacodigo
 * @property Metacodigo $conceptoMetacodigo
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property UtilitarioUbigeo $destinoIniUbigeo
 * @property UtilitarioUbigeo $destinoFinUbigeo
 */
class FondoDistribucionMonto extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fondo_distribucion_monto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['escala_metacodigo', 'concepto_metacodigo', 'destino_ini_ubigeo', 'destino_fin_ubigeo', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['escala_metacodigo', 'concepto_metacodigo', 'destino_ini_ubigeo', 'destino_fin_ubigeo', 'actualizado_por', 'creado_por'], 'integer'],
            [['monto_determinado'], 'number'],
            [['actualizado_en', 'creado_en'], 'safe'],
            //[['actualizado_por', 'creado_por'], 'required'],
            [['concepto_metacodigo'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['concepto_metacodigo' => 'metacodigo_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['destino_ini_ubigeo'], 'exist', 'skipOnError' => true, 'targetClass' => UtilitarioUbigeo::className(), 'targetAttribute' => ['destino_ini_ubigeo' => 'utilitario_ubigeo_id']],
            [['destino_fin_ubigeo'], 'exist', 'skipOnError' => true, 'targetClass' => UtilitarioUbigeo::className(), 'targetAttribute' => ['destino_fin_ubigeo' => 'utilitario_ubigeo_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fondo_distribucion_monto_id' => 'Fondo Distribucion Monto ID',
            'escala_metacodigo' => 'Nivel',
            'concepto_metacodigo' => 'Concepto',
            'destino_ini_ubigeo' => 'Ubigeo Origen',
            'destino_fin_ubigeo' => 'Ubigeo Destino',
            'monto_determinado' => 'Monto Asignado (Soles)',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEscalaMetacodigo()
    {
        //return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'escala_metacodigo']);
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'escala_metacodigo'])->from(['escalaMetacodigo' => Metacodigo::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConceptoMetacodigo()
    {
        //return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'concepto_metacodigo']);
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'concepto_metacodigo'])->from(['conceptoMetacodigo' => Metacodigo::tableName()]);
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
    public function getDestinoIniUbigeo()
    {
        //return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_ini_ubigeo']);
        return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_ini_ubigeo'])->from(['destinoInicial' => UtilitarioUbigeo::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinoFinUbigeo()
    {
        //return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_fin_ubigeo']);
        return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_fin_ubigeo'])->from(['destinoFinal' => UtilitarioUbigeo::tableName()]);
    }
}
