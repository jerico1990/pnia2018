<?php

namespace app\models\Patrimonio;

use app\models\Auditoria\Usuario;

use Yii;

/**
 * This is the model class for table "patrimonio_clase".
 *
 * @property int $patrimonio_clase_id
 * @property int $patrimonio_clase_padre_id
 * @property string $nombre
 * @property string $codigo
 * @property double $tasa_depreciacion
 * @property string $creado_en
 * @property int $creado_por
 * @property string $actualizado_en
 * @property int $actualizado_por
 *
 * @property PatrimonioClase $patrimonioClasePadre
 * @property PatrimonioClase[] $patrimonioClases
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 * @property PatrimonioItem[] $patrimonioItems
 */
class PatrimonioClase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patrimonio_clase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patrimonio_clase_padre_id', 'creado_por', 'actualizado_por'], 'default', 'value' => null],
            [['patrimonio_clase_padre_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['nombre', 'codigo', 'tasa_depreciacion'], 'required'],
            [['tasa_depreciacion'], 'number'],
            [['creado_en', 'actualizado_en'], 'safe'],
            [['nombre', 'codigo'], 'string', 'max' => 255],
            [['patrimonio_clase_padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioClase::className(), 'targetAttribute' => ['patrimonio_clase_padre_id' => 'patrimonio_clase_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            ['nombre','unique'],
            ['codigo','validar']
        ];
    }
    public function attributeLabels()
    {
        return [
            'patrimonio_clase_id' => Yii::t('app', 'Patrimonio Clase ID'),
            'patrimonio_clase_padre_id' => Yii::t('app', 'Patrimonio Clase Padre ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'codigo' => Yii::t('app', 'Código'),
            'tasa_depreciacion' => Yii::t('app', 'Tasa Depreciación'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
        ];
    }
    
    public function validar($codigo){

        $objeto_a_usar = new PatrimonioClase();
        if($this->patrimonio_clase_id)
            if($objeto_a_usar->findByCodigo($this->codigo))
                return;
            else
                $this->addError($codigo,'No se puede editar el código');
        else
            $this->validarCodigo($codigo,$objeto_a_usar);
    }

    

    public function validarCodigo($codigo,$objeto_a_usar){
        $temporal = $objeto_a_usar;
        $padre_id=$this->patrimonio_clase_padre_id;

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
    public function getPatrimonioClasePadre()
    {
        return $this->hasOne(PatrimonioClase::className(), ['patrimonio_clase_id' => 'patrimonio_clase_padre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioClases()
    {
        return $this->hasMany(PatrimonioClase::className(), ['patrimonio_clase_padre_id' => 'patrimonio_clase_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioItems()
    {
        return $this->hasMany(PatrimonioItem::className(), ['patrimonio_clase_id' => 'patrimonio_clase_id']);
    }

    public function getPatrimoniosClases() 
    {  
        return static::find()->orderBy('codigo')->all();
    }

    public function findById($id){
        return static::findOne(['patrimonio_clase_id'=>$id]);
    }

    public function findByCodigo($codigo){
        return static::findOne(['codigo'=>$codigo]);
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
