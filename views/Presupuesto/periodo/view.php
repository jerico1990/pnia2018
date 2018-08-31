<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\Periodo */
?>
<div class="periodo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'periodo_id',
            'anho',
            'trimestre',
            'mes',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
