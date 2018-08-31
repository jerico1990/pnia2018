<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoEntregable */
if (isset($_SESSION['codigo_interno_contrato'])) {
	$model->codigo_contrato = $_SESSION['codigo_interno_contrato'];
}

?>
<div class="contrato-entregable-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_estado_de_entregables' => $array_estado_de_entregables,
        'array_lista_codigos_contrato' => $array_lista_codigos_contrato,
        'array_staff_area' => $array_staff_area,
        'array_periodo' => $array_periodo
    ]) ?>
</div>
