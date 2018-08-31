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
        'attribute'=>'adjudicacion_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'requerimiento_detalle_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'requerimiento_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'situacion_adjudicacion_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'actualizado_en',
    ],
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
        'template'=>'{ingresar-adjudicacion} ',
        'buttons'=>[
          'ingresar-adjudicacion' => function ($url, $model) {

              return Html::a('<span class="glyphicon glyphicon-share-alt " ></span>', ['Adquisicion/adjudicacion/update-autorizacion-adjudicacion','id'=>$model->adjudicacion_id], [
                      'title' => Yii::t('yii', 'Ingresar adjudicación'),'aria-label'=>"Ingresar adjudicación",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Ingresar adjudicación"
              ]);

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
