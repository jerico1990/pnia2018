<?php
use yii\helpers\Url;

return [
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
    // [
    //     'class' => 'kartik\grid\SerialColumn',
    //     'width' => '30px',
    // ],
    //     [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'fondo_viatico_detalle_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'destino_inicial_ubigeo',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'destino_final_ubigeo',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Destino Inicial',
        'width' => '300px',
        'attribute'=>'inicialUbigeo', 
        'value' => 'destinoInicialUbigeo.nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Destino Final',
        'width' => '300px',
        'attribute'=>'finalUbigeo', 
        'value' => 'destinoFinalUbigeo.nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'numero_dias',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'monto',
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
                //return Url::to([$action,'id'=>$key]);
            $base = Url::base();
            $text = $base."/Viatico/fondo-viatico-detalle/".$action."?id=".$key;
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