<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Requerimiento */
?>
<div class="panel panel-default">
  <div class="panel-heading">Requerimiento</div>
  <div class="panel-body">
    <div class="requerimiento-update">

        <?= $this->render('_form', [
            'model' => $model,
            'array_tipo_requerimiento'=>$array_tipo_requerimiento,
            'flag_action'=>$flag_action,
            'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
            'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle,
			'model_documento_pnia' => $model_documento_pnia,
        ]) ?>

    </div>
  </div>
</div>
