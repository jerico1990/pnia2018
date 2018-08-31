<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\RequerimientoDetalle */
?>
<div class="requerimiento-detalle-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'requerimiento_detalle_id',
            'requerimiento_id',
            'linea_nivel_id',
            'descripcion',
            'concepto',
            'unidad_medida',
            'cantidad',
            'costo_unitario',
            'monto_total',
            'rooc',
            'ro',
            'especificacion_tecnica:ntext',
            'tiempo_entrega',
            'tipo_garantia_id',
            'garantia_cantidad',
            'lugar_entrega',
            'fecha_entrega',
            'forma_pago:ntext',
            'resumen_especificacion_tecnica:ntext',
            'otras_caractaristicas:ntext',
            'forma_entrega',
            'anio_fabricacion',
            'lugar_fabricacion',
            'staff_area_id:ntext',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
