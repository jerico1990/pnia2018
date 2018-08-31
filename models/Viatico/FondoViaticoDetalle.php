<?php

namespace app\models\Viatico;
use app\models\Auditoria\Usuario;
use app\models\Utilitario\UtilitarioUbigeo;
use app\models\Viatico\FondoFondo;
use app\models\ModeloGenerico;

use Yii;

/**
 * This is the model class for table "fondo_viatico_detalle".
 *
 * @property int $fondo_viatico_detalle_id
 * @property int $destino_inicial_ubigeo
 * @property int $destino_final_ubigeo
 * @property int $numero_dias
 * @property double $monto
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property UtilitarioUbigeo $destinoInicialUbigeo
 * @property UtilitarioUbigeo $destinoFinalUbigeo
 */
class FondoViaticoDetalle extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fondo_viatico_detalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['destino_inicial_ubigeo', 'destino_final_ubigeo', 'numero_dias', 'monto'], 'required'],
            [['destino_inicial_ubigeo', 'destino_final_ubigeo', 'numero_dias', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['destino_inicial_ubigeo', 'destino_final_ubigeo', 'numero_dias', 'actualizado_por', 'creado_por'], 'integer'],
            [['monto'], 'number'],
            [['actualizado_en', 'creado_en'], 'safe'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['actualizado_por' => 'usuario_id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'usuario_id']],
            [['destino_inicial_ubigeo'], 'exist', 'skipOnError' => true, 'targetClass' => UtilitarioUbigeo::className(), 'targetAttribute' => ['destino_inicial_ubigeo' => 'utilitario_ubigeo_id']],
            [['destino_final_ubigeo'], 'exist', 'skipOnError' => true, 'targetClass' => UtilitarioUbigeo::className(), 'targetAttribute' => ['destino_final_ubigeo' => 'utilitario_ubigeo_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fondo_viatico_detalle_id' => 'Fondo Viatico Detalle ID',
            'fondo_fondo_id' => 'Fondo ID',
            'destino_inicial_ubigeo' => 'Destino Inicial Ubigeo',
            'destino_final_ubigeo' => 'Destino Final Ubigeo',
            'numero_dias' => 'Numero Dias',
            'monto' => 'Monto',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
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
            if (isset($_SESSION['fondo_fondo_id'])) {
                $this->fondo_fondo_id = $_SESSION['fondo_fondo_id'];
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

    public function afterSave($insert, $changedAttributes){
        if(!Yii::$app->user->isGuest){
            if($insert){
                $total_entregado = 0;
                $objeto_viatico = new FondoFondo();
                $objeto_viatico = $objeto_viatico->findById($_SESSION['fondo_fondo_id']);
                $objeto_viatico_detalle = FondoViaticoDetalle::find()
                    ->where([
                        'fondo_fondo_id' => $_SESSION['fondo_fondo_id'], 
                    ])
                    ->all();
                foreach ($objeto_viatico_detalle as $viatico_detalle) {
                    $total_entregado = intval($viatico_detalle->monto) + $total_entregado;
                }
                $objeto_viatico->total_entregado = $total_entregado;
                $objeto_viatico->save();
            }
            parent::afterSave($insert, $changedAttributes);
        }
        return false;
}

    public function beforeDelete() {
        $total_entregado = 0;
        $objeto_viatico = new FondoFondo();
        $objeto_viatico = $objeto_viatico->findById($_SESSION['fondo_fondo_id']);
        $objeto_viatico_detalle = FondoViaticoDetalle::find()
            ->where([
                'fondo_fondo_id' => $_SESSION['fondo_fondo_id'], 
            ])
            ->all();
        foreach ($objeto_viatico_detalle as $viatico_detalle) {
            $total_entregado = intval($viatico_detalle->monto) + $total_entregado;
        }
        $objeto_viatico->total_entregado = $total_entregado - $this->monto;
        $objeto_viatico->save();
        return parent::beforeDelete();
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
    public function getDestinoInicialUbigeo()
    {
        // return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_inicial_ubigeo']);
        return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_inicial_ubigeo'])->from(['destinoInicialUbigeo' => UtilitarioUbigeo::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinoFinalUbigeo()
    {
        // return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_final_ubigeo']);
        return $this->hasOne(UtilitarioUbigeo::className(), ['utilitario_ubigeo_id' => 'destino_final_ubigeo'])->from(['destinoFinalUbigeo' => UtilitarioUbigeo::tableName()]);
    }
    
}
