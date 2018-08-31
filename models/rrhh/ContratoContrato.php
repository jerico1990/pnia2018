<?php

namespace app\models\rrhh;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use app\models\Patrimonio\DocumentoPnia;
use yii\helpers\ArrayHelper;
use app\models\ModeloGenerico;
use app\models\Presupuesto\PresupuestoCabecera;
use app\models\Presupuesto\Periodo;
use app\models\Adquisicion\Adquisicion;
use app\models\Viatico\FlujoRequerimiento;
use app\models\Viatico\ContratoDocumento;
use Yii;

/**
 * This is the model class for table "contrato_contrato".
 *
 * @property int $contrato_contrato_id
 * @property string $codigo_interno
 * @property int $entidad_contratista
 * @property int $area_contratante
 * @property int $area_responsable
 * @property int $monto
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $objetivos
 * @property int $contrato_origen
 * @property string $flg_es_staff
 * @property int $documento_pnia_id
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property ContratoCartaFianza[] $contratoCartaFianzas
 * @property PniaEntidad $entidadContratista
 * @property StaffArea $areaContratante
 * @property StaffArea $areaResponsable
 * @property ContratoContrato $contratoOrigen
 * @property ContratoContrato[] $contratoContratos
 * @property DocumentoPnia $documentoPnia
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 * @property ContratoEntregable[] $contratoEntregables
 * @property ContratoPenalidad[] $contratoPenalidads
 */
class ContratoContrato extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contrato_contrato';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_arbol'],'required'],
            ['codigo_interno','unique'],
            
            [['codigo_interno', 'objetivos', 'flg_es_staff'], 'string'],
            [['entidad_contratista', 'area_contratante', 'area_responsable', 'actualizado_por', 'creado_por'], 'integer'],
            [['fecha_inicio', 'fecha_fin', 'actualizado_en', 'creado_en'], 'safe'],

            // [['actualizado_por', 'creado_por'], 'required'],
            [['entidad_contratista'], 'exist', 'skipOnError' => true, 'targetClass' => PniaEntidad::className(), 'targetAttribute' => ['entidad_contratista' => 'pnia_entidad_id']],
            [['area_contratante'], 'exist', 'skipOnError' => true, 'targetClass' => StaffArea::className(), 'targetAttribute' => ['area_contratante' => 'staff_area_id']],
            [['area_responsable'], 'exist', 'skipOnError' => true, 'targetClass' => StaffArea::className(), 'targetAttribute' => ['area_responsable' => 'staff_area_id']],
            [['codigo_arbol'], 'exist', 'skipOnError' => true, 'targetClass' => PresupuestoCabecera::className(), 'targetAttribute' => ['codigo_arbol' => 'presupuesto_cabecera_id']],
            // [['contrato_origen'], 'exist', 'skipOnError' => true, 'targetClass' => ContratoContrato::className(), 'targetAttribute' => ['contrato_origen' => 'contrato_contrato_id']],
            //[['documento_pnia_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentoPnia::className(), 'targetAttribute' => ['documento_pnia_id' => 'documento_pnia_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['adquisicion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Adquisicion::className(), 'targetAttribute' => ['adquisicion_id' => 'adquisicion_id']],
            
            [['fecha_inicio'], 'required'],
            ['fecha_fin', 'compare', 'compareAttribute' => 'fecha_inicio', 'operator' => '>'],
            [['monto'],'number']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contrato_contrato_id' => Yii::t('app', 'Contrato Contrato ID'),
            'codigo_interno' => Yii::t('app', 'Código Interno'),
            'entidad_contratista' => Yii::t('app', 'Entidad Contratista'),
            'area_contratante' => Yii::t('app', 'Área Contratante'),
            'area_responsable' => Yii::t('app', 'Área Responsable'),
            'monto' => Yii::t('app', 'Monto'),
            'fecha_inicio' => Yii::t('app', 'Fecha Inicio'),
            'fecha_fin' => Yii::t('app', 'Fecha Fin'),
            'objetivos' => Yii::t('app', 'Objetivos'),
            'contrato_origen' => Yii::t('app', 'Contrato Origen'),
            'flg_es_staff' => Yii::t('app', 'Flag de Staff'),
            //'documento_pnia_id' => Yii::t('app', 'Documento Pnia ID'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'codigo_arbol' => 'Línea - presupuesto',
            'staff_persona_id' => Yii::t('app', 'Persona Asociada a Contrato'),
            'adquisicion_id' => 'Adquisición relacionada'
        ];
    }

    public function findById($id){
        return static::findOne(['contrato_contrato_id'=>$id]);
    }
    
    public function getFlgsEsStaff()
    {
        return ['si'=>'si', 'no'=>'no'];
    }

    public function getEntidades()
    {
        $array_entidades = PniaEntidad::find()->orderBy(['razon_social' => SORT_ASC])->all();

        return ArrayHelper::map($array_entidades, 'pnia_entidad_id','razon_social');
    }

    public function getAreasDeUsuarioLogeado($id_persona){
        $array_areas = StaffArea::find()->where(['responsable' => $id_persona])->orderBy(['descripcion' => SORT_ASC])->all();

        return ArrayHelper::map($array_areas, 'staff_area_id','descripcion');
    }
    public function getAreas()
    {
        $array_areas = StaffArea::find()->orderBy(['descripcion' => SORT_ASC])->all();

        return ArrayHelper::map($array_areas, 'staff_area_id','descripcion');
    }

    public function getContratos()
    {
        $array_contratos = ContratoContrato::find()->orderBy(['codigo_interno' => SORT_ASC])->all();

        return ArrayHelper::map($array_contratos, 'contrato_contrato_id','codigo_interno');
    }
    
    public function getStaffPersona()
    {
        return $this->hasOne(StaffPersona::className(), ['staff_persona_id' => 'staff_persona_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getArrayListaDeCodigosInternos()
    {
        $codigos = static::find()->orderBy(['codigo_interno' => SORT_ASC])->all();
        return ArrayHelper::map($codigos, 'contrato_contrato_id','codigo_interno');
    }
    
    public function getContratoCartaFianzas()
    {
        return $this->hasMany(ContratoCartaFianza::className(), ['contrato' => 'contrato_contrato_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntidadContratista()
    {
        return $this->hasOne(PniaEntidad::className(), ['pnia_entidad_id' => 'entidad_contratista']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaContratante()
    {
        return $this->hasOne(StaffArea::className(), ['staff_area_id' => 'area_contratante'])->from(['areaContratante' => StaffArea::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaResponsable()
    {
        return $this->hasOne(StaffArea::className(), ['staff_area_id' => 'area_responsable'])->from(['areaResponsable' => StaffArea::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratoOrigen()
    {
        return $this->hasOne(ContratoContrato::className(), ['contrato_contrato_id' => 'contrato_origen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratoContratos()
    {
        return $this->hasMany(ContratoContrato::className(), ['contrato_origen' => 'contrato_contrato_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getDocumentoPnia()
//    {
//        return $this->hasOne(DocumentoPnia::className(), ['documento_pnia_id' => 'documento_pnia_id']);
//    }

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratoEntregables()
    {
        return $this->hasMany(ContratoEntregable::className(), ['codigo_contrato' => 'contrato_contrato_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratoPenalidads()
    {
        return $this->hasMany(ContratoPenalidad::className(), ['codigo_contrato' => 'contrato_contrato_id']);
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
                if($this->adquisicion_id){
                    $objeto_adquisicion = Adquisicion::find()->where(['adquisicion_id'=>$this->adquisicion_id])->one();
                    $objeto_flujo_requerimiento = FlujoRequerimiento::find()->where(['flujo_requerimiento_id'=>$objeto_adquisicion->flujo_requerimiento_id])->one();
                    $this->codigo_arbol=$objeto_flujo_requerimiento->codigo_arbol;
                    $objeto_adquisicion->ticket=true;
                    $objeto_adquisicion->save(false);
                }
                
            }
            return true;
        }
        return false;
    }


    public $esta_actualizado = false;


    public function afterSave($insert, $changedAttributes){
        if ($this->esta_actualizado){
            return true;
        }
        if(!Yii::$app->user->isGuest){
            if($this->adquisicion_id){
                $objeto_adquisicion = Adquisicion::find()->where(['adquisicion_id'=>$this->adquisicion_id])->one();
                $objeto_adquisicion->monto_adjudicado=$this->monto;
                $objeto_adquisicion->save(false);
            }
            //$model  = ContratoContrato::find(['contrato_contrato_id' => $this->contrato_contrato_id])->one();
            $numero_random = $this->contrato_contrato_id;
            $model_presupuesto_cabecera = new PresupuestoCabecera();
            $cabeceraPresupuesto = $model_presupuesto_cabecera->getPresupuestoCabeceraLink($this->codigo_arbol);
            if ($cabeceraPresupuesto->presupuestoContrato){
                $resultado = $cabeceraPresupuesto->presupuestoContrato->esBancoMundial();
                if ($resultado)
                    $this->codigo_interno = $numero_random . '-INIA/PNIA' . '-BM';
                else
                    $this->codigo_interno = $numero_random . '-INIA/PNIA' . '-BID';
                $this->esta_actualizado = true;
                $this->save();
            }
            parent::afterSave($insert, $changedAttributes);
            return true;
        }
        return false;
    }
    
    public function asignarDocumentos($array_documentos_id){     
        foreach($array_documentos_id as $documento_actual){
            $objeto_contrato_documento = new ContratoDocumento();
            $objeto_contrato_documento->contrato_id = $this->contrato_contrato_id;
            $objeto_contrato_documento->documento_pnia_id = $documento_actual;
            $objeto_contrato_documento->save(false);
        }
    }
}
