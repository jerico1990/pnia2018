<?php

namespace app\models\Presupuesto;
use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "periodo".
 *
 * @property int $periodo_id
 * @property int $anho
 * @property int $trimestre
 * @property int $mes
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 * @property int $estatus_abierto
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property Presupuesto[] $presupuestos
 */
class Periodo extends ModeloGenerico
{
    public $periodo;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'periodo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['anho', 'trimestre', 'mes',], 'required'],
            [['anho', 'trimestre', 'mes', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['anho', 'trimestre', 'mes', 'actualizado_por', 'creado_por','estatus_abierto',], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
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
            'periodo_id' => 'Periodo ID',
            'anho' => 'Anho',
            'mes'  => 'Mes',
            'trimestre'  => 'Trimestre',
            'creado_en'  => 'Creado En',
            'creado_por' => 'Creado Por',
            'estatus_abierto'   => 'Estatus',
            'actualizado_en'    => 'Actualizado En',
            'actualizado_por'   => 'Actualizado Por',
        ];
    }

    public function getDisplayText(){
        return $this->anho.'-'.$this->mes ;
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
    public function getPresupuestos()
    {
        return $this->hasMany(Presupuesto::className(), ['periodo_id' => 'periodo_id']);
    }

    static function getComboBoxItems(){
        $items  = Periodo::find()->all();
        $array = [];
        foreach ($items as $actual_item){
            $array[$actual_item->periodo_id] = $actual_item->getDisplayText();
        }
        return $array;
    }

    static function getComboBoxItemsAnhos(){
        $items  = Periodo::find()->where(['mes'=>1])->orderBy('anho')->all();

        return ArrayHelper::map($items,'anho','anho'); /*
        $array = [];
        foreach ($items as $actual_item){
            $array[$actual_item->periodo_id] = $actual_item->getDisplayText();
        }
        return $array; // */
    }
}
