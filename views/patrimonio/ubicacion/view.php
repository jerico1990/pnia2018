<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\Ubicacion */
?>
<div class="ubicacion-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'ubicacion_id',
            // 'ubicacion_padre_id',
            'codigo',
            'nombre',
            'descripcion',
            // 'actualizado_en',
            // 'actualizado_por',
            // 'creado_en',
            // 'creado_por',
        ],
    ]) ?>

</div>
