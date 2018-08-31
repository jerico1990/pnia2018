<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioInventario */
?>
<div class="patrimonio-inventario-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'patrimonio_inventario_id',
            //'patrimonio_item_id',
            [
                'label' => 'Item',
                'attribute' => 'patrimonioItem.descripcion',
            ],
            //'metacodigo_condicion_id',
            [
                'label' => 'Condición',
                'attribute' => 'metacodigoCondicion.descripcion',
            ],
            //'metacodigo_estado_id',
            [
                'label' => 'Estado',
                'attribute' => 'metacodigoEstado.descripcion',
            ],
            //'documento_pnia_id',
            [
                'label' => 'Nombre documento',
                'attribute' => 'documentoPnia.nombre_documento',
            ],
            //'ubicacion_id',
            [
                'label' => 'Ubicación',
                'attribute' => 'ubicacion.nombre',
            ],
            'persona_aut', //no se puede jalar porque no hay relacion aún
            'persona_inv', //no se puede jalar porque no hay relacion aún
            'fecha_inventario',
//            'actualizado_en',
//            //'actualizado_por',
//            [
//                'label' => 'Actualizado por',
//                'attribute' => 'actualizadoPor.alias',
//            ],
//            'creado_en',
//            //'creado_por',
//            [
//                'label' => 'Creado por',
//                'attribute' => 'creadoPor.alias',
//            ],
        ],
    ]) ?>

</div>
