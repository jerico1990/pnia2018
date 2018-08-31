<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Requerimiento */
?>
<div class="requerimiento-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'requerimiento_id',
            'descripcion',
            'asunto',
            'documento',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
