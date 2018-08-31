<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\UnidadMedida */
?>
<div class="unidad-medida-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'unidad_medida_id',
            'unidad_medida_descripcion',
            'estado_regitro',
        ],
    ]) ?>

</div>
