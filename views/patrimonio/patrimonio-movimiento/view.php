<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioMovimiento */
?>
<div class="patrimonio-movimiento-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'patrimonio_movimiento_id',
            //'patrimonio_item_id',
            [
                'label' => 'Item',
                'attribute' => 'patrimonioItem.descripcion',
            ],
            //'metacodigo_id',
            [
                'label' => 'Condición',
                'attribute' => 'metacodigo.descripcion',
            ],
            //'ubicacion_inicial_id',
            [
                'label' => 'Ubicación Inicial',
                'attribute' => 'ubicacionInicial.nombre',
            ],
            //'ubicacion_final_id',
            [
                'label' => 'Ubicación Final',
                'attribute' => 'ubicacionFinal.nombre',
            ],
            'persona_aut', //no hay relación
            'persona_rec',
            'fecha_salida',
            'fecha_retorno',
        ],
    ]) ?>

</div>
