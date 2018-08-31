<?php

namespace app\models\Presupuesto;

use app\models\Auditoria\Usuario;
use app\models\ModeloGenerico;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categoria_producto".
 *
 * @property int $categoria_producto_id
 * @property string $categoria_producto_descripcion
 * @property int $es_categoria
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
class CategoriaProducto extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria_producto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado_regitro', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['estado_regitro', 'actualizado_por', 'creado_por','es_categoria'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['categoria_producto_descripcion'], 'string', 'max' => 255],
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
            'categoria_producto_id' => 'Categoria Producto ID',
            'categoria_producto_descripcion' => 'Categoria Producto Descripción',
            'es_categoria' => 'Categoria/Producto',
            'estado_regitro'  => 'Estado Regitro',
            'actualizado_en'  => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en'  => 'Creado En',
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
        return $this->hasMany(PresupuestoCabecera::className(), ['categoria_producto_id' => 'categoria_producto_id']);
    }

    static function getComboBoxItems($es_categoria){
        return ArrayHelper::map(CategoriaProducto::find()->where(['es_categoria'=>$es_categoria])->all(),'categoria_producto_id','categoria_producto_descripcion');
    }
}
