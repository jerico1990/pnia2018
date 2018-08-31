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
        'attribute'=>'presupuesto_cabecera_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'presupuesto_version_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre_linea',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'partida_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'presupuesto_cabecera_padre_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'presupuestoFactibilidadRo.presupuesto_plan_ro',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'header' => 'Factibilidad Ro',

        //'value'  =>  $model->presupuestoFactibilidadRo->presupuesto_id,
        'attribute'=>'presupuestoFactibilidadRo.presupuesto_plan_ro',
        'content' => function($data,$key,$model,$column){

            //$key_campo = 'p'.$column->value.'_presupuesto_plan_ro';
            $campo       = 'presupuesto_plan_ro';
            $valor_campo = 200;//$data['p'.$column->value.'_'.$campo];
            $real_index  = $model->presupuestoFactibilidadRo->presupuesto_id;//$column->value;//$data['p'.$column->value.'_presupuesto_id'];
            $index_campo = 'p'.$real_index.'_'.$campo; /// indice en la view
            $es_hoja     = false;//$data['p'.$column->value.'_es_hoja'] == 1;

            return \yii\helpers\Html::textInput(
                $index_campo,
                $valor_campo,
                [
                    'id'=> $index_campo,
                    'onchange'=> 'actualizarVariable('.$real_index.',\''.$campo.'\',\''.$index_campo.'\')',
                    'type'=>"cute-input",
                    'disabled' => $es_hoja,
                ]
            );
        },
    ],

    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'presupuesto_cabecera_id_original',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'jerarquia',
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
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   