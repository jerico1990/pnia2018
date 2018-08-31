<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoCartaFianza */
?>
<div class="contrato-carta-fianza-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_entidades_financieras' => $array_entidades_financieras,
        'array_entidades' => $array_entidades,
        'array_contratos' => $array_contratos
    ]) ?>

</div>
