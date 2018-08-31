<?php
use yii\helpers\Url;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'patrimonio_movimiento_id',
    // ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'patrimonio_item_id',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Item',
        'width' => '100px',
        //'attribute'=>'patrimonioItem.descripcion',
        'attribute' => 'patrimonioItemDescripcion',
        'value' => 'patrimonioItem.descripcion'
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'metacodigo_id',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Movimiento',
        'width' => '140px',
        'attribute' => 'metacodigoDescripcion',
        'value' => 'metacodigo.descripcion'
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'ubicacion_inicial_id',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
         'label' => 'Ubicación Inicial',
        'width' => '140px',
        'attribute' => 'ubicacionInicialNombre',
        'value' => 'ubicacionInicial.descripcion'
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'ubicacion_final_id',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
         'label' => 'Ubicación Final',
        'width' => '140px',
        'attribute' => 'ubicacionFinalNombre',
        'value' => 'ubicacionFinal.descripcion'
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'persona_aut',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'persona_rec',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_salida',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_retorno',
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