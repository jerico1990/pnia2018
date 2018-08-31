<?php

namespace app\models\Patrimonio;

use app\models\Auditoria\Usuario;
use app\models\Patrimonio\PatrimonioItem;

use Yii;

/**
 * This is the model class for table "patrimonio_valorizacion".
 *
 * @property int $patrimonio_valorizacion_id
 * @property int $patrimonio_item_id
 * @property int $metacodigo_id
 * @property double $valor
 * @property string $fecha
 * @property string $creado_en
 * @property int $creado_por
 * @property string $actualizado_en
 * @property int $actualizado_por
 *
 * @property Metacodigo $metacodigo
 * @property PatrimonioItem $patrimonioItem
 * @property Usuario $creadoPor
 * @property Usuario $actualizadoPor
 */
class PatrimonioValorizacion extends \yii\db\ActiveRecord
{
    public $ultima_valorizacion;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patrimonio_valorizacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patrimonio_item_id', 'metacodigo_id'], 'default', 'value' => null],
            [['patrimonio_item_id', 'metacodigo_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['valor'], 'number'],
            [['fecha', 'creado_en', 'actualizado_en','ultima_valorizacion'], 'safe'],
            // [['creado_en', 'creado_por', 'actualizado_en', 'actualizado_por'], 'required'],
            [['metacodigo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metacodigo::className(), 'targetAttribute' => ['metacodigo_id' => 'metacodigo_id']],
            [['patrimonio_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioItem::className(), 'targetAttribute' => ['patrimonio_item_id' => 'patrimonio_item_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            //['fecha','validarFechaValorizacion'],
            //['fecha', 'compare', 'compareAttribute' => 'ultima_valorizacion', 'operator' => '>'],

            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'patrimonio_valorizacion_id' => Yii::t('app', 'Patrimonio Valorización'),
            'patrimonio_item_id' => Yii::t('app', 'Item Patrimonio'),
            'metacodigo_id' => Yii::t('app', 'Metacódigo'),
            'valor' => Yii::t('app', 'Valor'),
            'fecha' => Yii::t('app', 'Fecha'),
            'creado_en' => Yii::t('app', 'Creado En'),
            'creado_por' => Yii::t('app', 'Creado Por'),
            'actualizado_en' => Yii::t('app', 'Actualizado En'),
            'actualizado_por' => Yii::t('app', 'Actualizado Por'),
            'ultima_valorizacion' => Yii::t('app', 'Ultima valorización'),
        ];
    }

    public function validarFechaValorizacion($fecha_valorizacion){
        if(!$fecha_valorizacion)
            return "Debe ingresar una fecha para valorizar items";

        $fecha_hoy = date('Y-m');
        $fecha_mes_pasado = strtotime ('-2 month', strtotime($fecha_hoy));
        $fecha_mes_pasado_date = date('Y-m', $fecha_mes_pasado);
        if($fecha_mes_pasado_date >= $fecha_valorizacion)
            return "Debe ingresar un mes posterior a ".$fecha_mes_pasado_date;

        $fecha_mes_siguiente = strtotime ('+2 month', strtotime($fecha_hoy));
        $fecha_mes_siguiente_date = date('Y-m', $fecha_mes_siguiente);
        if($fecha_mes_siguiente_date <= $fecha_valorizacion)
            return "Debe ingresar un mes anterior a ".$fecha_mes_siguiente_date;

        $objeto_patrimonio_valorizacion = new PatrimonioValorizacion();
        $objeto_patrimonio_valorizacion->ultima_valorizacion = $objeto_patrimonio_valorizacion->getUltimaValorizacion();
        if($objeto_patrimonio_valorizacion->ultima_valorizacion > $fecha_valorizacion)
            return "fecha debe ser posterior a la última valorización: ".$objeto_patrimonio_valorizacion->ultima_valorizacion;

        return true;
    }

    public function valorizar($fecha_valorizacion){
        $objeto_patrimonio_item = new PatrimonioItem();

        $array_todos_los_items = $objeto_patrimonio_item->getTodosLosItems();
        strtotime($fecha_valorizacion);
        $fecha_valorizacion_calculada = date('y-m-t',strtotime($fecha_valorizacion));
        //return $fecha_valorizacion_calculada;
        //return $array_todos_los_items[0]->valorizar($fecha_valorizacion_calculada);
        foreach ($array_todos_los_items as $actual_item) {
            $actual_item->valorizar($fecha_valorizacion_calculada);
        }
        return "Se valorizó al ".$fecha_valorizacion;
    }

    public function getUltimaValorizacion()
    {
        $objeto_ultimo_registro_valorizaciones = static::find()->orderBy(['fecha' => SORT_DESC])->one();
        if($objeto_ultimo_registro_valorizaciones)
            return $objeto_ultimo_registro_valorizaciones->fecha;
        return false;
    }

    public function findByItemId($patrimonio_item_id)
    {
        return static::findOne(['patrimonio_item_id' => $patrimonio_item_id]);
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
    public function getPatrimonioItem()
    {
        return $this->hasOne(PatrimonioItem::className(), ['patrimonio_item_id' => 'patrimonio_item_id']);
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
                if ($this->isNewRecord) {
                    $this->creado_por = Yii::$app->user->identity->usuario_id;
                    $this->creado_en = date('Y-m-d H:i:s');
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
}
