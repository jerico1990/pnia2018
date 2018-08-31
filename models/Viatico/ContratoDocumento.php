<?php

namespace app\models\Viatico;

use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "contrato_documento".
 *
 * @property int $contrato_documento_id
 * @property int $contrato_id
 * @property int $documento_pnia_id
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ContratoContrato $contrato
 * @property DocumentoPnia $documentoPnia
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * 
 */
class ContratoDocumento extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contrato_documento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contrato_id', 'documento_pnia_id'], 'required'],
            [['contrato_id', 'documento_pnia_id', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['contrato_id', 'documento_pnia_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['screado_en'], 'safe'],
            [['contrato_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContratoContrato::className(), 'targetAttribute' => ['contrato_id' => 'contrato_contrato_id']],
            [['documento_pnia_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentoPnia::className(), 'targetAttribute' => ['documento_pnia_id' => 'documento_pnia_id']],
            //[['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            //[['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contrato_documento_id' => Yii::t('app', 'Contrato Documento ID'),
            'contrato_id' => Yii::t('app', 'Contrato ID'),
            'documento_pnia_id' => Yii::t('app', 'Documento Pnia ID'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContrato()
    {
        return $this->hasOne(ContratoContrato::className(), ['contrato_contrato_id' => 'contrato_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentoPnia()
    {
        return $this->hasOne(DocumentoPnia::className(), ['documento_pnia_id' => 'documento_pnia_id']);
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
