<?php

namespace app\models\rrhh;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use yii\helpers\ArrayHelper;
use app\models\ModeloGenerico;

use Yii;

/**
 * This is the model class for table "staff_area".
 *
 * @property int $staff_area_id
 * @property string $codigo
 * @property string $descripcion
 * @property string $cargo
 * @property int $responsable
 * @property int $area_superior
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ContratoContrato[] $contratoContratos
 * @property ContratoContrato[] $contratoContratos0
 * @property StaffPersona $responsable0
 * @property StaffArea $areaSuperior
 * @property StaffArea[] $staffAreas
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 */
class StaffArea extends ModeloGenerico
{

    public $autocomplete_staff_persona;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_area';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'descripcion', 'cargo'], 'string'],
            [['responsable', 'area_superior', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['autocomplete_staff_persona'],'string'],
            //[['actualizado_por', 'creado_por'], 'required'],
            [['responsable'], 'exist', 'skipOnError' => true, 'targetClass' => StaffPersona::className(), 'targetAttribute' => ['responsable' => 'staff_persona_id']],
            [['area_superior'], 'exist', 'skipOnError' => true, 'targetClass' => StaffArea::className(), 'targetAttribute' => ['area_superior' => 'staff_area_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            ['codigo','validar']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staff_area_id' => Yii::t('app', 'Staff Area ID'),
            'codigo' => Yii::t('app', 'Código'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'cargo' => Yii::t('app', 'Cargo'),
            'responsable' => Yii::t('app', 'Responsable'),
            'area_superior' => Yii::t('app', 'Área Superior'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'autocomplete_staff_persona' => Yii::t('app','Personal Responsable'),
        ];
    }

    public function getRaiz($staff_area_id){
        $objeto_staff_area = new StaffArea();
        $objeto_staff_area = $objeto_staff_area->find()->where(['staff_area_id'=>$staff_area_id])->one();
        while(true){
            if($objeto_staff_area->area_superior == null)
                return $objeto_staff_area->staff_area_id;
            else
                $objeto_staff_area = $objeto_staff_area->find()->where(['area_superior'=>$objeto_staff_area->area_superior])->one();
        }
    }


    static function getComboBoxItems(){
        $items  = StaffArea::find()->all();
        return ArrayHelper::map($items, 'staff_area_id', 'descripcion','codigo');
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function findByResponsable($codResponsable){

        return static::findOne(['responsable' => $codResponsable]);
    }
    
    public function validar($codigo){
        $objeto_a_usar = new StaffArea();
        if($this->staff_area_id)
            if($objeto_a_usar->findByCodigo($this->codigo))
                return;
            else
                $this->addError($codigo,'No se puede editar el código');
        else
            $this->validarCodigo($codigo,$objeto_a_usar);
    }

    public function validarCodigo($codigo,$objeto_a_usar){
        $temporal = $objeto_a_usar;
        $padre_id=$this->area_superior;

        if($padre_id!=""){
            $padre = $temporal->findById($padre_id); 
            $codigo_padre = $padre->codigo;
            $codigo_hijo = $this->$codigo;
            $codigo_concatenado = $codigo_padre.".".$codigo_hijo;
            if($temporal->findByCodigo($codigo_concatenado))
                $this->addError($codigo,'Código ya existe en '.$padre->descripcion);
            else
                $this->codigo=$codigo_concatenado;
        }
        else if($temporal->findByCodigo($this->codigo)){
            $this->addError($codigo,'Código ya existe');
        }
    }
    
    public function findByCodigo($codigo){
        return static::findOne(['codigo'=>$codigo]);
    }
    
    public function findById($id){
        return static::findOne(['staff_area_id'=>$id]);
    }
    
    public function getArrayAreas(){
        $ubicaciones = static::find()->orderBy(['codigo' => SORT_ASC])->all();
        return ArrayHelper::map($ubicaciones, 'staff_area_id','descripcion','codigo');
    }
    
    
    public function getContratoContratos()
    {
        return $this->hasMany(ContratoContrato::className(), ['area_contratante' => 'staff_area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratoContratos0()
    {
        return $this->hasMany(ContratoContrato::className(), ['area_responsable' => 'staff_area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonaResponsable()
    {
        return $this->hasOne(StaffPersona::className(), ['staff_persona_id' => 'responsable']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaSuperior()
    {
        return $this->hasOne(StaffArea::className(), ['staff_area_id' => 'area_superior']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffAreas()
    {
        return $this->hasMany(StaffArea::className(), ['area_superior' => 'staff_area_id']);
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
             if(Yii::$app->user->isGuest)
                return false;
             
            $this->actualizado_por= Yii::$app->user->identity->usuario_id;

            if (isset($this->autocomplete_staff_persona)) {
                $this->responsable = StaffPersona::getIdByDniNombre($this->autocomplete_staff_persona);
            }
            
             
            $this->actualizado_en = date('Y-m-d H:i:s');
            if ($this->isNewRecord) {
                $this->creado_por = Yii::$app->user->identity->usuario_id;
                $this->creado_en = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }
    
    //para tener un registro unico con nombre
    public function getUnaPersona($responsable)
    {
        return StaffPersona::find()->where(['staff_persona_id' => $responsable])->one();
    }
}
