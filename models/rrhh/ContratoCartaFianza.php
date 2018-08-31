<?php

namespace app\models\rrhh;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\ModeloGenerico;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "contrato_carta_fianza".
 *
 * @property int $contrato_carta_fianza_id
 * @property string $codigo_interno
 * @property int $entidad_emisora
 * @property int $entidad_afianzada
 * @property int $contrato
 * @property string $periodo_inicio
 * @property string $periodo_fin
 * @property double $monto
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property PniaEntFinanciera $entidadEmisora
 * @property PniaEntidad $entidadAfianzada
 * @property ContratoContrato $contrato0
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 */
class ContratoCartaFianza extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contrato_carta_fianza';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_interno'], 'string'],
            [['entidad_emisora', 'entidad_afianzada', 'contrato', 'actualizado_por', 'creado_por'], 'integer'],
            [['periodo_inicio', 'periodo_fin', 'actualizado_en', 'creado_en'], 'safe'],
            [['monto'], 'number'],
            // [['actualizado_por', 'creado_por'], 'required'],
            [['entidad_emisora'], 'exist', 'skipOnError' => true, 'targetClass' => PniaEntFinanciera::className(), 'targetAttribute' => ['entidad_emisora' => 'pnia_ent_financiera_id']],
            [['entidad_afianzada'], 'exist', 'skipOnError' => true, 'targetClass' => PniaEntidad::className(), 'targetAttribute' => ['entidad_afianzada' => 'pnia_entidad_id']],
            [['contrato'], 'exist', 'skipOnError' => true, 'targetClass' => ContratoContrato::className(), 'targetAttribute' => ['contrato' => 'contrato_contrato_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            ['codigo_interno','unique'],
            [['periodo_inicio', 'periodo_fin'], 'required'],
            ['periodo_fin', 'compare', 'compareAttribute' => 'periodo_inicio', 'operator' => '>'],
            [['periodo_inicio', 'periodo_fin'], 'validarPeriodo']
             
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contrato_carta_fianza_id' => Yii::t('app', 'Contrato Carta Fianza ID'),
            'codigo_interno' => Yii::t('app', 'Código Interno'),
            'entidad_emisora' => Yii::t('app', 'Entidad Emisora'),
            'entidad_afianzada' => Yii::t('app', 'Entidad Afianzada'),
            'contrato' => Yii::t('app', 'Contrato'),
            'periodo_inicio' => Yii::t('app', 'Periodo Inicio'),
            'periodo_fin' => Yii::t('app', 'Periodo Fin'),
            'monto' => Yii::t('app', 'Monto'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
        ];
    }

    public function validarPeriodo(){
        $contrato = new ContratoContrato();
        $contrato_filtrado = $contrato->findById($this->contrato);
        if ($contrato_filtrado){
            if (!($contrato_filtrado->fecha_inicio <= $this->periodo_inicio))
                $this->addError ('periodo_inicio','Fecha no acorde al inicio del contrato refenciado');
//            else if (!($contrato_filtrado->fecha_fin >= $this->periodo_fin))
//                $this->addError ('periodo_fin','Contrato fuera del periodo');
        }     
    }
    public function getEntidadesFinancieras()
    {
        $array_entidades_financieras = PniaEntFinanciera::find()->orderBy(['razon_social' => SORT_ASC])->all();

        return ArrayHelper::map($array_entidades_financieras, 'pnia_ent_financiera_id','razon_social');
    }

    public function getEntidades()
    {
        $array_entidades = PniaEntidad::find()->orderBy(['razon_social' => SORT_ASC])->all();

        return ArrayHelper::map($array_entidades, 'pnia_entidad_id','razon_social');
    }

    public function getContratos()
    {
        $metacodigo = new Metacodigo();
        $fecha_actual = date('Y-m-d H:i:s');
        $array_contratos = ContratoContrato::find()->where(['>=', 'fecha_fin', $fecha_actual])
                ->andWhere(['=', 'flg_es_staff', 'no'])
                ->orderBy(['codigo_interno' => SORT_ASC])->all();

        return ArrayHelper::map($array_contratos, 'contrato_contrato_id','codigo_interno');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntidadEmisora()
    {
        return $this->hasOne(PniaEntFinanciera::className(), ['pnia_ent_financiera_id' => 'entidad_emisora']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntidadAfianzada()
    {
        return $this->hasOne(PniaEntidad::className(), ['pnia_entidad_id' => 'entidad_afianzada']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContrato0()
    {
        return $this->hasOne(ContratoContrato::className(), ['contrato_contrato_id' => 'contrato']);
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
}
