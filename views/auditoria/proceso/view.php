<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Proceso */
?>
<div class="proceso-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'proceso_id',
            // 'modulo_id',
            'descripcion',
            'url_accion:url',
            // 'actualizado_en',
            // 'actualizado_por',
            // 'creado_en',
            // 'creado_por',
        ],
    ]) ?>

</div>
