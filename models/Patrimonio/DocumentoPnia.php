<?php

namespace app\models\Patrimonio;

use Yii;

use app\models\Auditoria\Usuario;
use app\models\Viatico\FlujoRequerimiento;

/**
 * This is the model class for table "documento_pnia".
 *
 * @property int $documento_pnia_id
 * @property string $ruta_documento
 * @property string $nombre_documento
 * @property string $documento_mimetype
 * @property string $documento_charset
 * @property string $documento_lastupd
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 * @property PatrimonioInventario[] $patrimonioInventarios
 * @property PatrimonioItem[] $patrimonioItems
 */
class DocumentoPnia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documento_pnia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['ruta_documento'], 'file',  'maxSize'=> 1024 * 1024 * 10, 'maxFiles' => 20],
            [['ruta_documento'], 'default'],
            //[['ruta_documento'], 'required'],
            [['nombre_documento', 'documento_mimetype', 'documento_charset', 'documento_lastupd'], 'string'],
            [['actualizado_en', 'creado_en'], 'safe'],
            //[['actualizado_por', 'creado_por'], 'required'],
            [['actualizado_por', 'creado_por'], 'integer'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'documento_pnia_id' => Yii::t('app', 'Documento Pnia ID'),
            'ruta_documento' => Yii::t('app', 'Ruta Documento'),
            'nombre_documento' => Yii::t('app', 'Nombre Documento'),
            'documento_mimetype' => Yii::t('app', 'Documento Mimetype'),
            'documento_charset' => Yii::t('app', 'Documento Charset'),
            'documento_lastupd' => Yii::t('app', 'Documento Lastupd'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            //'flujo_requerimiento_id' => Yii::t('app', 'Flujo Requerimiento'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    // public function getFlujoRequerimiento()
    // {
    //     return $this->hasOne(FlujoRequerimiento::className(), ['flujo_requerimiento_id' => 'flujo_requerimiento_id']);
    // }

    public function getDocumentoPorNombre($id){
        return $this->findOne(['documento_pnia_id' => $id]);
    }
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
    public function getPatrimonioInventarios()
    {
        return $this->hasMany(PatrimonioInventario::className(), ['documento_pnia_id' => 'documento_pnia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioItems()
    {
        return $this->hasMany(PatrimonioItem::className(), ['documento_pnia_id' => 'documento_pnia_id']);
    }

    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
             if(!Yii::$app->user->isGuest)
             {
                if ($this->isNewRecord) {
                    $this->creado_por = Yii::$app->user->identity->usuario_id;
                    $this->creado_en = date('Y-m-d H:i:s');
                }
                $this->actualizado_por= Yii::$app->user->identity->usuario_id;
                $this->actualizado_en = date('Y-m-d H:i:s');
                return true;
             } else {
                return false;
             }
        }
        return false;
    }
}
