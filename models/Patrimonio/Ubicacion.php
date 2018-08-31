<?php

namespace app\models\Patrimonio;

use app\models\Auditoria\Usuario;

use Yii;

/**
 * This is the model class for table "ubicacion".
 *
 * @property int $ubicacion_id
 * @property int $ubicacion_padre_id
 * @property string $nombre
 * @property string $codigo
 * @property string $descripcion
 * @property string $creado_en
 * @property int $creado_por
 * @property string $actualizado_en
 * @property int $actualizado_por
 *
 * @property PatrimonioInventario[] $patrimonioInventarios
 * @property PatrimonioMovimiento[] $patrimonioMovimientos
 * @property PatrimonioMovimiento[] $patrimonioMovimientos0
 * @property Ubicacion $ubicacionPadre
 * @property Ubicacion[] $ubicacions
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 */
class Ubicacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ubicacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ubicacion_padre_id'], 'default', 'value' => null],
            [['ubicacion_padre_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['nombre', 'codigo' , 'descripcion'], 'required'],
            [['creado_en', 'actualizado_en'], 'safe'],
            [['nombre', 'codigo', 'descripcion'], 'string', 'max' => 255],
            [['ubicacion_padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ubicacion::className(), 'targetAttribute' => ['ubicacion_padre_id' => 'ubicacion_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            ['codigo','validar']
        ];
    }

    public function attributeLabels()
    {
        return [
            'ubicacion_id' => Yii::t('app', 'Ubicación'),
            'ubicacion_padre_id' => Yii::t('app', 'Ubicación Padre'),
            'nombre' => Yii::t('app', 'Nombre'),
            'codigo' => Yii::t('app', 'Código'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
        ];
    }
    
    public function validar($codigo){
        $objeto_a_usar = new Ubicacion();
        if($this->ubicacion_id)
            if($objeto_a_usar->findByCodigo($this->codigo))
                return;
            else
                $this->addError($codigo,'No se puede editar el código');
        else
            $this->validarCodigo($codigo,$objeto_a_usar);
    }

    public function validarCodigo($codigo,$objeto_a_usar){
        $temporal = $objeto_a_usar;
        $padre_id=$this->ubicacion_padre_id;

        if($padre_id!=""){
            $padre = $temporal->findById($padre_id); 
            $codigo_padre = $padre->codigo;
            $codigo_hijo = $this->$codigo;
            $codigo_concatenado = $codigo_padre.".".$codigo_hijo;
            if($temporal->findByCodigo($codigo_concatenado))
                $this->addError($codigo,'Código ya existe en '.$padre->nombre);
            else
                $this->codigo=$codigo_concatenado;
        }
        else if($temporal->findByCodigo($this->codigo)){
            $this->addError($codigo,'Código ya existe');
        }
    }

    /**
     * @inheritdoc
     */
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioInventarios()
    {
        return $this->hasMany(PatrimonioInventario::className(), ['ubicacion_id' => 'ubicacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioMovimientos()
    {
        return $this->hasMany(PatrimonioMovimiento::className(), ['ubicacion_inicial_id' => 'ubicacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioMovimientos0()
    {
        return $this->hasMany(PatrimonioMovimiento::className(), ['ubicacion_final_id' => 'ubicacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacionPadre()
    {
        return $this->hasOne(Ubicacion::className(), ['ubicacion_id' => 'ubicacion_padre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacions()
    {
        return $this->hasMany(Ubicacion::className(), ['ubicacion_padre_id' => 'ubicacion_id']);
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

    public function findById($id){
        return static::findOne(['ubicacion_id'=>$id]);
    }

    public function findByCodigo($codigo){
        return static::findOne(['codigo'=>$codigo]);
    }

    public function codigoExiste($codigo){
        $tmp = static::findOne(['codigo'=>$codigo]);
        return $tmp?true:false;
    }

    public function getUbicaciones() 
    {  
        return static::find()->orderBy(['codigo' => SORT_ASC])->all();
    }

    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
             if(!Yii::$app->user->isGuest)
             {
                 $this->actualizado_por= Yii::$app->user->identity->usuario_id;
             }
             else
             {
                 return false;
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
}
