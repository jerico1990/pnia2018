<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\LineaNivel */
?>
<div class="linea-nivel-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'linea_nivel_id',
            'nombre_linea',
            'nivel',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
