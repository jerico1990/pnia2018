<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoEntregable */
?>
<div class="contrato-entregable-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_estado_de_entregables' => $array_estado_de_entregables,
        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
        'array_staff_area' => $array_staff_area,
        'array_periodo' => $array_periodo
    ]) ?>

</div>
