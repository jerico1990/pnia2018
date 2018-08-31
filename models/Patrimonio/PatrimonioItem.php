<?php

namespace app\models\Patrimonio;

use app\models\Auditoria\Usuario;

use Yii;
use Datetime;
/**
 * This is the model class for table "patrimonio_item".
 *
 * @property int $patrimonio_item_id
 * @property int $patrimonio_clase_id
 * @property int $metacodigo_id
 * @property int $documento_pnia_id
 * @property string $codigo
 * @property string $descripcion
 * @property string $fecha_alta
 * @property string $fecha_baja
 * @property double $valor_historico
 * @property string $marca
 * @property string $modelo
 * @property string $serie
 * @property string $creado_en
 * @property int $creado_por
 * @property string $actualizado_en
 * @property int $actualizado_por
 *
 * @property PatrimonioInventario[] $patrimonioInventarios
 * @property DocumentoPnia $documentoPnia
 * @property Metacodigo $metacodigo
 * @property PatrimonioClase $patrimonioClase
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 * @property PatrimonioMovimiento[] $patrimonioMovimientos
 * @property PatrimonioValorizacion[] $patrimonioValorizacions
 */
class PatrimonioItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patrimonio_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patrimonio_clase_id', 'metacodigo_id', 'documento_pnia_id', 'creado_por', 'actualizado_por'], 'default', 'value' => null],
            [['patrimonio_clase_id', 'metacodigo_id', 'documento_pnia_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['fecha_alta', 'fecha_baja', 'creado_en', 'actualizado_en'], 'safe'],
            [['valor_historico'], 'number'],
            //[['creado_en', 'creado_por', 'actualizado_en', 'actualizado_por'], 'required'],
            [['codigo', 'descripcion', 'marca', 'modelo', 'serie'], 'string', 'max' => 255],
            ['codigo','unique'],
            [['documento_pnia_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentoPnia::className(), 'targetAttribute' => ['documento_pnia_id' => 'documento_pnia_id']],
            [['metacodigo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['metacodigo_id' => 'metacodigo_id']],
            [['patrimonio_clase_id'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioClase::className(), 'targetAttribute' => ['patrimonio_clase_id' => 'patrimonio_clase_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['fecha_alta'], 'required'],
            ['fecha_baja', 'compare', 'compareAttribute' => 'fecha_alta', 'operator' => '>'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'patrimonio_item_id' => Yii::t('app', 'Patrimonio Item ID'),
            'patrimonio_clase_id' => Yii::t('app', 'Clase/Tipo Item'),
            'metacodigo_id' => Yii::t('app', 'Condición'),
            'documento_pnia_id' => Yii::t('app', 'Documento Relacionado'),
            'codigo' => Yii::t('app', 'Código'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'fecha_alta' => Yii::t('app', 'Fecha de Alta'),
            'fecha_baja' => Yii::t('app', 'Fecha de Baja'),
            'valor_historico' => Yii::t('app', 'Valor Historico'),
            'marca' => Yii::t('app', 'Marca'),
            'modelo' => Yii::t('app', 'Modelo'),
            'serie' => Yii::t('app', 'Serie'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
        ];
    }

    public function valorizar($fecha){
        $objeto_patrimonio_valorizacion = new PatrimonioValorizacion();
        $objeto_patrimonio_clase = new PatrimonioClase();
        $fecha_alta_item = date($this->fecha_alta);
        //$fecha_alta_item = date('m-y', $this->fecha_alta);
        //$fecha_alta_item = Datetime::createFromFormat($this->fecha_alta, 'm-y');
        //$fecha_actual = new DateTime('15-06-2019');//prueba
        //$fecha_actual = new DateTime($fecha);
        //$fecha_valorizacion = date('m-y', $fecha);
        //$fecha_valorizacion = DateTime::createFromFormat('d-m-y', $fecha);
        //$fecha_valorizacion = strtotime($fecha);
        // $fecha_valorizacion = date($fecha_valorizacion);
        //return $fecha_valorizacion->format('m-y');
        //return $fecha_actual->diff($fecha_alta_item);
        //return date('y',$fecha_valorizacion);
        $fecha_alta_item = date_create($fecha_alta_item);
        $fecha_valorizacion = date_create($fecha);
        //return $fecha;
        //return $fecha_valorizacion->format('Y-m-d');
        $diferencia_alta_actual = $fecha_valorizacion->diff($fecha_alta_item);
        //return $diferencia_alta_actual->m;
        // return $fecha_alta_item->format('m-y');
        $diferencia_fechas_annos = $diferencia_alta_actual->y;
        $diferencia_fechas_meses = $diferencia_alta_actual->m;

        $objeto_patrimonio_clase = $objeto_patrimonio_clase->findById($this->patrimonio_clase_id);

        $objeto_patrimonio_valorizacion->patrimonio_item_id = $this->patrimonio_item_id;
        $objeto_patrimonio_valorizacion->metacodigo_id = $this->patrimonio_clase_id;
        $objeto_patrimonio_valorizacion->valor = 
            $this->valor_historico 
            - $this->valor_historico
            * $objeto_patrimonio_clase->tasa_depreciacion
            /12
            *$diferencia_fechas_meses
            - $this->valor_historico
            * $objeto_patrimonio_clase->tasa_depreciacion
            *$diferencia_fechas_annos;
        $objeto_patrimonio_valorizacion->fecha = date('Y-m-d H:i:s',strtotime($fecha));
        // return 'patrimonio_item_id:'.$objeto_patrimonio_valorizacion->patrimonio_item_id
        //         .', metacodigo_id:'.$objeto_patrimonio_valorizacion->metacodigo_id
        //         .', valor:'.$objeto_patrimonio_valorizacion->valor
        //         .', fecha:'.$objeto_patrimonio_valorizacion->fecha;
        $objeto_patrimonio_valorizacion->save();
        //     return "Se valorizó el item";
        // return "No se pudo valorizar item";
    }

    public static function findById($id){
        return static::findOne(['patrimonio_item_id' => $id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getTodosLosItems()
    {
        return static::find()->all();
    }
    public function getPatrimonioInventarios()
    {
        return $this->hasMany(PatrimonioInventario::className(), ['patrimonio_item_id' => 'patrimonio_item_id']);
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
    public function getMetacodigo()
    {
        return $this->hasOne(Metacodigo::className(), ['metacodigo_id' => 'metacodigo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioClase()
    {
        return $this->hasOne(PatrimonioClase::className(), ['patrimonio_clase_id' => 'patrimonio_clase_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioMovimientos()
    {
        return $this->hasMany(PatrimonioMovimiento::className(), ['patrimonio_item_id' => 'patrimonio_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatrimonioValorizacions()
    {
        return $this->hasMany(PatrimonioValorizacion::className(), ['patrimonio_item_id' => 'patrimonio_item_id']);
    }

    public static function findIdentity($id){
        return static::findOne(['patrimonio_item_id' => $id]);
    }
    /**
     * [beforeSave description]
     * @param  [$model] $insert  [Modelo que ha de ser alterado]
     * @return [Boolean]         [true si se agrego, caso contrario false]
     */
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
             if(!Yii::$app->user->isGuest)
             {
                if ($this->isNewRecord) {
                    $this->creado_por = Yii::$app->user->identity->usuario_id;
                    $this->creado_en = date('Y-m-d H:i:s');
                    // $fecha_primera_valorizacion = date('Y-m-d H:i:s');
                    // $this->valorizar($fecha_primera_valorizacion);
                }
                $this->actualizado_por= Yii::$app->user->identity->usuario_id;
                $this->actualizado_en = date('Y-m-d H:i:s');

                return true;
             } else {
                return false;
             }
        }
        return false;
    }

    // public function afterSave($insert, $changedAttributes){
    //     if(!Yii::$app->user->isGuest){
    //         if ($insert){
    //             $fecha_primera_valorizacion = date('Y-m-d H:i:s');
    //             $this->valorizar($fecha_primera_valorizacion);
    //             return true;
    //         }
    //         else
    //             return false;
    //     }
    //     else
    //         return false;
    // }

    //función para devolver la información específica de un item pero como un arreglo para poder usarse en el gridview junto a otro modelo
    public function getItemComoArray($id){
        $algo = \app\models\Patrimonio\PatrimonioItem::findOne([ 'patrimonio_item_id' => '9' ])->toArray();
        $algo4 = $algo['descripcion'];
        
        $lista_item_como_array = $this->findOne([ 'patrimonio_item_id' => $id ])->toArray();
        return $lista_item_como_array;
    }
    
    public function asignarDocumentos($array_documentos_id){     
        foreach($array_documentos_id as $documento_actual){
            $objeto_contrato_documento = new \app\models\Viatico\ContratoDocumento();
            $objeto_contrato_documento->patrimonio_item_id = $this->patrimonio_item_id;
            $objeto_contrato_documento->documento_pnia_id = $documento_actual;
            $objeto_contrato_documento->save(false);
        }
    }

}
