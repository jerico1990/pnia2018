<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\Linea */
?>
<div class="linea-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'linea_id',
            'titulo',
            'numeracion',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
