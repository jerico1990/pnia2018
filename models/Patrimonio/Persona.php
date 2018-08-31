<?php

namespace app\models\Patrimonio;

use app\models\Auditoria\Usuario;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property int $persona_id
 * @property string $nombre
 * @property string $creado_en
 * @property int $creado_por
 * @property string $actualizado_en
 * @property int $actualizado_por
 *
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 */
class Persona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['creado_en', 'creado_por', 'actualizado_en', 'actualizado_por'], 'required'],
            [['creado_en', 'actualizado_en'], 'safe'],
            //[['creado_por', 'actualizado_por'], 'default', 'value' => null],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
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
            'persona_id' => Yii::t('app', 'Persona'),
            'nombre' => Yii::t('app', 'Nombre'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
        ];
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
    
   static function getComboBoxList(){
        return Persona::find()->all();
    }


    /**
     * [beforeSave Permite guardar los datos ]
     * @param  [$model] $insert  [Modelo que ha de ser alterado]
     * @return [Boolean]         [true si se agrego, caso contrario false]
     */
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
