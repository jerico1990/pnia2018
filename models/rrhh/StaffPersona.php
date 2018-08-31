<?php

namespace app\models\rrhh;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\ModeloGenerico;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "staff_persona".
 *
 * @property int $staff_persona_id
 * @property string $nombres
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $codigo_pnia
 * @property int $ruc
 * @property int $nivel
 * @property int $staff_area_id
 * @property string $cuenta_bancaria
 * @property int $pnia_ent_financiera_id
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property StaffArea[] $staffAreas
 * @property PniaEntFinanciera $pniaEntFinanciera
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class StaffPersona extends ModeloGenerico
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_persona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ruc', 'pnia_ent_financiera_id', 'actualizado_por', 'creado_por','nivel','staff_area_id'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['ruc'], 'validarRuc' ],
            //['ruc', 'unique' ],
            [['dni', 'apellido_paterno', 'apellido_materno'], 'required'],
            [['cargo', 'fecha_nacimiento',], 'required' ],
            [['dni'], 'validarDni'],
            [['codigo_pnia', 'ruc', 'dni'], 'unique'],
            [['nombres', 'codigo_pnia', 'cuenta_bancaria'], 'string', 'max' => 255],
            [['pnia_ent_financiera_id'], 'exist', 'skipOnError' => true, 'targetClass' => PniaEntFinanciera::className(), 'targetAttribute' => ['pnia_ent_financiera_id' => 'pnia_ent_financiera_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['staff_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffArea::className(), 'targetAttribute' => ['staff_area_id' => 'staff_area_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_persona_id' => 'Staff Persona ID',
            'nombres' => 'Nombres',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'dni' => 'DNI',
            'codigo_pnia' => 'Código Pnia',
            'ruc' => 'RUC',
            'cuenta_bancaria' => 'Cuenta Bancaria',
            'pnia_ent_financiera_id' => 'Entidad Financiera',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
            'nivel' => 'Categoria/Nivel Viaticos',
            'staff_area_id' => 'Dependencia',
            'nombreStaffArea' => 'Dependencia',
            'nombreBanco' => 'Razón Social Banca Asociada',
            'cargo' => 'Cargo',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'poliza_seguro' => 'Póliza de Seguro',
            'email' => 'Correo Electrónico',
        ];
    }
    
    public function getPersonaPorId($id){
        return static::findOne(['staff_persona_id'=>$id]);
    }

    /**
     * [getComboBoxList description]
     * @param  [int] $persona [codigo persona responsable]
     * @return [array(lista Metacodigos)]    [description]
     */
    static function getComboBoxList($persona){
        return Metacodigo::find()->where([ 'responsable' => $persona ])->all();
    }

    /**
     * [getArrayPersonas description]
     * @return [array(persona->id => persona->nombre)] [description]
     */
    public function getArrayPersonas()
    {
        $personas = $this->find()->orderBy(['nombres' => SORT_ASC])->all();
        return ArrayHelper::map($personas, 'staff_persona_id', 'nombres');
    }

    /**
     * @return [String] [nombre y apellido concatenados]
     */
    public function getNombreCompleto()
    {
        return $this->apellido_paterno.' '. $this->apellido_materno. ', '.$this->nombres;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffAreas()
    {
        return $this->hasMany(StaffArea::className(), ['responsable' => 'staff_persona_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPniaEntFinanciera()
    {
        return $this->hasOne(PniaEntFinanciera::className(), ['pnia_ent_financiera_id' => 'pnia_ent_financiera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffArea()
    {
        return $this->hasOne(StaffArea::className(), ['staff_area_id' => 'staff_area_id']);
    }

    public function getNombreStaffArea(){
        if(isset($this->staff_area_id) && $this->staff_area_id != null){
            $area = $this->getStaffArea()->one();
            if (isset($area)) {
                return $area->descripcion;
            }else{
                return '- -';
            }
        }
    }

    public function getNombreBanco(){
        if(isset($this->pnia_ent_financiera_id) && $this->pnia_ent_financiera_id != null){
            $banco = $this->getPniaEntFinanciera()->one();
            if (isset($banco)) {
                return $banco->razon_social;
            }else{
                return '- -';
            }
        }
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
     * [getIdByDniNombre Permite la obtención del id de staff_persona apartir de la query generada por el auto-complete. Ale]
     * @param  [string] $stringDniNombre [cadena generada por el widget de autocomplete]
     * @return [string]                  [staff_persona_id]
     */
    static function getIdByDniNombre($stringDniNombre){
        if (isset($stringDniNombre) && strlen($stringDniNombre)>0) {
            $dniString = substr($stringDniNombre, 0,8);
            return StaffPersona::find()->where(['dni' => $dniString])->one()->staff_persona_id;
        }
        return null;
    }

    /**
     * [getDniNombreById Genera la cadena del string para mostrar dni y nombre]
     * @param  [int] $id [persona_id]
     * @return [string]     [dni.nombre.apellidos]
     */
    static function getDniNombreById($id){
        $persona = static::findOne(['staff_persona_id'=>$id]);
        return $persona->dni.' '.$persona->nombres.' '.$persona->apellido_paterno.' '.$persona->apellido_materno;
    }
    
}
