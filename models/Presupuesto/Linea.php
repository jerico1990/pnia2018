<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "linea".
 *
 * @property int $linea_id
 * @property string $titulo
 * @property string $numeracion
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property LineaNivel[] $lineaNivels
 */
class Linea extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linea';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actualizado_en', 'creado_en'], 'safe'],
            [['actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['actualizado_por', 'creado_por'], 'integer'],
            [['titulo', 'numeracion'], 'string', 'max' => 255],
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
            'linea_id' => 'Linea ID',
            'titulo' => 'Titulo',
            'numeracion' => 'Numeracion',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
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
    public function getLineaNivels()
    {
        return $this->hasMany(LineaNivel::className(), ['linea_id' => 'linea_id']);
    }

    /**
     * @return array(linea_id => titulo)
     */
    static function getComboBoxItems(){
        $items  = Linea::find()->all();
        $array = [];
        foreach ($items as $actual_item){
            $array[$actual_item->linea_id] = $actual_item->titulo;
        }
        return $array;
    }
}
