<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FlujoPaso */
?>
<div class="flujo-paso-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_metacodigo_estado_paso' => $array_metacodigo_estado_paso,
        'array_flujo_flujo' => $array_flujo_flujo,
        'array_staff_area' => $array_staff_area,
        'array_proceso_presupuesto' => $array_proceso_presupuesto,
        'nivel_actual' => $model->nivel,
    ]) ?>

</div>
