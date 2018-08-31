<?php

namespace app\models\General;
use app\models\Auditoria\Usuario;
use app\models\Adquisicion\RequerimientoDetalle;
use app\models\Adquisicion\Adjudicacion;
use Yii;

/**
 * This is the model class for table "postores".
 *
 * @property int $postores_id
 * @property string $dni
 * @property string $nombres
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $ruc
 * @property string $fecha_nacimiento
 * @property string $email
 * @property string $telefono
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class Postores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'postores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dni'], 'required'],
            [['fecha_nacimiento', 'actualizado_en', 'creado_en'], 'safe'],
            [['actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['actualizado_por', 'creado_por'], 'integer'],
            [['dni'], 'string', 'max' => 8],
            [['nombres', 'apellido_paterno', 'apellido_materno', 'email', 'telefono'], 'string', 'max' => 255],
            [['ruc'], 'string', 'max' => 11],
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
            'postores_id' => Yii::t('app', 'Postores ID'),
            'dni' => Yii::t('app', 'Dni'),
            'nombres' => Yii::t('app', 'Nombres'),
            'apellido_paterno' => Yii::t('app', 'Apellido Paterno'),
            'apellido_materno' => Yii::t('app', 'Apellido Materno'),
            'ruc' => Yii::t('app', 'Ruc'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
            'email' => Yii::t('app', 'Email'),
            'telefono' => Yii::t('app', 'Telefono'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
        ];
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

    public function getSituacionPostor(){
        $msg='';
        if($this->situacion_postor_id==1){
          $msg='En proceso';
        }
        elseif($this->situacion_postor_id==2){
          $msg='Ganador';
        }
        elseif($this->situacion_postor_id==3){
          $msg='No aceptado';
        }
        return $msg;
    }

    public function getSituacionAdjudicacion(){
      $adjudicacion=Adjudicacion::find()->where('adjudicacion_id=:adjudicacion_id',[':adjudicacion_id'=>$this->adjudicacion_id])->one();

      return $adjudicacion->situacion_adjudicacion_id;

    }
}
