<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\MetaFinanciera */
?>
<div class="meta-financiera-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'meta_financiera_id',
            'descripcion',
            'avance_total',
            'avance_actual',
            'unidad_medida_id',
            'precio_unitario_ro',
            'precio_unitario_rooc',
            'monto_total_ro',
            'monto_total_rooc',
            'presupuesto_cabecera_id',
            'estado_regitro',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
