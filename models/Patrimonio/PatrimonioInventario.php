<?php

namespace app\models\Patrimonio;

use app\models\Auditoria\Usuario;
use app\models\rrhh\StaffPersona;
use Yii;

/**
 * This is the model class for table "patrimonio_inventario".
 *
 * @property int $patrimonio_inventario_id
 * @property int $patrimonio_item_id
 * @property int $metacodigo_condicion_id
 * @property int $metacodigo_estado_id
 * @property int $documento_pnia_id
 * @property int $ubicacion_id
 * @property int $persona_aut
 * @property int $persona_inv
 * @property string $fecha_inventario
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property DocumentoPnia $documentoPnia
 * @property Metacodigo $metacodigoCondicion
 * @property Metacodigo $metacodigoEstado
 * @property PatrimonioItem $patrimonioItem
 * @property Ubicacion $ubicacion
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class PatrimonioInventario extends \yii\db\ActiveRecord
{
    public $autocomplete_staff_persona_aut;
    public $autocomplete_staff_persona_inv;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patrimonio_inventario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patrimonio_item_id', 'metacodigo_condicion_id', 'metacodigo_estado_id', 'documento_pnia_id', 'ubicacion_id', 'persona_aut', 'persona_inv', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['patrimonio_item_id', 'metacodigo_condicion_id', 'metacodigo_estado_id', 'documento_pnia_id', 'ubicacion_id', 'persona_aut', 'persona_inv', 'actualizado_por', 'creado_por'], 'integer'],
            [['fecha_inventario', 'actualizado_en', 'creado_en'], 'safe'],
            [['autocomplete_staff_persona_aut', 'autocomplete_staff_persona_inv'], 'required'],
            [['documento_pnia_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentoPnia::className(), 'targetAttribute' => ['documento_pnia_id' => 'documento_pnia_id']],
            [['metacodigo_condicion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['metacodigo_condicion_id' => 'metacodigo_id']],
            [['metacodigo_estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['metacodigo_estado_id' => 'metacodigo_id']],
            [['patrimonio_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioItem::className(), 'targetAttribute' => ['patrimonio_item_id' => 'patrimonio_item_id']],
            [['ubicacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ubicacion::className(), 'targetAttribute' => ['ubicacion_id' => 'ubicacion_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['autocomplete_staff_persona_aut'],'string'],
            [['autocomplete_staff_persona_inv'],'string'],
            [['autocomplete_staff_persona_aut','autocomplete_staff_persona_inv'],'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'patrimonio_inventario_id' => 'Patrimonio Inventario ID',
            'patrimonio_item_id' => 'Item Patrimonio',
            'metacodigo_condicion_id' => 'Condición',
            'metacodigo_estado_id' => 'Estado Actual',
            'documento_pnia_id' => 'Documento Relacionado',
            'ubicacion_id' => 'Ubicación',
            'persona_aut' => 'Autorizado por',
            'persona_inv' => 'Inventariado por',
            'fecha_inventario' => 'Fecha Inventario',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
            'autocomplete_staff_persona_aut' => 'Autorizado por',
            'autocomplete_staff_persona_inv' => 'Inventariado por',
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
    public function getMetacodigoCondicion()
    {
        //return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'metacodigo_condicion_id']);
        //se crea un alias al momento de hacer un join with en sql
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'metacodigo_condicion_id'])->from(['condicion' => Metacodigo::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetacodigoEstado()
    {
        //return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'metacodigo_estado_id']);
        //se crea un alias al momento de hacer un join with en sql
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'metacodigo_estado_id'])->from(['estado' => Metacodigo::tableName()]);
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
    public function getUbicacion()
    {
        return $this->hasOne(Ubicacion::className(), ['ubicacion_id' => 'ubicacion_id']);
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
    
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
             if(!Yii::$app->user->isGuest)
             {
                if (isset($this->autocomplete_staff_persona_aut)) {
                    $this->persona_aut = StaffPersona::getIdByDniNombre($this->autocomplete_staff_persona_aut);
                }
                if (isset($this->autocomplete_staff_persona_inv)) {
                    $this->persona_inv = StaffPersona::getIdByDniNombre($this->autocomplete_staff_persona_inv);
                }
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
    
    public function asignarDocumentos($array_documentos_id){     
        foreach($array_documentos_id as $documento_actual){
            $objeto_contrato_documento = new \app\models\Viatico\ContratoDocumento();
            $objeto_contrato_documento->patrimonio_inventario_id = $this->patrimonio_inventario_id;
            $objeto_contrato_documento->documento_pnia_id = $documento_actual;
            $objeto_contrato_documento->save(false);
        }
    }
}
