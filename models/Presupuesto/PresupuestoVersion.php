<?php

namespace app\models\Presupuesto;
use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "presupuesto_version".
 *
 * @property int $presupuesto_version_id
 * @property int $nro_version
 * @property int $estatus
 * @property string $fecha
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 * @property string $descripcion
 * @property string $detalle
 *
 * @property PresupuestoCabecera[] $presupuestoCabeceras
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class PresupuestoVersion extends ModeloGenerico
{

    public $version_previa_id; /// en funcionamiento actual hace que si es null se haga una copia vacia

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'presupuesto_version';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nro_version'], 'required'],
            [['descripcion'], 'string', 'max' => 255],
            [['detalle'], 'string', 'max' => 500],
            [['nro_version', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['nro_version', 'estatus', 'actualizado_por', 'creado_por','version_previa_id'], 'integer'],
            [['fecha', 'actualizado_en', 'creado_en'], 'safe'],
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
            'presupuesto_version_id' => 'Id Versión',
            'nro_version' => 'Nro. Versión',
            'fecha' => 'Fecha',
            'actualizado_en'  => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en'  => 'Creado En',
            'creado_por' => 'Creado Por',
            'estatus'    => 'Estatus',
            'version_previa_id' => 'Origen de la Copia',
            'descripcion' => 'Descripción',
            'detalle'     => 'Detalle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoCabeceras()
    {
        return $this->hasMany(PresupuestoCabecera::className(), ['presupuesto_version_id' => 'presupuesto_version_id']);
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

    /*
    public function getVersionAnterior(){
        return PresupuestoVersion::find()->where('presupuesto_version_id < '.$this->presupuesto_version_id)->orderBy(['presupuesto_version_id' => SORT_DESC])->one();
        //return PresupuestoVersion::find()->where('nro_version < '.$this->nro_version)->orderBy(['nro_version' => SORT_ASC])->one();
    }// */

    static function getUltimaVersion($desde_session = false){
        if ($desde_session AND isset($_SESSION['version_busqueda']) AND $_SESSION['version_busqueda'] != null
         AND $_SESSION['version_busqueda'] != ''
        ){
            //return PresupuestoVersion::find()->where('presupuesto_version_id = '.$_SESSION['version_busqueda'])->one();
            return PresupuestoVersion::find()->where('estatus > 0')->one();
        }else{
            return PresupuestoVersion::find()->where('estatus > 0')->one();
        }
    }

    public function getTextoEstatus(){
        if ($this->estatus == 1){
            return 'Activo';
        }elseif ($this->estatus == 2){
            return 'En Edición';
        }else{
            return 'Inactivo';
        }
    }

    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
            if (Yii::$app->user->isGuest) {
                return false;
            }

            $this->actualizado_por= Yii::$app->user->identity->usuario_id;
            $this->actualizado_en = date('Y-m-d H:i:s');
            if ($this->isNewRecord) {
                $this->creado_por = Yii::$app->user->identity->usuario_id;
                $this->creado_en = date('Y-m-d H:i:s');
            }

            if ($this->estatus == 1){
                $activo_actual = PresupuestoVersion::getUltimaVersion();
                if ($activo_actual != null AND
                    $activo_actual->presupuesto_version_id != $this->presupuesto_version_id){
                    $activo_actual->estatus = 0;
                    $activo_actual->save();
                }
            }elseif ( PresupuestoVersion::getUltimaVersion() == null ){
                $this->estatus = 1;
            }

            return true;
        }
        return false;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert){

            if ($this->version_previa_id == null){
                return false;
            }

            $presupuestos_cabecera = PresupuestoCabecera::findAll([
                        'presupuesto_cabecera_padre_id' => null,
                        'presupuesto_version_id' => $this->version_previa_id
                        ]);

            foreach ($presupuestos_cabecera as $presupuesto_iterador){
                PresupuestoCabecera::guardarNuevaVersionTotal($presupuesto_iterador->presupuesto_cabecera_id, $this->presupuesto_version_id);
            }

            parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
            return true;
        }

        return false;
    }

    static function getComboBoxItems(){
        return ArrayHelper::map(PresupuestoVersion::find()->all(),'presupuesto_version_id','nro_version');
    }


}
