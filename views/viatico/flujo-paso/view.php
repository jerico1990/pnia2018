<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FlujoPaso */
?>
<div class="flujo-paso-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'flujo_paso_id',
            'flujo',
            'nombre_paso',
            'estado_paso_metacodigo',
            'area_responsable_id',
            'primer_flujo_paso',
            'nivel',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
