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
    //     'attribute'=>'flujo_paso_id',
    // ],
    // [
    //     'attribute' => 'flujo0.nombre_flujo'
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Flujo',
        'width' => '200px',
        'attribute' => 'nombreFlujo',
        'value' => 'flujo0.nombre_flujo'
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'flujo',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre_paso',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cantidad_dias',
    ],
    // [
    //     'attribute' => 'estadoPasoMetacodigo.descripcion'
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Estado del Paso',
        'width' => '200px',
        'attribute' => 'estadoPasoMetacodigo',
        'value' => 'estadoPasoMetacodigo.descripcion'
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'estado_paso_metacodigo',
    // ],
    // [
    //     'attribute' => 'areaResponsable.descripcion'
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Área Responsable',
        'width' => '200px',
        'attribute' => 'areaResponsableDescripcion',
        'value' => 'areaResponsable.descripcion'
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'area_responsable_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'primer_flujo_paso',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nivel',
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

        'urlCreator' => function($action, $model, $key, $index) {
            //return Url::to([$action,'id'=>$key]);
            $base = Url::base();
            $text = $base."/Viatico/flujo-paso/".$action."?id=".$key;
            return $text;
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> Yii::$app->params['textoEspañol']['tituloConfirmaciónBorrar'],
                          'data-confirm-message'=>Yii::$app->params['textoEspañol']['mensajeConfirmaciónBorrar']],
    ],

];   