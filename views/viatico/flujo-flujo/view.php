<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FlujoFlujo */
?>
<div class="flujo-flujo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'flujo_flujo_id',
            'nombre_flujo',
            'tipo_flujo_metacodigo',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
