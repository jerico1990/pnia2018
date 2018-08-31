<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionViatico */

?>
<div class="fondo-rendicion-viatico-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_fondos_disponibles' => $array_fondos_disponibles,
        'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
        'model_documento_pnia' => $model_documento_pnia,
        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,
        'array_periodo' => $array_periodo,
        'model_requerimiento' => $model_requerimiento,
    ]) ?>
</div>
