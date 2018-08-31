<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "accion_estrategica".
 *
 * @property int $accion_estrategica_id
 * @property string $accion_descripcion
 * @property int $estado_regitro
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property PresupuestoCabecera[] $presupuestoCabeceras
 */
class AccionEstrategica extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accion_estrategica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado_regitro', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['estado_regitro', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['accion_descripcion'], 'string', 'max' => 255],
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
            'accion_estrategica_id' => 'Accion Estrategica ID',
            'accion_descripcion' => 'Descripción',
            'estado_regitro' => 'Estado',
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
        return $this->hasMany(PresupuestoCabecera::className(), ['accion_estrategica_id' => 'accion_estrategica_id']);
    }


    static function getComboBoxItems(){
        return ArrayHelper::map(AccionEstrategica::find()->all(),'accion_estrategica_id','accion_descripcion');
    }
}
