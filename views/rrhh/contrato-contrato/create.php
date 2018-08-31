<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoContrato */

?>
<div class="contrato-contrato-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_entidades' => $array_entidades,
        'array_areas' => $array_areas,
        'array_contratos' => $array_contratos,
        'array_flags_es_staff' => $array_flags_es_staff,
        'model_documento_pnia' => $model_documento_pnia,
        'array_adquisicion' => $array_adquisicion,
        'lista_presupuestos_ramas' => $lista_presupuestos_ramas,


    ]) ?>
</div>
