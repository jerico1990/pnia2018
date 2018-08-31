<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoDistribucionMonto */
?>
<div class="fondo-distribucion-monto-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_metacodigo_escala'   => $array_metacodigo_escala,
		'array_metacodigo_concepto' => $array_metacodigo_concepto,
		'array_niveles' => $array_niveles,
    ]) ?>

</div>
