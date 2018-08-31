<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioItem */
?>
<div class="patrimonio-item-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'patrimonio_item_id',
            //'patrimonio_clase_id',
            [
                'label' => 'Clase',
                'attribute' => 'patrimonioClase.nombre',
            ],
            //'metacodigo_id',
            [
                'label' => 'Condición',
                'attribute' => 'metacodigo.descripcion',
            ],
            //'documento_pnia_id',
            [
                'label' => 'Documento',
                'attribute' => 'documentoPnia.nombre_documento',
            ],
            'codigo',
            'descripcion',
            'fecha_alta',
            'fecha_baja',
            'valor_historico',
            'marca',
            'modelo',
            'serie',
//            'actualizado_en',
//            'creado_en',
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
