<?php
use yii\helpers\Url;
use kartik\grid\GridView;

return [
    // [
    //     'class' => 'kartik\grid\ExpandRowColumn',
    //     'width' => '50px',
    //     'value' => function ($model, $key, $index, $column) {
    //         return GridView::ROW_COLLAPSED;
    //     },
    //     'detail' => 'hola',
    //     'headerOptions' => ['class' => 'kartik-sheet-style'], 
    //     'expandOneOnly' => true,
    // ],
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'value' => function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        // es necesario realizar la obtención de datos por medio de la declaración de funciones anonimas como se muestra acontinuación.
        // model corresponde al modelo seleccionado
        // key corresponde al id
        // index es el indice de la fila tabla q vemos (comienza en 0) 
        // column es el indice de la columna tabla
        'detail' => function ($model, $key, $index, $column) {
            return Yii::$app->controller->renderPartial('detalles',['procesos'=> $model->procesos]);
            //return Yii::$app->controller->renderPartial('_lista_procesos',['searchModelProcesos'=> $model->getSearchProcesos(), 'dataProviderProcesos' => $model->getDataProviderProcesos()]);
        },
        //'detail' => Yii::$app->controller->renderPartial('_lista_procesos', ['dataProviderProcesos' => $dataProviderProcesos, 'searchModelProcesos' => $searchModelProcesos]),
        // Asi tendria que estar el detail para poder renderizar el gridview en _lista_procesos, las variables de $dataProviderProcesos y $searchModelProcesos deben llegar hasta aqui, por eso
        //una opcion es pasar todo esto adentro del mismo index, para ya no requerir este archivo _columns, pero vean si pueden hacer que lleguen hasta aqui estas variables.
        //las instrucciones de _lista_procesos.php estan en el mismo archivo
        'headerOptions' => ['class' => 'kartik-sheet-style'], 
        'expandOneOnly' => true,
    ],

    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    // [
    //     'class' => 'kartik\grid\SerialColumn',
    //     'width' => '30px',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'modulo_id',
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