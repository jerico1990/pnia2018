<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FlujoRequerimiento */
?>
<div class="tramite-documentario-update">

    <?= $this->render('_form_tramites', [
        'model' => $model,
        'array_flujo_flujo' => $array_flujo_flujo,
        'array_flujo_paso' => $array_flujo_paso,
        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
        'model_documento_pnia' => $model_documento_pnia,
        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
        'array_periodo' => $array_periodo,
        
    ]) ?>

</div>
