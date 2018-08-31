<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Adquisicion */
?>
<div class="adquisicion-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'adquisicion_id',
            'flujo_requerimiento_id',
            'codigo_referencia',
            'referencia_actividad',
            'nombre_firma',
            'monto_adjudicado',
            'monto_ejecutado',
            'prestamo',
            'componente',
            'tipo_revision',
            'categoria',
            'enfoque_mercado',
            'monto_estimado',
            'estado_proceso',
            'estado_actividad',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
