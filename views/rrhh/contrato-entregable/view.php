<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoEntregable */
?>
<div class="contrato-entregable-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'contrato_entregable_id',
            //'codigo_contrato',
            [
                'label' => 'Codigo de contrato padre',
                'attribute' => 'codigoContrato.codigo_interno',
            ],
            'descripcion',
            'estado',
            'monto',
            'fecha',
        ],
    ]) ?>

</div>
