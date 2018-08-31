<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionCajaChica */
?>
<div class="fondo-rendicion-caja-chica-view">
 
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
            'total_rendicion',
            'fecha_rendicion',
            //'correlativo',
        ],
    ]) ?>

</div>
