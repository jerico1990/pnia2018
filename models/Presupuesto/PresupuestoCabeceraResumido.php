<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "presupuesto_cabecera".
 *
 * @property int $presupuesto_cabecera_id
 * @property int $presupuesto_version_id
 * @property int $linea_nivel_id
 * @property int $partida_id
 * @property int $presupuesto_cabecera_padre_id
 * @property int $presupuesto_cabecera_id_original
 * @property int $jerarquia
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ArbolArea[] $arbolAreas
 * @property FlujoRequerimiento[] $flujoRequerimientos
 * @property Presupuesto[] $presupuestos
 * @property LineaNivel $lineaNivel
 * @property Partida $partida
 * @property PresupuestoCabeceraResumido $presupuestoCabeceraPadre
 * @property PresupuestoCabeceraResumido[] $presupuestoCabeceraResumidos
 * @property PresupuestoVersion $presupuestoVersion
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class PresupuestoCabeceraResumido extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'presupuesto_cabecera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['presupuesto_version_id', 'linea_nivel_id', 'actualizado_por', 'creado_por'], 'required'],
            [['presupuesto_version_id', 'linea_nivel_id', 'partida_id', 'presupuesto_cabecera_padre_id', 'presupuesto_cabecera_id_original', 'jerarquia', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['presupuesto_version_id', 'linea_nivel_id', 'partida_id', 'presupuesto_cabecera_padre_id', 'presupuesto_cabecera_id_original', 'jerarquia', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['linea_nivel_id'], 'exist', 'skipOnError' => true, 'targetClass' => LineaNivel::className(), 'targetAttribute' => ['linea_nivel_id' => 'linea_nivel_id']],
            [['partida_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partida::className(), 'targetAttribute' => ['partida_id' => 'partida_id']],
            [['presupuesto_cabecera_padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => PresupuestoCabeceraResumido::className(), 'targetAttribute' => ['presupuesto_cabecera_padre_id' => 'presupuesto_cabecera_id']],
            [['presupuesto_version_id'], 'exist', 'skipOnError' => true, 'targetClass' => PresupuestoVersion::className(), 'targetAttribute' => ['presupuesto_version_id' => 'presupuesto_version_id']],
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
            'presupuesto_cabecera_id' => 'Presupuesto Cabecera ID',
            'presupuesto_version_id' => 'Presupuesto Version ID',
            'linea_nivel_id' => 'Linea Nivel ID',
            'partida_id' => 'Partida ID',
            'presupuesto_cabecera_padre_id' => 'Presupuesto Cabecera Padre ID',
            'presupuesto_cabecera_id_original' => 'Presupuesto Cabecera Id Original',
            'jerarquia' => 'Jerarquia',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArbolAreas()
    {
        return $this->hasMany(ArbolArea::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlujoRequerimientos()
    {
        return $this->hasMany(FlujoRequerimiento::className(), ['codigo_arbol' => 'presupuesto_cabecera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestos()
    {
        return $this->hasMany(Presupuesto::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineaNivel()
    {
        return $this->hasOne(LineaNivel::className(), ['linea_nivel_id' => 'linea_nivel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartida()
    {
        return $this->hasOne(Partida::className(), ['partida_id' => 'partida_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoCabeceraPadre()
    {
        return $this->hasOne(PresupuestoCabeceraResumido::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_padre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoCabeceraResumidos()
    {
        return $this->hasMany(PresupuestoCabeceraResumido::className(), ['presupuesto_cabecera_padre_id' => 'presupuesto_cabecera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoVersion()
    {
        return $this->hasOne(PresupuestoVersion::className(), ['presupuesto_version_id' => 'presupuesto_version_id']);
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

    public $esta_actualizado = false;

    public function afterSave($insert, $changedAttributes)
    {
        if (!$this->esta_actualizado){
            $this->esta_actualizado = true;
            $this->presupuesto_cabecera_id_original = $this->presupuesto_cabecera_id;
            parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
            return true;
        }

    }
}
