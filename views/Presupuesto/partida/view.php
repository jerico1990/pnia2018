<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\Partida */
?>
<div class="partida-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'partida_id',
            'numero',
            'descripcion',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
