<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ConformidadEntregable */
?>
<div class="conformidad-entregable-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'conformidad_entregable_id',
            'contratoEntregable.descripcion',
            'staffArea.descripcion',
            'flagConformidad.descripcion',
            // 'actualizado_en',
            // 'actualizado_por',
            // 'creado_en',
            // 'creado_por',
        ],
    ]) ?>

</div>
