<?php

namespace app\models\Viatico;
use app\models\Auditoria\Usuario;
use \yii\helpers\ArrayHelper;
use app\models\ModeloGenerico; 
use Yii;

/**
 * This is the model class for table "arbol_pnia".
 *
 * @property int $arbol_pnia_id
 * @property string $descripcion
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property FlujoRequerimiento[] $flujoRequerimientos
 */
class ArbolPnia extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arbol_pnia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actualizado_en', 'creado_en'], 'safe'],
            // [['actualizado_por', 'creado_por'], 'required'],
            [['actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['actualizado_por', 'creado_por'], 'integer'],
            [['descripcion'], 'string', 'max' => 255],
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
            'arbol_pnia_id' => 'Arbol Pnia ID',
            'descripcion' => 'Descripción',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    static function getComboBoxItems(){
        $items  = ArbolPnia::find()->all();
        return ArrayHelper::map($items, 'arbol_pnia_id', 'descripcion');
    }

    public function getArbolesPnia() 
    {  
        return static::find()->orderBy(['descripcion' => SORT_ASC])->all();
    }

    public static function findById($id){
        return static::findOne(['arbol_pnia_id' => $id]);
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
     * @return \yii\db\ActiveQuery
     */
    public function getFlujoRequerimientos()
    {
        return $this->hasMany(FlujoRequerimiento::className(), ['codigo_arbol' => 'arbol_pnia_id']);
    }
}
