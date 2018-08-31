<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RolProceso */
?>
<div class="rol-proceso-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'rol_proceso_id',
            'rol_id',
            'proceso_id',
            'permiso',
            'descripcion',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
