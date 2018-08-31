<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionViatico */
?>
<div class="fondo-rendicion-viatico-view">
 
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
            'anticipo_recibido',
            'fecha_rendicion',
            //'informe_actividades_logros',
        ],
    ]) ?>

</div>
