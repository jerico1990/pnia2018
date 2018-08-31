<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionEncargo */
?>
<div class="fondo-rendicion-encargo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Fondo',
                'attribute' => 'fondoFondo.motivo',
            ],
            [
                'label' => 'Requerimiento',
                'attribute' => 'flujoRequerimiento.descripcion',
            ],
            'correlativo',
            'total',
            'fecha_rendicion',
            //'informe_actividades_logros',
        ],
    ]) ?>

</div>
