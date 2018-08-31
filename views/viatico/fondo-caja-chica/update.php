<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoFondo */
?>
<div class="fondo-fondo-update">

    <?= $this->render('_form', [
        'model' => $model,
        'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
        'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo,
        'model_documento_pnia' => $model_documento_pnia,
        'array_lista_entidad_financiera' => $array_lista_entidad_financiera,
    ]) ?>

</div>
