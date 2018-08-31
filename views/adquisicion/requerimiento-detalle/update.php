<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\RequerimientoDetalle */
?>
<div class="requerimiento-detalle-update">

    <?= $this->render('_form', [
        'model' => $model,
		'array_metacodigo' => $array_metacodigo,
        'array_ubicaciones' => $array_ubicaciones,
    ]) ?>

</div>
