<?php

namespace app\models\Viatico;
use app\models\Patrimonio\Metacodigo;
use app\models\rrhh\StaffArea;
use app\models\Auditoria\Usuario;
use yii\db\Query;
use \yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "flujo_paso".
 *
 * @property int $flujo_paso_id
 * @property int $flujo
 * @property string $nombre_paso
 * @property int $estado_paso_metacodigo
 * @property int $area_responsable_id
 * @property int $primer_flujo_paso
 * @property int $nivel
 * @property int $nivel_siguiente
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property FlujoFlujo $flujo0
 * @property FlujoPaso $primerFlujoPaso
 * @property FlujoPaso[] $flujoPasos
 * @property Metacodigo $estadoPasoMetacodigo
 * @property StaffArea $areaResponsable
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property FlujoRequerimiento[] $flujoRequerimientos
 */
class FlujoPaso extends \yii\db\ActiveRecord
{
    public $paso_previo;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'flujo_paso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flujo', 'estado_paso_metacodigo', 'area_responsable_id', 'primer_flujo_paso', 'nivel', 'actualizado_por', 'creado_por','proceso_presupuesto','nivel_siguiente'], 'default', 'value' => null],
            [['flujo', 'estado_paso_metacodigo', 'area_responsable_id', 'primer_flujo_paso', 'nivel', 'actualizado_por', 'creado_por','cantidad_dias','nivel_siguiente'], 'integer'],
            [['actualizado_en', 'creado_en','paso_previo'], 'safe'],
            [['nombre_paso','nivel','cantidad_dias'], 'required'],
            [['nombre_paso'], 'string', 'max' => 255],
            [['flujo'], 'exist', 'skipOnError' => true, 'targetClass' => FlujoFlujo::className(), 'targetAttribute' => ['flujo' => 'flujo_flujo_id']],
            [['primer_flujo_paso'], 'exist', 'skipOnError' => true, 'targetClass' => FlujoPaso::className(), 'targetAttribute' => ['primer_flujo_paso' => 'flujo_paso_id']],
            [['estado_paso_metacodigo'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['estado_paso_metacodigo' => 'metacodigo_id']],
            [['area_responsable_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffArea::className(), 'targetAttribute' => ['area_responsable_id' => 'staff_area_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            ['nivel', 'compare', 'compareValue' => 0, 'operator' => '>']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'flujo_paso_id' => 'Flujo Paso ID',
            'flujo' => 'Flujo',
            'nombre_paso' => 'Nombre Paso',
            'estado_paso_metacodigo' => 'Estado',
            'area_responsable_id' => 'Área responsable',
            'primer_flujo_paso' => 'Primer Flujo Paso',
            'nivel' => 'Nivel (Actual)',
            'cantidad_dias' => 'Número de días',
            'proceso_presupuesto' => 'Proceso presupuesto',
            'nivel_siguiente' => 'Siguiente Nivel',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
            'paso_previo' => 'Paso Previo',
        ];
    }

    public function getComboBoxProcesosPresupuesto(){
        return ['Certificado' => 'Certificado','Comprometido'=>'Comprometido','Devengado'=>'Devengado','Girado'=>'Girado','Pagado'=>'Pagado','Ejecutado'=>'Ejecutado'];
    }


    public function findById($id){
        return static::findOne(['flujo_paso_id'=>$id]);
    }
    
    static function getComboBoxItems(){
        $items  = FlujoPaso::find()->all();
        return ArrayHelper::map($items, 'flujo_paso_id', 'nombre_paso');
    }

    static function getComboBoxFiltrado($flujo){
        $items  = FlujoPaso::find()->where(['flujo'=>$flujo])->all();
        return ArrayHelper::map($items, 'flujo_paso_id', 'nombre_paso');
    }

    public function existenFlujosPasoDeFlujo($flujo_flujo_id) 
    { 
        $objeto_flujo_paso = static::find()->where(['flujo'=>$flujo_flujo_id])->one();
        if($objeto_flujo_paso)
            return $objeto_flujo_paso->primer_flujo_paso;
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlujo0()
    {
        return $this->hasOne(FlujoFlujo::className(), ['flujo_flujo_id' => 'flujo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrimerFlujoPaso()
    {
        return $this->hasOne(FlujoPaso::className(), ['flujo_paso_id' => 'primer_flujo_paso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlujoPasos()
    {
        return $this->hasMany(FlujoPaso::className(), ['primer_flujo_paso' => 'flujo_paso_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoPasoMetacodigo()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'estado_paso_metacodigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaResponsable()
    {
        return $this->hasOne(StaffArea::className(), ['staff_area_id' => 'area_responsable_id']);
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
    public function getFlujoRequerimientos()
    {
        return $this->hasMany(FlujoRequerimiento::className(), ['codigo_paso' => 'flujo_paso_id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[] : retorna los flujo paso Siguintes (nivel+1 O los que esten en el nivel_siguiente)
     */
    public function getFlujoPasosSiguientes()
    {
        if ($this->nivel_siguiente != null) {
            return FlujoPaso::find()->where(['nivel' => $this->nivel_siguiente, 'primer_flujo_paso' => $this->primer_flujo_paso])->all();
        } else {
            return FlujoPaso::find()->where(['nivel' => $this->nivel + 1, 'primer_flujo_paso' => $this->primer_flujo_paso])->all();
        }
    }

    /**
     * Items para el combo box en la creación de pasos
     * @param $flujo_flujo_id
     * @return array
     */
    static function getComboBoxItems_PasosPrevios($flujo_flujo_id){
        $array_flujo_paso = FlujoPaso::find()->where(['flujo'=>$flujo_flujo_id])->orderBy('nivel')->all();
        return ArrayHelper::map($array_flujo_paso,'flujo_paso_id','nombre_paso','nivel');
    }

    /**
     * Items para el combo box en la creación de pasos
     * @param $flujo_flujo_id
     * @return array
     */
    static function getComboBoxItems_NivelesSiguientes($flujo_flujo_id){//,$nivel_actual = null){

        /*
        return $array_flujo_paso = FlujoPaso::find()->where(['flujo'=>$flujo_flujo_id])->orderBy('nivel')->all();
        return ArrayHelper::map($array_flujo_paso,'nivel','nivel');//,'nivel'); */

        $query = new Query();
        $query->select('nivel')
              ->from('flujo_paso')
              ->where( ['flujo' => $flujo_flujo_id]);
        /*
        if ($nivel_actual != null) {
            $query->andWhere('nivel != '.$nivel_actual);
        }//*/
        $query->groupBy('nivel')->orderBy('nivel');

        $array_niveles = $query->createCommand()->queryAll();
        return ArrayHelper::map($array_niveles,'nivel','nivel');

    }

    /**
     * [beforeSave Permite guardar los datos ]
     * @param  [$model] $insert  [Modelo que ha de ser alterado]
     * @return [Boolean]         [true si se agrego, caso contrario false]
     */
    public function beforeSave($insert){
        
        if (parent::beforeSave($insert)) {
            // $id_persona = Yii::$app->user->identity->persona_id;
            // $staff_area_obj = StaffArea::find()->where(['responsable' => $id_persona])->one();
             if(!Yii::$app->user->isGuest)
             {
                 $this->actualizado_por= Yii::$app->user->identity->usuario_id;
                 $this->actualizado_en = date('Y-m-d H:i:s');
                 
                if ($this->isNewRecord) {
                    $this->creado_por = Yii::$app->user->identity->usuario_id;
                    $this->creado_en  = date('Y-m-d H:i:s');
                }
                // if($this->nivel==1)
                //     $this->area_responsable_id = $staff_area_obj->staff_area_id;

                $objeto_flujo_paso = $this->existenFlujosPasoDeFlujo($this->flujo);

                if($objeto_flujo_paso){
                    $this->primer_flujo_paso = $objeto_flujo_paso;
                }

                if (isset($this->paso_previo) AND $this->paso_previo != null){
                    $paso_previo = FlujoPaso::findOne($this->paso_previo);
                    $paso_previo->nivel_siguiente = $this->nivel;
                    $paso_previo->save();
                }
                return true;
             } else {
                 if (isset($this->paso_previo) AND $this->paso_previo != null){
                     $paso_previo = FlujoPaso::findOne($this->paso_previo);
                     $paso_previo->nivel_siguiente = $this->nivel;
                     $paso_previo->save();
                 }
                return true;
             }
        }
        return false;
    }

    public function beforeSave22($insert){

        if (parent::beforeSave($insert)) {
            // $id_persona = Yii::$app->user->identity->persona_id;
            // $staff_area_obj = StaffArea::find()->where(['responsable' => $id_persona])->one();
            if(!Yii::$app->user->isGuest)
            {
                if ($this->isNewRecord) {
                    $this->creado_por = Yii::$app->user->identity->usuario_id;
                    $this->creado_en  = date('Y-m-d H:i:s');
                }
                // if($this->nivel==1)
                //     $this->area_responsable_id = $staff_area_obj->staff_area_id;

                $objeto_flujo_paso = $this->existenFlujosPasoDeFlujo($this->flujo);

                if($objeto_flujo_paso)
                    $this->primer_flujo_paso = $objeto_flujo_paso;

                $this->actualizado_por= Yii::$app->user->identity->usuario_id;
                $this->actualizado_en = date('Y-m-d H:i:s');
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes){
        if(!Yii::$app->user->isGuest){
            if($insert){
                if($this->nivel==1){
                    $this->primer_flujo_paso = $this->flujo_paso_id;
                }
                if (isset($_SESSION['flujo_flujo_id'])){
                    $flujo_flujo_id = $_SESSION['flujo_flujo_id'];
                    $flujo_flujo_model = FlujoFlujo::find()->where(['flujo_flujo_id' => $flujo_flujo_id ])->one();
                    $this->flujo = $flujo_flujo_model->flujo_flujo_id;
                }
                $this->save();

            }
            parent::afterSave($insert, $changedAttributes);
            return true;
        }
        return false;
    }
    
}
