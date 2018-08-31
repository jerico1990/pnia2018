<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Adquisicion */

?>
<div class="adquisicion-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_flujo_requerimiento' => $array_flujo_requerimiento,
        'array_tipo_revision' => $array_tipo_revision,
        'array_categoria_adquisicion' => $array_categoria_adquisicion,
        'array_enfoque_mercado' => $array_enfoque_mercado,
        'array_estado_actividad' => $array_estado_actividad,
        'array_ro_rooc' => $array_ro_rooc
    ]) ?>
</div>
