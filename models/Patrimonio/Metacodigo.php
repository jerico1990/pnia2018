<?php

namespace app\models\Patrimonio;

use app\models\Auditoria\Usuario;
use \yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "metacodigo".
 *
 * @property int $metacodigo_id
 * @property string $nombre_lista
 * @property int $codigo
 * @property string $descripcion
 * @property string $descripcion2
 * @property string $creado_en
 * @property int $creado_por
 * @property string $actualizado_en
 * @property int $actualizado_por
 *
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 * @property PatrimonioInventario[] $patrimonioInventarios
 * @property PatrimonioItem[] $patrimonioItems
 * @property PatrimonioMovimiento[] $patrimonioMovimientos
 * @property PatrimonioValorizacion[] $patrimonioValorizacions
 */
class Metacodigo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metacodigo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'creado_por', 'actualizado_por'], 'default', 'value' => null],
            [['codigo', 'creado_por', 'actualizado_por'], 'integer'],
            //[['creado_por','actualizado_por'], 'required'],
            [['creado_en', 'actualizado_en'], 'safe'],
            [['nombre_lista', 'descripcion', 'descripcion2'], 'string', 'max' => 255],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            //[['nombre_lista','codigo'],'unique']
            ///// esto debe cambiar para verificar que nombre_lista+codigo ("concatenados") deben ser unico
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'metacodigo_id' => Yii::t('app', 'Metacodigo ID'),
            'nombre_lista' => Yii::t('app', 'Nombre de la Lista'),
            'codigo' => Yii::t('app', 'Código'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'descripcion2' => Yii::t('app', 'Descripción (Adicional)'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function findById($id){
        return static::findOne(['metacodigo_id'=>$id]);
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
        return $this->hasMany(PatrimonioInventario::className(), ['metacodigo_id' => 'metacodigo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioItems()
    {
        return $this->hasMany(PatrimonioItem::className(), ['metacodigo_id' => 'metacodigo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioMovimientos()
    {
        return $this->hasMany(PatrimonioMovimiento::className(), ['metacodigo_id' => 'metacodigo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioValorizacions()
    {
        return $this->hasMany(PatrimonioValorizacion::className(), ['metacodigo_id' => 'metacodigo_id']);
    }
    
    /**
     * [getComboBoxList description]
     * @param  [type] $nombre_lista [description]
     * @return [modelo_metacodigo]               [description]
     */
    static function getComboBoxList($nombre_lista){
        return Metacodigo::find()->where([ 'nombre_lista' => $nombre_lista ])->all();
    }

    /**
     * [getComboBoxItems description]
     * @param  [type] $nombre_lista [description]
     * @return [type]               [description]
     */
    static function getComboBoxItems($nombre_lista){
        $items  = Metacodigo::find()->where([ 'nombre_lista' => $nombre_lista ])->all();
        return ArrayHelper::map($items, 'metacodigo_id', 'descripcion');
    }
    
    public function getMetacodigoLista() {
        return static::find()->all();
    }
    
    static function getMetacodigoIdPorNombre($nombre_lista){
        return Metacodigo::find()->where([ 'descripcion' => $nombre_lista ])->one(); 
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

    static function getMetacodigoId($nombre_lista, $descripcion){
        $metacodigo_id  = Metacodigo::find()->where([ 'nombre_lista' => $nombre_lista, 'descripcion' => $descripcion])->one();
        return $metacodigo_id->metacodigo_id;
    }

    /**
     * @param $tipo_flujo_descripcion : definida en Params tipoFlujo
     */
    static function getFlujoMetacodigoId($tipo_flujo_descripcion){
        Metacodigo::getMetacodigoId(
            Yii::$app->params['metacodigoFlags']['Tipo_flujo'],
            Yii::$app->params['tipoFlujo'][$tipo_flujo_descripcion]);
    }
}
