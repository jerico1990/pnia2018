<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoPenalidad */
?>
<div class="contrato-penalidad-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
        'array_staff_area' => $array_staff_area
    ]) ?>

</div>
