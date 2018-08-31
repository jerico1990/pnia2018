<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rol */
?>
<div class="rol-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'rol_id',
            'nombre',
            'descripcion',
            'actualizado_en',
            // 'actualizado_por',
            // 'creado_en',
            // 'creado_por',
        ],
    ]) ?>

</div>
