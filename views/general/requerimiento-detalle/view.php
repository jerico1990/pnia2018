<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\General\RequerimientoDetalle */
?>
<div class="requerimiento-detalle-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'requerimiento_detalle_id',
            'codigo_arbol',
            'periodo_id',
            'monto',
            'ro_rooc',
            'entregable_id',
            'penalidad_id',
            'flujo_requerimiento_id',
            'cantidad',
            'unidad_medida_cantidad',
            'costo_unitario',
            'staff_area_id',
            'bien_servicio',
            'descripcion_bien_servicio',
            'especificacion_tecnica_o_tdr',
            'tiempo_garantia_numero_meses',
            'lugar_entrega',
            'forma_pago',
            'duracion_servicio',
            'monto_total_contrato_fake',
            'staff_persona_id',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
