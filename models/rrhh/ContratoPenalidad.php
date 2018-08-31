<?php

namespace app\models\rrhh;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\ModeloGenerico;
use app\models\Presupuesto\PresupuestoCabecera;
use app\models\Presupuesto\Periodo;
use Yii;

/**
 * This is the model class for table "contrato_penalidad".
 *
 * @property int $contrato_penalidad_id
 * @property int $codigo_contrato
 * @property string $descripcion
 * @property double $monto_penalidad
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ContratoContrato $codigoContrato
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 */
class ContratoPenalidad extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contrato_penalidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_contrato', 'actualizado_por', 'creado_por'], 'integer'],
            [['descripcion'], 'string'],
            [['monto_penalidad'], 'number'],
            [['actualizado_en', 'creado_en'], 'safe'],
            //[['actualizado_por', 'creado_por'], 'required'],
            [['codigo_contrato'], 'exist', 'skipOnError' => true, 'targetClass' => ContratoContrato::className(), 'targetAttribute' => ['codigo_contrato' => 'contrato_contrato_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['staff_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffArea::className(), 'targetAttribute' => ['staff_area_id' => 'staff_area_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contrato_penalidad_id' => Yii::t('app', 'Contrato Penalidad ID'),
            'codigo_contrato' => Yii::t('app', 'Código Contrato'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'monto_penalidad' => Yii::t('app', 'Monto Penalidad'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'codigo_arbol' => 'Rama presupuesto',
            'periodo_id' => 'Periodo',
            'staff_area_id' => 'Área aprobadora'

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigoContrato()
    {
        return $this->hasOne(ContratoContrato::className(), ['contrato_contrato_id' => 'codigo_contrato']);
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
    public function getActualizadoPor()
    {
        return $this->hasOne(Usuario::className(), ['usuario_id' => 'actualizado_por']);
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
