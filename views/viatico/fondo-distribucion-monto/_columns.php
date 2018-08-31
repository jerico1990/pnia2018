<?php
use yii\helpers\Url;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    // [
    //     'class' => 'kartik\grid\SerialColumn',
    //     'width' => '30px',
    // ],
    //     [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'fondo_distribucion_monto_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'escala_metacodigo',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'concepto_metacodigo',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Concepto',
        'width' => '300px',
        'attribute'=>'conceptoMetacodigoDesc', 
        'value' => 'conceptoMetacodigo.descripcion',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'destino_ini_ubigeo',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Origen',
        'width' => '300px',
        'attribute'=>'ubigeoOrigen', 
        'value' => 'destinoIniUbigeo.nombre',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'destino_fin_ubigeo',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Destino',
        'width' => '300px',
        'attribute'=>'ubigeoDestino', 
        'value' => 'destinoFinUbigeo.nombre',
    ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'monto_determinado',
     ],
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
        'viewOptions'=>['role'=>'modal-remote','title'=>'Vista','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar',  
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> Yii::$app->params['textoEspañol']['tituloConfirmaciónBorrar'],
                          'data-confirm-message'=>Yii::$app->params['textoEspañol']['mensajeConfirmaciónBorrar']],  
    ],

];   