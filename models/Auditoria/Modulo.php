<?php

namespace app\models\Auditoria;
use app\models\Auditoria\ProcesoSearch;

use Yii;

/**
 * This is the model class for table "modulo".
 *
 * @property int $modulo_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property Proceso[] $procesos
 */
class Modulo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modulo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion'], 'required'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['actualizado_por', 'creado_por'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 255],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
        ];
    }

    public function findById($id){
        return static::findOne(['modulo_id'=>$id]);
    }

    public function getModulos() 
    {  
        return static::find()->all();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'modulo_id' => 'Modulo ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
            'procesos' => 'Mis Procesos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function setActualizadoPor($fecha)
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'actualizado_por']);
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
    public function getProcesos()
    {
        return $this->hasMany(Proceso::className(), ['modulo_id' => 'modulo_id']);
    }
    
    public function getSearchProcesos()
    {
        $searchModelProcesos = new ProcesoSearch();
        return $searchModelProcesos;
    }

    public function getDataProviderProcesos()
    {
        $searchModelProcesos = new ProcesoSearch();
        $dataProviderProcesos = $searchModelProcesos->search(Yii::$app->request->queryParams);
        return $dataProviderProcesos;
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
