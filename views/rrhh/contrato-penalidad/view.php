<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoPenalidad */
?>
<div class="contrato-penalidad-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'contrato_penalidad_id',
            //'codigo_contrato',
            [
                'label' => 'Codigo de contrato padre',
                'attribute' => 'codigoContrato.codigo_interno',
            ],
            'descripcion',
            'monto_penalidad',
        ],
    ]) ?>

</div>
