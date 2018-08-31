<?php

namespace app\models\Presupuesto;
use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "partida".
 *
 * @property int $partida_id
 * @property string $numero
 * @property string $descripcion
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property PresupuestoCabecera[] $presupuestoCabeceras
 */
class Partida extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partida';
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
            [['numero', 'descripcion'], 'string', 'max' => 255],
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
            'partida_id' => 'Partida ID',
            'descripcion' => 'Nombre de la Partida Presupuestal',
            'numero' => 'Código de Patida (Numeración)',
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
    public function getPresupuestoCabeceras()
    {
        return $this->hasMany(PresupuestoCabecera::className(), ['partida_id' => 'partida_id']);
    }

    static function getComboBoxItems(){
        $items  = Partida::find()->all();
        return ArrayHelper::map($items, 'partida_id', 'descripcion');
    }
}
