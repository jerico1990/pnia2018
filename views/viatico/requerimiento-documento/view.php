<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\RequerimientoDocumento */
?>
<div class="requerimiento-documento-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'requerimiento_documento_id',
            'flujo_requerimiento_id',
            'documento_pnia_id',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
