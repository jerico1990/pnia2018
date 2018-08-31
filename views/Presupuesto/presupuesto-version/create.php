<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoVersion */

$model->nro_version = 0;
$model->fecha = date('Y-m-d');
?>
<div class="presupuesto-version-create">

    <?= $this->render('_form', [
        'model' => $model,
        'array_versiones_previas' => $array_versiones_previas,
    ]) ?>

</div>