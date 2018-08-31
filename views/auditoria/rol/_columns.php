<?php
use yii\helpers\Url;
use kartik\grid\GridView;

return [
//    [
//        'class' => 'kartik\grid\ExpandRowColumn',
//        'width' => '50px',
//        'value' => function ($model, $key, $index, $column) {
//            return GridView::ROW_COLLAPSED;
//        },
//        'detail' => function ($model, $key, $index, $column) {
//            return Yii::$app->controller->renderPartial('detalles',['detalles'=> $model->getProcesosDeRol($model->rol_id)]);
//            //return Yii::$app->controller->renderPartial('_lista_procesos',['searchModelProcesos'=> $model->getSearchProcesos(), 'dataProviderProcesos' => $model->getDataProviderProcesos()]);
//        },
//        'headerOptions' => ['class' => 'kartik-sheet-style'], 
//        'expandOneOnly' => true,
//    ],
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'rol_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descripcion',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'actualizado_en',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'actualizado_por',
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
                return Url::to([$action,'id' => $key ]);
        },
        // 'urlCreator' => function($action, $model, $key, $index) { 
        //     if (strcmp($action, 'update') == 0) {
        //         return Url::base()."/Auditoria/rol/".$action."?id=".$key.'&limpiar=true';
        //     }else{
        //         return Url::to([$action,'id' => $key ]);
        //     }
        // },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Vista','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar',  
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> Yii::$app->params['textoEspañol']['tituloConfirmaciónBorrar'],
                          'data-confirm-message'=>Yii::$app->params['textoEspañol']['mensajeConfirmaciónBorrar'],
                          'hidden' => true ],
                  
    ],

];   