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
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'staff_persona_id',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'codigo_pnia',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombres',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'apellido_paterno',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'apellido_materno',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'RUC',
        'attribute'=>'Ruc',
        'value' => 'ruc'
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cuenta_bancaria',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Entidad Financiera',
        'attribute'=>'razon_social_EF',
        'value' => 'pniaEntFinanciera.razon_social'
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