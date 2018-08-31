<?php

namespace app\models\Presupuesto;
use app\models\Auditoria\Usuario;
use app\models\rrhh\ContratoContrato;
use app\models\Patrimonio\Metacodigo;
use app\models\Patrimonio\DocumentoPnia;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "logistica_proceso".
 *
 * @property int $logistica_proceso_id
 * @property int $proyecto_id
 * @property string $nombre
 * @property string $codigo
 * @property int $componente_id
 * @property double $monto_rooc_bm
 * @property double $monto_rooc_bid
 * @property double $monto_ro
 * @property double $monto_total
 * @property int $categoria
 * @property int $tipo
 * @property string $tdr_plan
 * @property string $tdr_real
 * @property string $expresion_plan
 * @property string $expresion_real
 * @property string $evaluacion_plan
 * @property string $evaluacion_real
 * @property string $notificacion_plan
 * @property string $notificacion_real
 * @property string $firma_plan
 * @property string $firma_real
 * @property string $adenda_plan
 * @property string $adenda_real
 * @property string $termino_plan
 * @property string $termino_real
 * @property int $estado
 * @property int $documento_pnia_id
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ContratoContrato $logisticaProceso
 * @property DocumentoPnia $documentoPnia
 * @property Metacodigo $categoria0
 * @property Metacodigo $tipo0
 * @property Metacodigo $estado0
 * @property Proyecto $proyecto
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 */
class LogisticaProceso extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logistica_proceso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proyecto_id', 'componente_id', 'categoria', 'tipo', 'estado'], 'required'],
            [['proyecto_id', 'componente_id', 'categoria', 'tipo', 'estado', 'documento_pnia_id', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['proyecto_id', 'componente_id', 'categoria', 'tipo', 'estado', 'documento_pnia_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['monto_rooc_bm', 'monto_rooc_bid', 'monto_ro', 'monto_total'], 'number'],
            [['tdr_plan', 'tdr_real', 'expresion_plan', 'expresion_real', 'evaluacion_plan', 'evaluacion_real', 'notificacion_plan', 'notificacion_real', 'firma_plan', 'firma_real', 'adenda_plan', 'adenda_real', 'termino_plan', 'termino_real', 'actualizado_en', 'creado_en'], 'safe'],
            [['nombre', 'codigo'], 'string', 'max' => 255],
            [['logistica_proceso_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContratoContrato::className(), 'targetAttribute' => ['logistica_proceso_id' => 'contrato_contrato_id']],
            [['documento_pnia_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentoPnia::className(), 'targetAttribute' => ['documento_pnia_id' => 'documento_pnia_id']],
            [['categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['categoria' => 'metacodigo_id']],
            [['tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['tipo' => 'metacodigo_id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['estado' => 'metacodigo_id']],
            [['proyecto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proyecto::className(), 'targetAttribute' => ['proyecto_id' => 'proyecto_id']],
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
            'logistica_proceso_id' => 'Logistica Proceso ID',
            'proyecto_id' => 'Proyecto ID',
            'nombre' => 'Nombre',
            'codigo' => 'Codigo',
            'componente_id' => 'Componente ID',
            'monto_rooc_bm' => 'Monto Rooc Bm',
            'monto_rooc_bid' => 'Monto Rooc Bid',
            'monto_ro' => 'Monto Ro',
            'monto_total' => 'Monto Total',
            'categoria' => 'Categoria',
            'tipo' => 'Tipo',
            'tdr_plan' => 'Tdr Plan',
            'tdr_real' => 'Tdr Real',
            'expresion_plan' => 'Expresion Plan',
            'expresion_real' => 'Expresion Real',
            'evaluacion_plan' => 'Evaluacion Plan',
            'evaluacion_real' => 'Evaluacion Real',
            'notificacion_plan' => 'Notificacion Plan',
            'notificacion_real' => 'Notificacion Real',
            'firma_plan' => 'Firma Plan',
            'firma_real' => 'Firma Real',
            'adenda_plan' => 'Adenda Plan',
            'adenda_real' => 'Adenda Real',
            'termino_plan' => 'Termino Plan',
            'termino_real' => 'Termino Real',
            'estado' => 'Estado',
            'documento_pnia_id' => 'Documento Pnia ID',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogisticaProceso()
    {
        return $this->hasOne(ContratoContrato::className(), ['contrato_contrato_id' => 'logistica_proceso_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentoPnia()
    {
        return $this->hasOne(DocumentoPnia::className(), ['documento_pnia_id' => 'documento_pnia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria0()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo0()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyecto()
    {
        return $this->hasOne(Proyecto::className(), ['proyecto_id' => 'proyecto_id']);
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
}
