<?php

namespace app\models\Viatico;
use app\models\Patrimonio\DocumentoPnia;
use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "requerimiento_documento".
 *
 * @property int $requerimiento_documento_id
 * @property int $flujo_requerimiento_id
 * @property int $documento_pnia_id
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property DocumentoPnia $documentoPnia
 * @property FlujoRequerimiento $documentoPnia0
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class RequerimientoDocumento extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requerimiento_documento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flujo_requerimiento_id', 'documento_pnia_id'], 'required'],
            [['flujo_requerimiento_id', 'documento_pnia_id', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['flujo_requerimiento_id', 'documento_pnia_id', 'actualizado_por', 'creado_por'], 'integer'],
            //[['actualizado_en', 'creado_en'], 'safe'],
            [['documento_pnia_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentoPnia::className(), 'targetAttribute' => ['documento_pnia_id' => 'documento_pnia_id']],
            [['documento_pnia_id'], 'exist', 'skipOnError' => true, 'targetClass' => FlujoRequerimiento::className(), 'targetAttribute' => ['documento_pnia_id' => 'flujo_requerimiento_id']],
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
            'requerimiento_documento_id' => 'Requerimiento Documento ID',
            'flujo_requerimiento_id' => 'Flujo Requerimiento ID',
            'documento_pnia_id' => 'Documento Pnia ID',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
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
    public function getDocumentoPnia0()
    {
        return $this->hasOne(FlujoRequerimiento::className(), ['flujo_requerimiento_id' => 'documento_pnia_id']);
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
