<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\Meta */
?>
<div class="meta-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'meta_id',
            'meta_descripcion',
            'tipo:boolean',
            'avance_total',
            'avance_actual',
            'unidad_medida_id',
            'precio_unitario',
            'monto_total',
            'presupuesto_afectado:boolean',
            'estado_regitro',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
