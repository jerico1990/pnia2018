<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Adjudicacion */
?>
<div class="adjudicacion-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'adjudicacion_id',
            'requerimiento_detalle_id',
            'requerimiento_id',
            'situacion_adjudicacion_id',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
