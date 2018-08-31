<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionGenerico */
?>
<div class="fondo-rendicion-generico-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fondo_rendicion_generico_id',
            'fondo_rendicion_viatico_id',
            'fondo_rendicion_caja_chica_id',
            'fondo_rendicion_encargo_id',
            'tipo_afecto_igv_metacodigo',
            'tipo_bien_servicio_metacodigo',
            'tipo_documento_metacodigo',
            'proveedor_pnia_entidad_id',
            'importe',
            'importe_gravado',
            'importe_no_gravado',
            'serie_numero',
            'ruc',
            'detalle_gasto',
            'fecha_documento',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
