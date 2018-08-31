<?php

namespace app\models;

use app\models\Auditoria\Usuario;

use Yii;

/**
 * This is the model class for table "mensaje".
 *
 * @property int $mensaje_id
 * @property string $titulo
 * @property string $mensaje
 * @property int $usuario_id_de
 * @property int $usuario_id_para
 * @property string $status
 * @property string $creado_en
 *
 * @property Usuario $usuarioIdDe
 * @property Usuario $usuarioIdPara
 */
class Mensaje extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mensaje';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mensaje'], 'string'],
            [['usuario_id_de', 'status'], 'required'],
            [['usuario_id_de', 'usuario_id_para'], 'integer'],
            [['creado_en'], 'safe'],
            [['titulo'], 'string', 'max' => 200],
            [['status'], 'string', 'max' => 30],
            [['usuario_id_de'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id_de' => 'usuario_id']],
            [['usuario_id_para'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id_para' => 'usuario_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mensaje_id' => 'Mensaje ID',
            'titulo' => 'Titulo',
            'mensaje' => 'Mensaje',
            'usuario_id_de' => 'De',
            'usuario_id_para' => 'Para',
            'status' => 'Status',
            'creado_en' => 'Creado En',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDe()
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'usuario_id_de']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioPara()
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'usuario_id_para']);
    }
}
