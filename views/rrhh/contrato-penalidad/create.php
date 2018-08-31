<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoPenalidad */
if (isset($_SESSION['codigo_interno_contrato'])) {
	$model->codigo_contrato = $_SESSION['codigo_interno_contrato'];
}

?>
<div class="contrato-penalidad-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
        'array_staff_area' => $array_staff_area
    ]) ?>
</div>
