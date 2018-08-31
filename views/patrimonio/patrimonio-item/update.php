<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioItem */
?>
<div class="patrimonio-item-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_metacodigo_condicion' => $array_metacodigo_condicion,
        'model_documento_pnia' => $model_documento_pnia,
        'patrimonios_clases' => $patrimonios_clases,

    ]) ?>

</div>
