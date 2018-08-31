<?php

namespace app\models;
use app\models\Auditoria\Usuario;
use app\models\Patrimonio\Metacodigo;
use yii\helpers\ArrayHelper;

use Yii;

class ModeloGenerico extends \yii\db\ActiveRecord
{
    public function validarRuc(){
        if (!($this->ruc >= 10000000000 && $this->ruc <= 99999999999))
        {
            $this->addError('ruc', 'RUC no válido');
        }
    }
    
    public function validarDni(){
        if (!($this->dni >= 10000000 && $this->dni <= 99999999))
        {
            $this->addError('dni', 'DNI no válido');
        }
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

    public function getComboBoxRoRooc(){
        return [ 0 => 'Rooc', 1 => 'Ro'];
    }
}