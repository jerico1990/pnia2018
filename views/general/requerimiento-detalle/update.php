<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\General\RequerimientoDetalle */
?>
<div class="requerimiento-detalle-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_staff_area' => $array_staff_area,
        'model_documento_pnia' => $model_documento_pnia,
        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
        'array_periodo' => $array_periodo,
        'array_ro_rooc' => $array_ro_rooc,
        'array_tipo_bien_servicio' => $array_tipo_bien_servicio,
        'array_flujo_requerimiento' => $array_flujo_requerimiento
    ]) ?>

</div>
