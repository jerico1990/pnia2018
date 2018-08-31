<?php

namespace app\models\Patrimonio;

use Yii;

use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\rrhh\StaffPersona;

/**
 * This is the model class for table "patrimonio_movimiento".
 *
 * @property int $patrimonio_movimiento_id
 * @property int $patrimonio_item_id
 * @property int $metacodigo_id
 * @property int $ubicacion_inicial_id
 * @property int $ubicacion_final_id
 * @property double $persona_aut
 * @property double $persona_rec
 * @property string $fecha_salida
 * @property string $fecha_retorno
 * @property string $creado_en
 * @property int $creado_por
 * @property string $actualizado_en
 * @property int $actualizado_por
 *
 * @property Metacodigo $metacodigo
 * @property PatrimonioItem $patrimonioItem
 * @property Ubicacion $ubicacionInicial
 * @property Ubicacion $ubicacionFinal
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 */
class PatrimonioMovimiento extends \yii\db\ActiveRecord
{
    public $autocomplete_staff_persona_aut;
    public $autocomplete_staff_persona_rec;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patrimonio_movimiento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patrimonio_item_id', 'metacodigo_id', 'ubicacion_inicial_id', 'ubicacion_final_id', 'creado_por', 'actualizado_por'], 'default', 'value' => null],
            [['patrimonio_item_id', 'metacodigo_id', 'ubicacion_inicial_id', 'ubicacion_final_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['autocomplete_staff_persona_aut', 'autocomplete_staff_persona_rec', 'fecha_salida'], 'required'],
            [['persona_aut', 'persona_rec'], 'number'],
            [['fecha_salida', 'fecha_retorno', 'creado_en', 'actualizado_en'], 'safe'],
            [['metacodigo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['metacodigo_id' => 'metacodigo_id']],
            [['patrimonio_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioItem::className(), 'targetAttribute' => ['patrimonio_item_id' => 'patrimonio_item_id']],
            [['ubicacion_inicial_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ubicacion::className(), 'targetAttribute' => ['ubicacion_inicial_id' => 'ubicacion_id']],
            [['ubicacion_final_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ubicacion::className(), 'targetAttribute' => ['ubicacion_final_id' => 'ubicacion_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            //[['fecha_salida', 'fecha_retorno'], 'date'], 
            [['fecha_retorno'], 'required'],
            ['fecha_retorno', 'compare', 'compareAttribute' => 'fecha_salida', 'operator' => '>'],
            [['autocomplete_staff_persona_aut'],'string'],
            [['autocomplete_staff_persona_rec'],'string'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'patrimonio_movimiento_id' => Yii::t('app', 'Patrimonio Movimiento ID'),
            'patrimonio_item_id' => Yii::t('app', 'Patrimonio Item ID'),
            'metacodigo_id' => Yii::t('app', 'Tipo de Movimiento'),
            'ubicacion_inicial_id' => Yii::t('app', 'Ubicación Inicial'),
            'ubicacion_final_id' => Yii::t('app', 'Ubicación Final'),
            'persona_aut' => Yii::t('app', 'Persona Autorizada'),
            'persona_rec' => Yii::t('app', 'Persona Receptor'),
            'fecha_salida' => Yii::t('app', 'Fecha Salida'),
            'fecha_retorno' => Yii::t('app', 'Fecha Retorno'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'autocomplete_staff_persona_aut' => Yii::t('app', 'Autorizado por'),
            'autocomplete_staff_persona_rec' => Yii::t('app', 'Recepcionado por'),
        ];
    }

    public function getMetacodigoDescripcion(){
        return $model = (new Metacodigo())->findById($this->metacodigo_id)->descripcion;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetacodigo()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'metacodigo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioItem()
    {
        return $this->hasOne(PatrimonioItem::className(), ['patrimonio_item_id' => 'patrimonio_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    //cambiado para joinWith con dos tablas
    public function getUbicacionInicial()
    {
        //return $this->hasOne(Ubicacion::className(), ['ubicacion_id' => 'ubicacion_inicial_id']);
        return $this->hasOne(Ubicacion::className(), ['ubicacion_id' => 'ubicacion_inicial_id'])->from(['ubicacionInicial' => Ubicacion::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacionFinal()
    {
        //return $this->hasOne(Ubicacion::className(), ['ubicacion_id' => 'ubicacion_final_id']);
        return $this->hasOne(Ubicacion::className(), ['ubicacion_id' => 'ubicacion_final_id'])->from(['ubicacionFinal' => Ubicacion::tableName()]);
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
    
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
            if (isset($this->autocomplete_staff_persona_aut)) {
                $this->persona_aut = StaffPersona::getIdByDniNombre($this->autocomplete_staff_persona_aut);
            }
            if (isset($this->autocomplete_staff_persona_rec)) {
                $this->persona_rec = StaffPersona::getIdByDniNombre($this->autocomplete_staff_persona_rec);
            }
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
