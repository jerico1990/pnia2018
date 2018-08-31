<?php

namespace app\models\Adquisicion;
use app\models\ModeloGenerico;
use Yii;

/**
 * This is the model class for table "adjudicacion".
 *
 * @property int $adjudicacion_id
 * @property int $requerimiento_detalle_id
 * @property int $requerimiento_id
 * @property int $situacion_adjudicacion_id
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 */
class Adjudicacion extends ModeloGenerico
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adjudicacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['requerimiento_detalle_id'], 'required'],
            [['requerimiento_detalle_id', 'requerimiento_id', 'situacion_adjudicacion_id', 'actualizado_por', 'creado_por'], 'default', 'value' => null],
            [['requerimiento_detalle_id', 'requerimiento_id', 'situacion_adjudicacion_id', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'adjudicacion_id' => 'Adjudicacion ID',
            'requerimiento_detalle_id' => 'Requerimiento Detalle ID',
            'requerimiento_id' => 'Requerimiento ID',
            'situacion_adjudicacion_id' => 'Situacion Adjudicacion ID',
            'actualizado_en' => 'Actualizado En',
            'actualizado_por' => 'Actualizado Por',
            'creado_en' => 'Creado En',
            'creado_por' => 'Creado Por',
        ];
    }

    public function getSituacionAdjudicacion(){
      $msg='';
      if($this->situacion_requerimiento_id==1){
        $msg='';
      }
      elseif($this->situacion_requerimiento_id==2){
        $msg='';
      }
      elseif($this->situacion_requerimiento_id==7){
        $msg='Ganador de Postores';
      }

      return $msg;
    }
}
