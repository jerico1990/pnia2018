<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre_partida',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre_presupuesto',
    ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'presupuesto_cabecera_id',
    ],/*
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'presupuesto_version_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'presupuesto_cabecera_padre_id',
    ],// */

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'p0_presupuesto_plan_ro',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'p0_presupuesto_compromiso_ro',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'p0_presupuesto_devengado_ro',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'p0_presupuesto_girado_ro',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'p0_presupuesto_pagado_ro',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'p0_presupuesto_ejecutado_ro',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'p0_presupuesto_saldo_ro',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'p0_presupuesto_saldo_anual_ro',
    ],




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