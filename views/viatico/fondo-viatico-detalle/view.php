<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoViaticoDetalle */
?>
<div class="fondo-viatico-detalle-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'fondo_viatico_detalle_id',
            [
                'label' => 'Destino Inicial',
                'attribute' => 'destinoInicialUbigeo.nombre',
            ],
            [
                'label' => 'Destino Final',
                'attribute' => 'destinoFinalUbigeo.nombre',
            ],
            [
                'label' => 'Número de Días',
                'attribute' => 'numero_dias',
            ],
            'monto',
        ],
    ]) ?>

</div>
