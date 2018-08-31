<?php
use yii\helpers\Url;
use yii\helpers\Html;
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
        'attribute'=>'situacion_postor_id',
        'value' => function ($model, $key, $index, $widget) {
          return $model->getSituacionPostor();
       }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dni',
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
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ruc',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_nacimiento',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'email',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'telefono',
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
        'template'=>'{ganador} {view} {update} {delete} ',
        'buttons'=>[
          'ganador' => function ($url, $model) {
            if($model->situacion_postor_id==1){
              return Html::a('<span class="glyphicon glyphicon-thumbs-up btn-ganador" data-id="'.$model->postores_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Ganador'),'aria-label'=>"Ganador",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Ganador"
              ]);
            }
          },
        ],
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
