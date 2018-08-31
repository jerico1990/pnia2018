<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\LogisticaProceso */
?>
<div class="logistica-proceso-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'logistica_proceso_id',
            'proyecto_id',
            'nombre',
            'codigo',
            'componente_id',
            'monto_rooc_bm',
            'monto_rooc_bid',
            'monto_ro',
            'monto_total',
            'categoria',
            'tipo',
            'tdr_plan',
            'tdr_real',
            'expresion_plan',
            'expresion_real',
            'evaluacion_plan',
            'evaluacion_real',
            'notificacion_plan',
            'notificacion_real',
            'firma_plan',
            'firma_real',
            'adenda_plan',
            'adenda_real',
            'termino_plan',
            'termino_real',
            'estado',
            'documento_pnia_id',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
