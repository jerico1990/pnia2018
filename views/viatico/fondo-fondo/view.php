<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoFondo */
?>
<div class="fondo-fondo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fondo_fondo_id',
            'responsable_persona_id',
            'requerimiento_flujo_id',
            'tipo_flujo_metacodigo',
            'resolucion_directoral_pnia_documento_id',
            'banco_entidad_financiera',
            'motivo',
            'saldo_anterior_bienes',
            'saldo_anterior_servicios',
            'saldo_actual_bienes',
            'saldo_actual_servicios',
            'fecha_inicio',
            'fecha_fin',
            'total_bienes',
            'total_servicios',
            'total_entregado',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
