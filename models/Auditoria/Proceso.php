<?php

namespace app\models\Auditoria;

use Yii;

/**
 * This is the model class for table "proceso".
 *
 * @property int $proceso_id
 * @property int $modulo_id
 * @property string $descripcion
 * @property string $url_accion
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Modulo $modulo
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property RolProceso[] $rolProcesos
 */
class Proceso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proceso';
    }

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['modulo_id', 'nombre', 'descripcion', 'url_accion'], 'required'],
            [['modulo_id', 'descripcion', 'url_accion'], 'required'],
            [['modulo_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['descripcion', 'url_accion'], 'string', 'max' => 255],
            [['modulo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Modulo::className(), 'targetAttribute' => ['modulo_id' => 'modulo_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'proceso_id' => 'Proceso ID',
            'modulo_id' => 'Módulo',
            'descripcion' => 'Descripción',
            'url_accion' => 'Url Accion',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    public function getPermiso($id){
        $permisoUrlAction   = Proceso::find()->select('url_accion')
            ->where(['proceso_id' => 1])
            //->andWhere(['status' => 'active','approved' => 'active'])
            ->asArray()    
            ->all();
        $permisoUrlAction0 = array_shift($permisoUrlAction);
        return array_shift($permisoUrlAction0);
    }

    public function getTodosLosProcesos()
    {
        return $this->find()->all();
    }

    public function getTodosLosProcesosComoArrayMapeado() {
        
        $listaProcesos   = Proceso::find()->select('proceso_id, descripcion, url_accion')
            //->where(['is_subcategory' => 'Yes'])
            //->andWhere(['status' => 'active','approved' => 'active'])
            ->all();
        $listaFinalProcesos   = \yii\helpers\ArrayHelper::map( $listaProcesos, 'proceso_id','descripcion');
        //$listaFinalProcesos   = \yii\helpers\ArrayHelper::toArray($listaProcesos);
        return $listaFinalProcesos;
    }
    public function getProcesosDelModulo($id){
        return $this->findAll(['modulo_id' => $id]);
    }

    public function findById($id){
        return static::findOne(['proceso_id' => $id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModulo()
    {
        return $this->hasOne(Modulo::className(), ['modulo_id' => 'modulo_id']);
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
    public function getRolProcesos()
    {
        return $this->hasMany(RolProceso::className(), ['proceso_id' => 'proceso_id']);
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
