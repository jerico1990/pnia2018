<?php
use yii\helpers\Url;

return [
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
//        [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'fondo_rendicion_generico_id',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'fondo_rendicion_viatico_id',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'fondo_rendicion_caja_chica_id',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'fondo_rendicion_encargo_id',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'tipo_afecto_igv_metacodigo',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Fondo de Viático',
        'width' => '300px',
        'attribute'=>'descripcionFondoRendicion', 
        'value' => 'fondoRendicionViatico.fondoFondo.motivo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Número de Serie',
        'width' => '300px',
        'attribute'=>'serie_numero', 
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Detalle del Gasto',
        'width' => '300px',
        'attribute'=>'detalle_gasto', 
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tipo_bien_servicio_metacodigo',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tipo_documento_metacodigo',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'proveedor_pnia_entidad_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'importe',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'importe_gravado',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'importe_no_gravado',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'serie_numero',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ruc',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'detalle_gasto',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_documento',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'actualizado_en',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'actualizado_por',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'creado_en',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'creado_por',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'urlCreator' => function($action, $model, $key, $index) {
            //return Url::to([$action,'id'=>$key]);
            $base = Url::base();
            $text = $base."/Viatico/gestion-rendicion-viatico/".$action."?id=".$key;
            return $text;
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eliminar', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> Yii::$app->params['textoEspañol']['tituloConfirmaciónBorrar'],
                          'data-confirm-message'=>Yii::$app->params['textoEspañol']['mensajeConfirmaciónBorrar']],
    ],

];   