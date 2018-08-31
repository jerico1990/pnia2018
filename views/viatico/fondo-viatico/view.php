<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoFondo */
?>
<div class="fondo-caja-chica">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Motivo',
                'attribute' => 'motivo',
            ],
//            [
//                'label' => 'Saldo Anterior',
//                'attribute' => 'saldo_anterior_bienes',
//            ],
//            [
//                'label' => 'Saldo Actual',
//                'attribute' => 'saldo_actual_bienes',
//            ],
            'total_entregado',
        ],
    ]) ?>

</div>
