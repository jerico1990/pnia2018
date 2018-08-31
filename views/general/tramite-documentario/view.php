<?php

use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FlujoRequerimiento */
?>
<div class="tramite-documentario-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'flujo_requerimiento_id',
            'descripcion',
            //'emisor_persona_id',
            [
                'label' => 'Requerimiento',
                'attribute' => 'codigoFlujo.nombre_flujo',
            ],
            //'codigo_flujo',
            [
                'label' => 'Ubicación del requerimiento',
                'attribute' => 'codigoPaso.nombre_paso',
            ],
            //'codigo_paso',
            [
                'label' => 'Area aprobadora',
                'attribute' => 'areaAprobadora.descripcion',
            ],
            //'area_aprobadora_id',
            [
                'label' => 'Estado',
                'attribute' => 'estadoPaso.descripcion',
            ],
            //'estado_paso',
            'fecha_instanciacion',
//            [
//                'label' => 'Árbol PNIA',
//                'attribute' => 'codigoArbol.descripcion',
//            ],
            //'codigo_arbol',
            'anho_arbol',
            // 'actualizado_en',
            // 'actualizado_por',
            // 'creado_en',
            // 'creado_por',
        ],
    ]) ?>

</div>

