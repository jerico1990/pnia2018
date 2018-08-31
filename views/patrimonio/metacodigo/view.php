<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\Metacodigo */
?>
<div class="metacodigo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'metacodigo_id',
            'nombre_lista',
            'codigo',
            'descripcion',
            'descripcion2',
            'actualizado_en',
            //'actualizado_por',
            [
                'label' => 'Actualizado por',
                'attribute' => 'actualizadoPor.alias',
            ],
            'creado_en',
            //'creado_por',
            [
                'label' => 'Creado por',
                'attribute' => 'creadoPor.alias',
            ],
        ],
    ]) ?>

</div>
