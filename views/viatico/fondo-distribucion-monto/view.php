<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoDistribucionMonto */
?>
<div class="fondo-distribucion-monto-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'escala_metacodigo',
            'concepto_metacodigo',
            [
                'label' => 'Concepto',
                'attribute' => 'conceptoMetacodigo.descripcion',
            ],
            [
                'label' => 'Destino Inicial',
                'attribute' => 'destinoIniUbigeo.nombre',
            ],
            [
                'label' => 'Destino Final',
                'attribute' => 'destinoFinUbigeo.nombre',
            ],
            'monto_determinado',
        ],
    ]) ?>

</div>
