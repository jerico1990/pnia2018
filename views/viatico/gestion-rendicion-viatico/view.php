<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionGenerico */
?>
<div class="fondo-rendicion-generico-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [   
            [
                'label' => 'Tipo de Documento',
                'attribute' => 'tipoDocumentoMetacodigo.descripcion',
            ],
            [
                'label' => 'Requerimiento',
                'attribute' => 'proveedorPniaEntidad.razon_social',
            ],
            'serie_numero',
            'ruc',
            'detalle_gasto',
            'fecha_documento',
        ],
    ]) ?>

</div>
